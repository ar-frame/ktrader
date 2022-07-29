# !/usr/bin/env python
# coding: utf-8

import hashlib
import hmac
import json
import logging
import time
import datetime

# pip install -U websocket_client
# from websocket import WebSocketApp
import websocket
logging.basicConfig(level=logging.INFO)
logger = logging.getLogger(__name__)

import os
import sys

from dbconn import MongoDB
from log import writeLog
ws = None

if (len(sys.argv) < 2) :
    print('usdt pair not set,such as eth,btc,eos')
    exit()
cpair = sys.argv[1]

nowHour = datetime.datetime.now().strftime('%Y%m%d%H')
db_trades = MongoDB('bigdata-' + cpair, 'gataio_eth_trades_h' + nowHour, dbHost = '127.0.0.1' , dbUser = None)

class GateWebSocketApp(websocket.WebSocketApp):

    def __init__(self, url, api_key, api_secret, **kwargs):
        super(GateWebSocketApp, self).__init__(url, **kwargs)
        self._api_key = api_key
        self._api_secret = api_secret

    def _send_ping(self, interval, event):
        while not event.wait(interval):
            self.last_ping_tm = time.time()
            if self.sock:
                try:
                    self.sock.ping()
                except Exception as ex:
                    logger.warning("send_ping routine terminated: {}".format(ex))
                    break
                try:
                    self._request("spot.ping", auth_required=False)
                except Exception as e:
                    raise e

    def _request(self, channel, event=None, payload=None, auth_required=True):
        current_time = int(time.time())
        data = {
            "time": current_time,
            "channel": channel,
            "event": event,
            "payload": payload,
        }
        if auth_required:
            message = 'channel=%s&event=%s&time=%d' % (channel, event, current_time)
            data['auth'] = {
                "method": "api_key",
                "KEY": self._api_key,
                "SIGN": self.get_sign(message),
            }
        data = json.dumps(data)
        logger.info('request: %s', data)
        self.send(data)

    def get_sign(self, message):
        h = hmac.new(self._api_secret.encode("utf8"), message.encode("utf8"), hashlib.sha512)
        return h.hexdigest()

    def subscribe(self, channel, payload=None, auth_required=True):
        self._request(channel, "subscribe", payload, auth_required)

    def unsubscribe(self, channel, payload=None, auth_required=True):
        self._request(channel, "unsubscribe", payload, auth_required)


def on_message(ws, message):
    # type: (GateWebSocketApp, str) -> None
    # handle whatever message you received
    # logger.info("message received from server: {}".format(message))

    global db_trades
    print("msg back:%s" % message)
    mesdict = json.loads(message)
    # print(mesdict)

    if 'result' in mesdict:
        result = mesdict['result']

        # {'id': 3888909283, 'create_time': 1658977529, 'create_time_ms': '1658977529034.0', 'side': 'buy', 'currency_pair': 'BTC_USDT', 'amount': '0.0002', 'price': '23260'}
        if 'id' in result:
            nowTime = datetime.datetime.now().strftime('%Y%m%d%H%M%S')
            insert_data = {"id": result['id'], "time": result['create_time'], "price": result['price'], "amount": result['amount'], "type": result['side'], "timedate": nowTime}
            print("insert data:", insert_data)

            nowHour = datetime.datetime.now().strftime('%Y%m%d%H')
            colName = 'gataio_eth_trades_h' + nowHour
            db_trades.set_current_collections(colName)
            db_trades.insert(insert_data)

def on_open(ws):
    global cpair
    # type: (GateWebSocketApp) -> None
    # subscribe to channels interested
    logger.info('websocket connected')
    ws.subscribe("spot.trades", [cpair.upper()+"_USDT"], False)

def on_close(ws):
    print("### closed ###")

def on_error(ws, error):
    print("ws error %s" % error)
    close_conn()

def close_conn():
    global ws
    try:
        if ws is not None:
            ws.close()
            ws = None
    except Exception as e:
        ws = None
        writeErrorLog(e)

def connect():
    global ws
    try:
        if ws is None :
            print('start connect...')
            logging.basicConfig(format="%(asctime)s - %(message)s", level=logging.DEBUG)
            websocket.setdefaulttimeout(3)
            ws = GateWebSocketApp("wss://api.gateio.ws/ws/v4/",
                                   "YOUR_API_KEY",
                                   "YOUR_API_SECRET",
                                   on_open=on_open,
                                   on_message=on_message,
                                   on_error=on_error,
                                    on_close = on_close)
            ws.run_forever(ping_interval=5)

    except Exception as e:
        writeErrorLog(e)
        time.sleep(1)
        connect()

def writeErrorLog(e):
    curpath = os.path.dirname(os.path.realpath(__file__))
    logpath = os.path.join(curpath, "data/wsexception.log")
    writeLog(logpath, e)

if __name__ == "__main__":
    while True:
        if ws is None:
            connect()
        time.sleep(1)
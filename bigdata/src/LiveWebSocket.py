import websocket
import json
import random
import hmac
import base64
import hashlib
import datetime
from dbconn import MongoDB
from log import writeLog
try:
    import thread
except ImportError:
    import _thread as thread
import time
import os
import sys
ws = None

if (len(sys.argv) < 2) :
    print('usdt pair not set,such as eth,btc,eos')
    exit()
cpair = sys.argv[1]

nowHour = datetime.datetime.now().strftime('%Y%m%d%H')
db_trades = MongoDB('bigdata-' + cpair, 'gataio_eth_trades_h' + nowHour, dbHost = '127.0.0.1' , dbUser = None)

#db_trades = MongoDB('bigdata', 'gataio_eth_trades_h' + nowHour)
def get_sign(secret_key, message):
	h = hmac.new(bytes(secret_key, 'utf-8'), bytes(message, 'utf-8'), hashlib.sha512)
	return str(base64.b64encode(h.digest()))

def on_message(ws, message):
    global db_trades
    print("msg back:%s" % message)
    mesdict = json.loads(message)


    if 'params' in mesdict:

        nowHour = datetime.datetime.now().strftime('%Y%m%d%H')
        colName = 'gataio_eth_trades_h' + nowHour
        db_trades.set_current_collections(colName)
        # db_trades = MongoDB('bigdata', )

        params = mesdict['params']

        data = params[1]
        nowTime = datetime.datetime.now().strftime('%Y%m%d%H%M%S')
        for item in data:
            item['timedate'] = nowTime

        db_trades.insert(data)


def on_error(ws, error):
    print("ws error %s" % error)
    close_conn()

def on_close(ws):
    print("### closed ###")

def on_open(ws):
    markid = random.randint(0,99999)
    def run(*args):
        datatrades = {'id': markid, 'method': "trades.subscribe", 'params': [cpair.upper()+"_USDT"]}
        ws.send(json.dumps(datatrades))

    def runping(*args):
        while True:
            time.sleep(3)
            datatrades = {'id': markid, 'method': "server.ping", 'params': []}
            ws.send(json.dumps(datatrades))

    thread.start_new_thread(run, ())
    thread.start_new_thread(runping, ())

def connect():
    global ws
    try:
        if ws is None :
            print('start connect')
            ws = websocket.WebSocketApp("wss://webws.gateio.live/v3/?v=914035",
                                on_message = on_message,
                                on_error = on_error,
                                on_close = on_close)
            ws.on_open = on_open
            ws.run_forever()

    except Exception as e:
        writeErrorLog(e)

        time.sleep(1)
        connect()

def close_conn():
    global ws
    try:
        if ws is not None:
            ws.close()
            ws = None
    except Exception as e:
        writeErrorLog(e)

def writeErrorLog(e):
    curpath = os.path.dirname(os.path.realpath(__file__))
    logpath = os.path.join(curpath, "data/wsexception.log")
    writeLog(logpath, e)

if __name__ == "__main__":
    while True:
        if ws is None:
            connect()
        time.sleep(1)

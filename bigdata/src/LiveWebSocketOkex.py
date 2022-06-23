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
import zlib
import cfg
ws = None
nowHour = datetime.datetime.now().strftime('%Y%m%d%H')
# db_trades = MongoDB('bigdata', 'gataio_eth_trades_h' + nowHour, dbHost = '127.0.0.1' , dbUser = None)
db_trades = MongoDB('bigdata', 'gataio_eth_trades_h' + nowHour)
def inflate(data):
    decompress = zlib.decompressobj(
            -zlib.MAX_WBITS  # see above
    )
    inflated = decompress.decompress(data)
    inflated += decompress.flush()
    return inflated

def get_sign(secret_key, message):
	h = hmac.new(bytes(secret_key, 'utf-8'), bytes(message, 'utf-8'), hashlib.sha512)
	return str(base64.b64encode(h.digest()))

def on_message(ws, message): 
    global db_trades
    mesStr = inflate(message)
    print("msg back:%s" % mesStr)
    mesdict = json.loads(mesStr.decode())

    if 'data' in mesdict:
        # db_trades = MongoDB('data_okex', 'gataio_eth_trades_h' + nowHour)

        nowHour = datetime.datetime.now().strftime('%Y%m%d%H')
        colName = 'gataio_eth_trades_h' + nowHour
        db_trades.set_current_collections(colName)

        data = mesdict['data']

        nowTime = datetime.datetime.now().strftime('%Y%m%d%H%M%S')

        for item in data:
            item['timedate'] = nowTime
            if item['side'] == 1:
                item['type'] = 'sell'
            else:
                item['type'] = 'buy'

        db_trades.insert(data)


def on_error(ws, error):
    print("ws error %s" % error)
    close_conn()

def on_close(ws):
    print("### closed ###")

def on_open(ws):
    markid = random.randint(0,99999)
    def run(*args):
        # datatrades = {'id': markid, 'method': "trades.subscribe", 'params': ["ETH_USDT"]}

        dataTicker = {"event":'addChannel',"parameters":{"base":"eth","binary":"1","product":"spot","quote":"usdt","type":"deal"}}

        ws.send(json.dumps(dataTicker))

    def runping(*args):
        while True:
            time.sleep(3)
            datatrades = {'event':'ping'}
            ws.send(json.dumps(datatrades))

    thread.start_new_thread(run, ())
    thread.start_new_thread(runping, ())

def connect():
    global ws
    try:
        if ws is None :
            print('start connect')
            ws = websocket.WebSocketApp("wss://okexcomreal.bafang.com:10441/websocket",
                                on_message = on_message,
                                on_error = on_error,
                                on_close = on_close)
            ws.on_open = on_open
            ws.run_forever()
    except Exception as e:
        writeLog("wsexception.log", e)
        time.sleep(1)
        connect()

def close_conn():
    global ws
    try:
        if ws is not None:
            ws.close()
            ws = None
    except Exception as e:
        writeLog("wsexception.log", e)

if __name__ == "__main__":
    while True:
        if ws is None:
            connect()
        time.sleep(1)
# -*- coding: utf-8 -*-
#author: dpbtrader

from Gateio import GateWs
from dbconn import MongoDB
import random
import time
import datetime
import json
from log import writeLog
def startJob():
    try:
        gate=GateWs("wss://ws.gateio.io/v3/", "your key", "your secret.")
        # 获取深度
        depths = gate.gateRequest(random.randint(0,99999),'depth.query',["ETH_USDT",100,"0.0001"])
        depths = json.loads(depths)

        asks = depths['result']['asks']
        bids = depths['result']['bids']

        nowHour = datetime.datetime.now().strftime('%Y%m%d%H')

        db_asks = MongoDB('bigdata', 'gataio_eth_asks_h' + nowHour)
        db_bids = MongoDB('bigdata', 'gataio_eth_bids_h' + nowHour)

        nowTime = datetime.datetime.now().strftime('%Y%m%d%H%M%S')

        # 卖单
        asks_str = json.dumps(asks)
        askdata = {"time": nowTime, "data": asks_str, "len": len(asks)}
        db_asks.insert(askdata)

        # 买单
        bids_str = json.dumps(bids)
        biddata = {"time": nowTime, "data": bids_str, "len": len(bids)}
        db_bids.insert(biddata)

        # clos = db_asks.get_all_collections()
        
        # print(clos, list(db_asks.query_all()))

        # print(type(asks), len(asks))
        print('get ok %s' % nowTime)

    except Exception as e:
        print("exception has occur", e)
        writeLog("exception.log", e)

if __name__ == '__main__':
    i = 0
    while True:
        print(i) 
        startJob()
        i = i + 1
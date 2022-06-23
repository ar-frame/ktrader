#!/usr/bin/env python3.6
# -*- coding: utf-8 -*-
'Characteristic fot eth_usdt trade moudule'
__author__ = 'assnr'
from dbconn import MongoDB
import random
import time
import datetime
import json
from log import writeLog
import pandas as pd
import sys
from Simulate import Simulate
import cfg
import func
class Characteristic:
    def __init__(self, tradeVariety):
        nowHour = datetime.datetime.now().strftime('%Y%m%d%H')
        self.dbc = {}

        mongo = cfg.getMongo(tradeVariety)
        self.db_bigdata = MongoDB(mongo.get('DB'), 'gataio_eth_trades_h' + nowHour, mongo.get('DB_HOST'), mongo.get('DB_USER'), mongo.get('DB_PASS'))

        # self.db_bigdata = MongoDB('bigdata', 'gataio_eth_asks_h' + nowHour)
        self.sim = Simulate(tradeVariety)

    def getLastTimeAreaData(self):
        data = self.dbc['data']
        return data.loc[data.index[-1]]


    def addCacheData(self, adddata):
        data = pd.concat([self.dbc['data'], pd.DataFrame(adddata)], ignore_index = True, axis = 0)
        f = '%Y-%m-%d %H:%M:%S'
        # now = time.strftime(f)
        now = datetime.datetime.now().strftime(f)
        ps = datetime.datetime.strptime(now, f)
        stimeStart = (ps+datetime.timedelta(minutes=-480)).strftime(f)

        maxT = func.transF1ToTimedateF2(stimeStart)
       
        data = data.loc[data.timedate.astype('int64') >= int(maxT)]
        print(maxT, len(data))
        self.dbc['data'] = data


    def cacheTimeArea(self, DateStart, DateEnd):
        f = '%Y-%m-%d %H:%M:%S'
        ps = datetime.datetime.strptime(DateStart, f)
        stimeStart = (ps+datetime.timedelta(minutes=-480)).strftime(f)
        ps = datetime.datetime.strptime(DateEnd, f)
        stimeEnd = (ps+datetime.timedelta(minutes=1)).strftime(f)


        timeDateStart = func.transF1ToTimedateF2(stimeStart)
        timeDateEnd = func.transF1ToTimedateF2(stimeEnd)

        startC = int(timeDateStart[0:10])
       

        endC = int(timeDateEnd[0:10])

        print('load data...')
        cles = self.sim.get_trade_cols()
        data = pd.DataFrame([])
        for colName in cles:
           
            colTime = int(colName[-10:])
            if colTime >= startC and colTime <= endC:
                print(colName)
                self.db_bigdata.set_current_collections(colName)
                list_db_data = list(self.db_bigdata.query_all())
                if len(data) == 0:
                    data = pd.DataFrame(pd.DataFrame(list_db_data))
                else:
                    data = pd.concat([data, pd.DataFrame(list_db_data)], ignore_index = True, axis = 0)
                    # data.append(pd.DataFrame(list_db_data), ignore_index=True)
        self.dbc['data'] = data
        print('load data ok')

    def searchTimeArea(self, timeDateStart, timeDateEnd):
        listdataF = self.dbc.get('data')

        listdataF = listdataF[listdataF.timedate.astype('int64') < int(timeDateEnd)]
        listdataF = listdataF[listdataF.timedate.astype('int64') >= int(timeDateStart)]

        return listdataF
       
    def cacheDb(self, dbcol):
        if dbcol in self.dbc:
            return self.dbc.get(dbcol)
        else:
            return None

if __name__ == "__main__":
    cha = Characteristic()
    # dl = cha.searchTimeArea('20190118113500', '20190118135000')
    # dl = cha.searchTimeArea('20190118000000', '20190118001000')
    # dl = cha.searchTimeArea('20190118000000', '20190118001000')
    # dl = cha.searchTimeArea('20190118000000', '20190118001000')
    # dl = cha.searchTimeArea('20190118000000', '20190118001000')
    # dl = cha.searchTimeArea('20190118000000', '20190118001000')
    # dl = cha.searchTimeArea('20190118000000', '20190118001000')
    # dl = cha.searchTimeArea('20190118000000', '20190118001000')
    # dl = cha.searchTimeArea('20190118000000', '20190118001000')
    # dl = cha.searchTimeArea('20190118000000', '20190118001000')


    for i in range(1):
        # print(i)

        timestart = 20190118000000 + i * 100
        timeend = 20190118000100 + i * 100
        dl = cha.searchTimeArea(str(timestart), str(timeend))
        cha.sim.getSummay(dl)

    

#!/usr/bin/env python3.6
# -*- coding: utf-8 -*-

'test for dev moudule'
__author__ = 'assnr'
import numpy as np
import pandas as pd
import matplotlib.pyplot as plt
from dbconn import MongoDB
import random
import time
import datetime
import json
from log import writeLog
import pandas as pd
import sys
from Simulate import Simulate
import math
import copy
from decimal import Decimal
from Characteristic import Characteristic

from TradeSave import TradeSave
try:
    import thread
except ImportError:
    import _thread as thread
import os
import func
import cfg


class Paint:

    def __init__(self, tradeVariety):
        self.startTime = time.time()

        nowHour = datetime.datetime.now().strftime('%Y%m%d%H')
        self.kw = 80
        # print(nowHour)
        # self.db_bigdata = MongoDB('bigdata', 'gataio_eth_trades_h' + nowHour)
        # self.db_bigdata = MongoDB('bigdata', 'gataio_eth_trades_h2019011918')
        mongo = cfg.getMongo(tradeVariety)
        self.db_bigdata = MongoDB(mongo.get('DB'), 'gataio_eth_trades_h' + nowHour, mongo.get('DB_HOST'), mongo.get('DB_USER'), mongo.get('DB_PASS'))

        self.sim = Simulate(tradeVariety)
        self.cha = Characteristic(tradeVariety)
        self.ts = TradeSave()
        self.threads = []

        self.orders = []
        self.getPointCount = 0
        self.lastPointCode = None
        self.initUsdtUint = 0

        self.tradeVariety = tradeVariety

        self.midcresult = {"mc": 0, "mcMax": 0, "mcMin": 0}

    def drawBase(self, data, dataBase, ah, aw, kh, kw):

        if len(data) == 0:
            print('data is empty')
            return None
        
        buydata = data[data.type == 'buy']
        selldata = data[data.type == 'sell']

        buydata_base = dataBase[dataBase.type == 'buy']
        selldata_base = dataBase[dataBase.type == 'sell']

        # print(data)

        maxprice = dataBase.price.astype('float64').max()
        minprice = dataBase.price.astype('float64').min()

        maxamount = dataBase.amount.astype('float64').max()
        minamount = dataBase.amount.astype('float64').min()
        
        height = math.ceil( (maxprice - minprice) / 0.01 )


        height = ah
        width = aw

        # height = 12

        nd = np.zeros((height, width))

        amountBuyTotal = self.getIndexNum(dataBase, buydata, height, width)
        amountSellTotal = self.getIndexNum(dataBase, selldata, height, width)

        amountBuyTotal_base = self.getIndexNum(dataBase, buydata_base, height, width)
        amountSellTotal_base = self.getIndexNum(dataBase, selldata_base, height, width)

        if len(buydata_base) > 0 and len(selldata_base) > 0:
            if amountBuyTotal_base.amount.max() > amountSellTotal_base.amount.max():
                maxTotal = amountBuyTotal_base.amount.max()
            else:
                maxTotal = amountSellTotal_base.amount.max()
        elif len(buydata_base) > 0:
            maxTotal = amountBuyTotal_base.amount.max()
        else:
            maxTotal = amountSellTotal_base.amount.max()

        amountBuyTotal = self.reFormatAmount(amountBuyTotal, width, maxTotal)
    
        amountSellTotal = self.reFormatAmount(amountSellTotal, width, maxTotal)

        nd_leftPriceAmount = self.getNdPriceAmount(amountBuyTotal, height)
        nd_rightPriceAmount = self.getNdPriceAmount(amountSellTotal, height)

        nd_buy = self.transDfAmountToDdarry(amountBuyTotal, height, width)
        nd_sell = self.transDfAmountToDdarry(amountSellTotal, height, width)

        nd_sell = self.leftToRight(nd_sell)
        nd_title = self.getNdTitle(dataBase, height)
        # print(nd_title)
        # exit()

       

        nd_show = np.concatenate((nd_leftPriceAmount, nd_buy , nd_title, nd_sell, nd_rightPriceAmount), axis = 1)

        nd_f = self.topToBottom(nd_show)

        nd_kline = self.drawKline(data, dataBase, kh, kw)
        nd_f = np.concatenate((nd_f, nd_kline), axis = 1)

      
        summary = self.sim.getSummayObj(data)

        bottomTitle = self.getBottomTitle(summary, nd_f.shape)

        nd_f = np.concatenate((nd_f, bottomTitle), axis = 0)


        return nd_f


        tstr = self.transNdToStr(nd_f)

        # print(nd_title)

        f = '%Y-%m-%d %H:%M:%S'
        now = time.strftime(f)
      
        times = data.timedate.astype("int64").min()
        return {"tstr": tstr, 'now': now, 'times': times}
        # print(tstr)

    def drawBaseIndexCode(self, data, dataBase, ah, aw, kh, kw):
        self.printRunTime('6.01')
        if len(data) == 0:
            print('data is empty')
            return None
        
        buydata = data[data.type == 'buy']
        selldata = data[data.type == 'sell']

        buydata_base = dataBase[dataBase.type == 'buy']
        selldata_base = dataBase[dataBase.type == 'sell']
        self.printRunTime('6.02')
        # print(data)

        maxprice = dataBase.price.astype('float64').max()
        minprice = dataBase.price.astype('float64').min()

        maxamount = dataBase.amount.astype('float64').max()
        minamount = dataBase.amount.astype('float64').min()
        
        height = math.ceil( (maxprice - minprice) / 0.01 )


        height = ah
        width = aw

        # height = 12

        nd = np.zeros((height, width))

        amountBuyTotal = self.getIndexNum(dataBase, buydata, height, width)
        amountSellTotal = self.getIndexNum(dataBase, selldata, height, width)
        self.printRunTime('6.03')
        amountBuyTotal_base = self.getIndexNum(dataBase, buydata_base, height, width)
        amountSellTotal_base = self.getIndexNum(dataBase, selldata_base, height, width)
        self.printRunTime('6.04')
        if len(buydata_base) > 0 and len(selldata_base) > 0:
            if amountBuyTotal_base.amount.max() > amountSellTotal_base.amount.max():
                maxTotal = amountBuyTotal_base.amount.max()
            else:
                maxTotal = amountSellTotal_base.amount.max()
        elif len(buydata_base) > 0:
            maxTotal = amountBuyTotal_base.amount.max()
        else:
            maxTotal = amountSellTotal_base.amount.max()
        self.printRunTime('6.05')
        amountBuyTotal = self.reFormatAmount(amountBuyTotal, width, maxTotal)
    
        amountSellTotal = self.reFormatAmount(amountSellTotal, width, maxTotal)

        # nd_leftPriceAmount = self.getNdPriceAmount(amountBuyTotal, height)
        # nd_rightPriceAmount = self.getNdPriceAmount(amountSellTotal, height)

        nd_buy = self.transDfAmountToDdarry(amountBuyTotal, height, width)
        nd_sell = self.transDfAmountToDdarry(amountSellTotal, height, width)
        self.printRunTime('6.06')
        nd_sell = self.leftToRight(nd_sell)
        # nd_title = self.getNdTitle(dataBase, height)
        # print(nd_title)
        # exit()

        # code_buy = self.transNdToCode(self.topToBottom(nd_buy))
        # code_sell = self.transNdToCode(self.topToBottom(nd_sell))

        nd_show = np.concatenate((nd_buy, nd_sell), axis = 1)
        self.printRunTime('6.07')
        nd_f = self.topToBottom(nd_show)

        nd_kline = self.drawKline(data, dataBase, kh, kw)
        self.printRunTime('6.08')
        # code_kline = self.transNdToCode(nd_kline)


        # powerBuy = (code_buy - code_sell) / code_sell

        # powerSell = (code_sell - code_buy) / code_buy

        # print(code_buy, code_sell, code_kline)

       

        nd_f = np.concatenate((nd_f, nd_kline), axis = 1)
        self.printRunTime('6.09')
        # print(self.transNdToStr(nd_f))
        
        nd = self.transNdToCode(nd_f)
        self.printRunTime('6.10')
        return nd
        # summary = self.sim.getSummayObj(data)

        # bottomTitle = self.getBottomTitle(summary, nd_f.shape)

        # nd_f = np.concatenate((nd_f, bottomTitle), axis = 0)
        # return nd_f

    def getBottomTitle(self, summary, shape):
        colNum = shape[1]
        listarr = []
        per = 25
        for i in range(colNum):
            if i == 0 :
                listarr.append(str(summary['date']))
            elif i == 1 * per:
                listarr.append(str(summary['desUsdt']))
            elif i == 2 * per:
                listarr.append(str(summary['dealUsdt']))
            else:
                listarr.append('NOT_PRINT')
        return np.array(listarr).reshape((1, colNum))
        

    def drawline(self, data):

        if len(data) == 0:
            print('data is empty')
            return False
        
        buydata = data[data.type == 'buy']
        selldata = data[data.type == 'sell']

        # print(data)

        maxprice = data.price.astype('float64').max()
        minprice = data.price.astype('float64').min()

        maxamount = data.amount.astype('float64').max()
        minamount = data.amount.astype('float64').min()
        
        height = math.ceil( (maxprice - minprice) / 0.01 )


        height = 20
        width = 80

        # height = 12

        nd = np.zeros((height, width))

        amountBuyTotal = self.getIndexNum(data, buydata, height, width)
        amountSellTotal = self.getIndexNum(data, selldata, height, width)

        if len(buydata) > 0 and len(selldata) > 0:
            if amountBuyTotal.amount.max() > amountSellTotal.amount.max():
                maxTotal = amountBuyTotal.amount.max()
            else:
                maxTotal = amountSellTotal.amount.max()
        elif len(buydata) > 0:
            maxTotal = amountBuyTotal.amount.max()
        else:
            maxTotal = amountSellTotal.amount.max()

        amountBuyTotal = self.reFormatAmount(amountBuyTotal, width, maxTotal)
      

        amountSellTotal = self.reFormatAmount(amountSellTotal, width, maxTotal)

        nd_leftPriceAmount = self.getNdPriceAmount(amountBuyTotal, height)

        nd_rightPriceAmount = self.getNdPriceAmount(amountSellTotal, height)


        nd_buy = self.transDfAmountToDdarry(amountBuyTotal, height, width)
        nd_sell = self.transDfAmountToDdarry(amountSellTotal, height, width)


        nd_sell = self.leftToRight(nd_sell)

        nd_title = self.getNdTitle(data, height)

        nd_show = np.concatenate((nd_leftPriceAmount, nd_buy , nd_title, nd_sell, nd_rightPriceAmount), axis = 1)

        nd_f = self.topToBottom(nd_show)
        tstr = self.transNdToStr(nd_f)

      


        # print(nd_title)

        print(tstr)

    def getNdPriceAmount(self, dfamount, height):
        list_t = []

        for i in range(height + 1):
            if i in dfamount.index:
                amount = "%.2f" % dfamount.at[i, 'amount']
            else:
                amount = '0.00'
            amount = amount.ljust(10, ' ')
            amount = amount.rjust(13, ' ')
            list_t.append(amount)

        nd_title = np.array(list_t)
 
        nd_title = nd_title.reshape((height + 1, 1))
        return nd_title

    def getNdTitle(self, data, height):
        maxPrice = data.price.astype('float64').max()
        minPrice = data.price.astype('float64').min()
        sepPrice = (maxPrice - minPrice) / height

        # nd_title = np.zeros((height, 1))
        list_t = []
        for i in range(height + 1):
            if i == height:
                sprice = maxPrice
            else:
                sprice = Decimal(minPrice + i * sepPrice).quantize(Decimal('0.00'))
            list_t.append("%.2f" % sprice)

       
        nd_title = np.array(list_t)
        nd_title = nd_title.reshape((height + 1, 1))
        # print(nd_title.ndim)
        return nd_title
       
    def transDfAmountToDdarry(self, data, height, width):
        nd_arr = np.zeros((height + 1, width))
        shape = nd_arr.shape
        rowNum = shape[0]
        colNum = shape[1]

        for i in range(rowNum):
            if i in data.index:
                currentIndexData = data.loc[i]
                amount = currentIndexData.amount
                w = int(currentIndexData.w)
                key = int(currentIndexData.key)
                
                nd_arr[i, 0:w] = 1
        return nd_arr


    def reFormatAmount(self, data, width, maxTotal):
        wlist = []
        for rkey in data.index:
            w = int(data.at[rkey, 'amount'] / maxTotal * width)
            wlist.append(w)
        data.insert(0, 'w', wlist)
        return data

    def getIndexNum(self, data, formatData, height, width):

        maxprice = data.price.astype('float64').max()
        minprice = data.price.astype('float64').min()

        maxamount = data.amount.astype('float64').max()
        minamount = data.amount.astype('float64').min()

        subPerHeight = (maxprice - minprice) / height
        
        showstage = {}
        for tradek in formatData.index:
            price = float(formatData.at[tradek, 'price'])
            amount = float(formatData.at[tradek, 'amount'])

            nd_key = int((price - minprice) / subPerHeight)
            if nd_key == height:
                nd_key = height
            if nd_key in showstage:
                sdata = showstage.get(nd_key)
                sdata['key'] = nd_key
                sdata['amount'] = amount + sdata['amount']
                showstage[nd_key] = sdata
            else:
                showstage[nd_key] = {"key": nd_key, "amount": amount}

   
        df = pd.DataFrame(showstage).T

        return df
        # df.amount.astype('float64').max()

    def transDfToStr(self, key_df, height , width):

        rowNum = height
        colNum = width

        tstr = ''
        for i in range(rowNum):
            if i in key_df.index:
                cs = key_df.loc[i]
                w = int(cs['w'])
                for j in range(colNum):               
                    if j < w:
                        tstr = tstr + '#'
                    elif j >= w:
                        tstr = tstr + '.'

                    if j == colNum - 1:
                        tstr = tstr + "\n"
            else:
                for j in range(colNum):               
                 
                    tstr = tstr + '.'

                    if j == colNum - 1:
                        tstr = tstr + "\n"

        return tstr 

    def transNdToStr(self, nd_arr):

        shape = nd_arr.shape
        rowNum = shape[0]
        colNum = shape[1]

        tstr = ''
        for i in range(rowNum):
            for j in range(colNum):
                if nd_arr[i, j] == 1 or nd_arr[i, j] == '1.0':
                    tstr = tstr + '#'
                elif nd_arr[i, j] == 0 or nd_arr[i, j] == '0.0':
                    tstr = tstr + '.'
                elif nd_arr[i, j] == 'NOT_PRINT':
                    pass
                elif nd_arr[i, j] == 'p_up':
                    tstr = tstr + '∧'
                elif nd_arr[i, j] == 'p_down':
                    tstr = tstr + '∨'
                else:
                    tstr = tstr + nd_arr[i, j]
            
                if j == colNum - 1:
                    tstr = tstr + "\n"

        return tstr

    def transNdToCode(self, nd_arr):

        shape = nd_arr.shape
        rowNum = shape[0]
        colNum = shape[1]

        codeIndex = 0
       
        for i in range(rowNum):
            for j in range(colNum):
                if nd_arr[i, j] == 0 or nd_arr[i, j] == '0.0':
                    pass
                elif nd_arr[i, j] == 'NOT_PRINT':
                    pass
                else:
                    codeIndex = (i + 1) * (j + 1) + codeIndex
        return codeIndex

    def leftToRight(self, mt):
        shape = mt.shape
        rowNum = shape[0]
        colNum = shape[1]
        for i in range(rowNum):
            for j in range(int(colNum/2)):
                mt[i][colNum-j-1],mt[i][j] = mt[i][j],mt[i][colNum-j-1]
        return mt

    def topToBottom(self, mt_origin):
        mt = copy.deepcopy(mt_origin)
        shape = mt.shape
        rowNum = shape[0]
        for i in range(rowNum // 2):
            mt[i], mt[rowNum-1-i] = mt_origin[rowNum-1-i], mt_origin[i]
        return mt
    
    def stepOver(self, timeStart, timeEnd, stepSec, ah, aw, kh, kw, his = False, interval = 0.5, ploop = 1):
        cha = self.cha
        st = timeStart

        f = '%Y-%m-%d %H:%M:%S'
        f2 = '%Y%m%d%H%M%S'

        # now = time.strftime(f)
        # print(now)

        # struct time
        stime = time.strptime(timeStart, f)
        etime = time.strptime(timeEnd, f)

      
        # exit()
        
        # sec time
        tm_s = time.mktime(stime)
        tm_e = time.mktime(etime)
        tm_stepnow = tm_s

        tm_count = (tm_s - tm_e) // stepSec + 1

        cloopcount = 0

        sethreads = []

        while tm_stepnow < tm_e:
            tm_stepnow = stepSec + tm_stepnow
           
            tm_s_stu = time.gmtime(tm_s + 8 * 3600)
            tm_stepnow_stu = time.gmtime(tm_stepnow + 8 * 3600)

            nd_f = None

            if his:
                gkey = self.gkey(time.strftime(f2, tm_s_stu), time.strftime(f2, tm_stepnow_stu), stepSec, ah, aw, kh, kw)
                nd_f = self.ts.getTradeData(gkey)


            if nd_f is None:
                dataAll = cha.searchTimeArea(time.strftime(f2, stime), time.strftime(f2, etime))
                data = cha.searchTimeArea(time.strftime(f2, tm_s_stu), time.strftime(f2, tm_stepnow_stu))
                nd_f = self.drawBase(data, dataAll, ah, aw, kh, kw)
  
                if his:
                    if nd_f is not None:
                        gkey = self.gkey(time.strftime(f2, tm_s_stu), time.strftime(f2, tm_stepnow_stu), stepSec, ah, aw, kh, kw)
                        self.ts.saveTradeData(nd_f, gkey)
            else:
                if his:
                    if interval > 0:
                        time.sleep(interval)

            if nd_f is not None:
                print(self.transNdToStr(nd_f))

        if ploop > 1:
            ploop = ploop -1
            time.sleep(4)
            p.stepOver(timeStart, timeEnd, stepSec, ah, aw, kh, kw, his, interval, ploop) 
            


    def stepOverNow(self, stepSec, ah, aw, kh, kw):
        cha = self.cha
        

        f = '%Y-%m-%d %H:%M:%S'
        f2 = '%Y%m%d%H%M%S'

        now = time.strftime(f)
        # print(now)

        # struct time
        # stime = time.strptime(timeStart, f)

        etime = time.strptime(now, f)
        tm_e = time.mktime(etime)
        tm_s = tm_e - stepSec
        
        tm_s_stu = time.gmtime(tm_s + 8 * 3600)
        tm_e_stu = time.gmtime(tm_e + 8 * 3600)

        data = cha.searchTimeArea(time.strftime(f2, tm_s_stu), time.strftime(f2, tm_e_stu))
        nd_f = self.drawBase(data, data, ah, aw, kh, kw)
        
        if nd_f is not None:
            print(self.transNdToStr(nd_f))
        # one more time
        self.stepOverNow(stepSec, ah, aw, kh, kw)
    

    def gkey(self, times, timee, step, ah, aw, kh, kw):
        mongo = cfg.getMongo(self.tradeVariety)
        return "nd_"+mongo.get('DB')+mongo.get('DB_HOST')+"_{times}_{timee}_st{step}_{ah}_{aw}_{kh}_{kw}".format(times = times, timee = timee, step = step, ah = ah, aw = aw, kh = kh, kw = kw)


    def drawKline(self, data, dataBase, height, width):
        data = pd.DataFrame(data)
        dataBase = pd.DataFrame(dataBase)

        # print(data)
        # height = 16
        # width = 50
        maxPrice = dataBase.price.astype('float64').max()
        minPrice = dataBase.price.astype('float64').min()

        timedate = dataBase.timedate.astype('int64')

        timestart = timedate[timedate.index[0]]
        timeend = timedate[timedate.index[len(timedate) - 1]]

        price_per = (maxPrice - minPrice) / height

        time_per = (self.transTimedateToTime(timeend) - self.transTimedateToTime(timestart)) // width


        nd_timeprice = np.empty((width + 1, height + 1))

        # print(nd_timeprice)

        shape = nd_timeprice.shape

        rowNum = shape[0]
        colNum = shape[1]

        nd_list = []
        p_h = 0
        for i in range(rowNum):
            c_list = []

            timeNow = self.transTimedateToTime(timestart) + i * time_per + 8 * 3600
            timedateNow = self.transTimeToTimedate(timeNow)

            # print(timedateNow)

            priceNow = self.getTimePrice(data, timedateNow)

            if priceNow == maxPrice:
                h = height
            else:
                h = int((priceNow - minPrice) // price_per)

            for j in range(colNum):
                if j == h:
                    if h > p_h:
                        c_list.append('p_up')
                    elif h == p_h:
                        c_list.append('1.0')
                    else:
                        c_list.append('p_down')
                else:
                    c_list.append('0.0')
            p_h = h
            nd_list.append(c_list)
            nd_timeprice = np.array(nd_list)
        return self.topToBottom(nd_timeprice.T)

    def getTimePrice(self, dfdata, timedate):
        timedates = dfdata.timedate.astype('int64')
        timedate = int(timedate)
        t_sel = timedates.loc[timedates == timedate]

        if len(t_sel) > 0:
            pricedata = dfdata.loc[dfdata.timedate.astype('int64') == timedate]
            return float(pricedata.at[pricedata.index.max(), 'price'])
        else:
            timedate_pre = dfdata.loc[dfdata.timedate.astype('int64') < timedate]

            if len(timedate_pre) > 0:
                return self.getTimePrice(dfdata, timedate_pre.timedate.astype('int64').max())
            else :
                return 0
            
    def transTimeToTimedate(self, tstime):
        f2 = '%Y%m%d%H%M%S'
        tm_s_stu = time.gmtime(tstime)
        return time.strftime(f2, tm_s_stu)

    def transTimeToTimedateF1(self, tstime):
        f = '%Y-%m-%d %H:%M:%S'
        tm_s_stu = time.gmtime(tstime)
        return time.strftime(f, tm_s_stu)

    def transTimedateToTime(self, timedate):
        f2 = '%Y%m%d%H%M%S'
        timedate_stuct = time.strptime(str(timedate), f2)
        tm_s = time.mktime(timedate_stuct)
        return tm_s

    def transTimedateToDate(self, timedate):
        tm_s = self.transTimedateToTime(timedate) + 8 * 3600
        return self.transTimeToTimedateF1(tm_s)

    def getDataStr(self, timeStart, timeEnd, ah = 16, aw = 45, kh = 16, kw = 70):

        sdate = func.transF1ToTimedateF2(timeStart)
        edate = func.transF1ToTimedateF2(timeEnd)

        dataAll = self.cha.searchTimeArea(sdate, edate)
        nd_f = self.drawBase(dataAll, dataAll, ah, aw, kh, kw)

        nd_str = self.transNdToStr(nd_f)

        # self.sim.writeTradeLog("\n" + nd_str)
        print(nd_str)
        
    def getDataIndexStr(self, timeStart, timeEnd, ah = 16, aw = 45, kh = 16, kw = 70):

        sdate = func.transF1ToTimedateF2(timeStart)
        edate = func.transF1ToTimedateF2(timeEnd)

        dataAll = self.cha.searchTimeArea(sdate, edate)

        nd_f = self.drawBase(dataAll, dataAll, ah, aw, kh, kw)

        nd_str = self.transNdToStr(nd_f)

        nd_code = self.drawBaseIndexCode(dataAll, dataAll, ah, aw, kh, kw)


        # self.sim.writeTradeLog("\n" + nd_str)
        print(nd_str, nd_code)

    def drawIndexCode(self, timeStart, timeEnd, ah = 16, aw = 45, kh = 16, kw = 70, timeSepM = 5):
        f = '%Y-%m-%d %H:%M:%S'
       
        
        ps = datetime.datetime.strptime(timeStart, f)
        stimeEnd = (ps+datetime.timedelta(minutes=timeSepM)).strftime(f)

        stimeStart = (ps+datetime.timedelta(minutes=-180)).strftime(f)

        ar = []
        while True:
           

            if datetime.datetime.strptime(stimeEnd, f) <= datetime.datetime.strptime(timeEnd, f):
         

                sdate = func.transF1ToTimedateF2(stimeStart)
                edate = func.transF1ToTimedateF2(stimeEnd)

                print(stimeEnd)
                # print(sdate, edate)
                # dataAll = self.cha.searchTimeArea(sdate, edate)


                

                nd_code = {}
                
                # code = self.drawBaseIndexCode(dataAll, dataAll, ah, aw, kh, kw)
                # print(code)
                pointCode = self.getPoint(stimeStart, stimeEnd)


                ps = datetime.datetime.strptime(stimeStart, f)
                stimeStart = (ps+datetime.timedelta(minutes=timeSepM)).strftime(f)

                ps = datetime.datetime.strptime(stimeEnd, f)
                stimeEnd = (ps+datetime.timedelta(minutes=timeSepM)).strftime(f)
                
                if pointCode is None:
                    continue
                pointCode = dict(pointCode)
                print(pointCode)
                nd_code['code'] = pointCode.get('code')


                nd_code['tm'] = ps.strftime('%H:%M')
                ar.append(nd_code)
                # print(nd_code)

               
            else:
                print('loop back')
                break

        ar_df = pd.DataFrame(ar)

        # first_num = num_info[0:12] 
        # plt.plot(ar_df["tm"],ar_df["b"])
        # labx = range(len(ar_df["b"]))
        labx = ar_df['tm']
        plt.plot(labx,ar_df["code"],label="b",color="#F08080")
        # plt.plot(labx,ar_df["s"],label="s",color="#60dc41")
        #绘制网格
        plt.grid(alpha=0.4, linestyle=':')
       
        #添加图例，prop指定图例的字体, loc坂数坯以查看溝砝
        plt.legend(loc="upper left")

        plt.xticks(rotation=90)  #由于横轴的数杮太长，旋转90度，竖着显示
        plt.xlabel("tm")      #指定横轴和纵轴的标签
        plt.ylabel("co")
        plt.title("%s - %s " % (timeStart, timeEnd)) #标题
        plt.show()

        # print(ar_df)

    def getPoint(self, timeStart, timeEnd):
        self.getPointCount = self.getPointCount + 1
        if self.getPointCount > 1:
            self.getPointCount = 0
            return None

        p.printRunTime('point start 1')
        sdate = func.transF1ToTimedateF2(timeStart)
        edate = func.transF1ToTimedateF2(timeEnd)
      
        dataAll = self.cha.searchTimeArea(sdate, edate)
        if len(dataAll) == 0:
            return None

        maxPrice = dataAll['price'].astype('float64').max()
        minPrice = dataAll['price'].astype('float64').min()
        p.printRunTime('point start 2')
        dfmaxRows = dataAll.loc[dataAll.price.astype('float64') == maxPrice]

        if len(dfmaxRows) == 0:
            return None

        dfmaxRow = dfmaxRows.loc[dfmaxRows.index[0]]

        dfminRows = dataAll.loc[dataAll.price.astype('float64') == minPrice]
        if len(dfminRows) == 0:
            return None

        dfminRow = dfminRows.loc[dfminRows.index[0]]

        currentRow = dataAll.loc[dataAll.index[-1]]
        # print(dfmaxRow, dfminRow, currentRow)

        self.lastPointCode = dict(currentRow)

        absMax = abs(float(dfmaxRow.price) - float(currentRow.price))
        absMin = abs(float(dfminRow.price) - float(currentRow.price))
        p.printRunTime('point start 3')
        print("absMax %f, p %f" % (absMax, absMax / float(dfmaxRow.price)))
        print("absMin %f, p %f" % (absMin, absMin / float(dfminRow.price)))
       
        mutiny = False

        like = abs(absMax - absMin) / float(currentRow.price)

        if like < 0.0018:
            return None

        if absMax > absMin:
            leftRow = dfmaxRow

            if absMin / float(dfminRow.price) > 0.01:
                if dfminRow.timedate > dfmaxRow.timedate:
                    leftRow = dfminRow
                    mutiny = True

            if mutiny == False:
                if absMax / float(dfmaxRow.price) < 0.0058:
                    f = '%Y-%m-%d %H:%M:%S'
                    psLeft = datetime.datetime.strptime(timeStart, f)
                    timeLeft = (psLeft+datetime.timedelta(minutes=-60)).strftime(f)
                    return self.getPoint(timeLeft, timeEnd)

        elif absMax < absMin:
            leftRow = dfminRow

            if absMax / float(dfmaxRow.price) > 0.01:
                if dfmaxRow.timedate > dfminRow.timedate:
                    leftRow = dfmaxRow
                    mutiny = True

            if mutiny == False:
                if absMin / float(dfminRow.price) < 0.0058:
                    f = '%Y-%m-%d %H:%M:%S'
                    psLeft = datetime.datetime.strptime(timeStart, f)
                    timeLeft = (psLeft+datetime.timedelta(minutes=-60)).strftime(f)
                    return self.getPoint(timeLeft, timeEnd)

        elif absMax == absMin:
            # f = '%Y-%m-%d %H:%M:%S'
            # psLeft = datetime.datetime.strptime(timeStart, f)
            # timeLeft = (psLeft+datetime.timedelta(minutes=-60)).strftime(f)
            # return self.getPoint(timeLeft, timeEnd)
            return None

        p.printRunTime('point start 4')
        sdate = leftRow.timedate
        edate = func.transF1ToTimedateF2(timeEnd)
        # print(leftRow)
        # print(sdate, edate)
        dataCodeAll = self.cha.searchTimeArea(sdate, edate)
        p.printRunTime('point start 5')
        code = self.drawBaseIndexCode(dataCodeAll, dataCodeAll, ah = 22, aw = 40, kh = 22, kw = 80)     
        
        p.printRunTime('point start 6')
        self.getPointCount = 0

        if mutiny == False:
            
            if absMax > absMin:
                if code < 260000:
                    print("code %s not for buy" % code)
                    return None
            else:
                if code > 320000:
                    print("code %s not for sell" % code)
                    return None
        else:
            print("had mutinied")

        return {"code": code, 'timedate': currentRow.timedate, "price": currentRow.price, "leftRow": leftRow, 'min': dfminRow.price, 'max': dfmaxRow.price}

    def stepOrder(self, timeStart, timeEnd, timeSepM = 1):

        p.printRunTime('stepOrder start')

        f = '%Y-%m-%d %H:%M:%S'
       
        stimeEnd = timeStart
        
        while True:
            p.printRunTime('loop start')
            if datetime.datetime.strptime(stimeEnd, f) <= datetime.datetime.strptime(timeEnd, f):
                p.printRunTime('loop p1')
                timeRight = stimeEnd
                psLeft = datetime.datetime.strptime(timeRight, f)
                timeLeft = (psLeft+datetime.timedelta(minutes=-58)).strftime(f)
                
                p.printRunTime('loop p2')
                pc = self.getPoint(timeLeft, timeRight)

                ps = datetime.datetime.strptime(stimeEnd, f)
                stimeEnd = (ps+datetime.timedelta(minutes=timeSepM)).strftime(f)

                if pc is None:
                    print("point code none")
                    if self.lastPointCode is not None:
                        self.dumpTrade(self.lastPointCode.get('timedate'), self.lastPointCode.get('price'))
                    continue
                pointCode = dict(pc)
                print('pcode.....',pointCode)

                p.printRunTime('loop p3')
                dft = pd.DataFrame(self.orders)
                if len(dft) == 0:
                    allNotCompTrades = []
                else:
                    allNotCompTrades = dft.loc[dft.complete == 0]

                if pointCode.get('code') > 320000:
                    p.printRunTime('loop p3.1')
                    if len(allNotCompTrades) > 0:
                        lastOrder = dict(allNotCompTrades.loc[allNotCompTrades.index[-1]])

                        if lastOrder['type'] == 'buy':

                            level = 1
                            for li in range(8):
                                if len(allNotCompTrades) >= li + 2:
                                    clastOrder = dict(allNotCompTrades.loc[allNotCompTrades.index[-(li + 2)]])
                                    if clastOrder['type'] == 'buy':
                                        level = level + 1
                                    else:
                                        break
                                else:
                                    break

                            spendUsdt = self.getLevelPrice(level)

                            if float(lastOrder['price']) > float(pointCode.get('price')):
                                pointPrice = (float(lastOrder['price']) - float(pointCode.get('price'))) / float(pointCode.get('price'))
                                if pointPrice > 0.0058:
                                    allNotCompTradesSell = allNotCompTrades.loc[allNotCompTrades.type == 'sell']
                                    if len(allNotCompTradesSell) > 0:
                                        # self.forcePcLast(pointCode.get('timedate'), pointCode.get('price'), allNotCompTradesSell.loc[allNotCompTradesSell.index[-1]])
                                        pass
                                    # else:
                                    self.addOrder(type = 'buy', currency=spendUsdt,code = pointCode.get('code'), price = pointCode.get('price'), timedate = pointCode.get('timedate'))
                        else:
                            # self.forcePcLast(pointCode.get('timedate'), pointCode.get('price'), lastOrder)
                            
                            self.addOrder(type = 'buy', code = pointCode.get('code'), price = pointCode.get('price'), timedate = pointCode.get('timedate'))
                    else:        
                        self.addOrder(type = 'buy', code = pointCode.get('code'), price = pointCode.get('price'), timedate = pointCode.get('timedate'))
                    p.printRunTime('loop p3.1.1')
                elif pointCode.get('code') < 260000:
                    p.printRunTime('loop p3.2')
                    if len(allNotCompTrades) > 0:
                        lastOrder = dict(allNotCompTrades.loc[allNotCompTrades.index[-1]])
                        if lastOrder['type'] == 'sell':
                            level = 1
                            for li in range(8):
                                if len(allNotCompTrades) >= li + 2:
                                    clastOrder = dict(allNotCompTrades.loc[allNotCompTrades.index[-(li + 2)]])
                                    if clastOrder['type'] == 'sell':
                                        level = level + 1
                                    else:
                                        break
                                else:
                                    break

                            spendUsdt = self.getLevelPrice(level)

                            if float(lastOrder['price']) < float(pointCode.get('price')):
                                pointPrice = (float(pointCode.get('price')) - float(lastOrder['price'])) / float(lastOrder['price'])
                                if pointPrice > 0.0058:
                                    allNotCompTradesBuy = allNotCompTrades.loc[allNotCompTrades.type == 'buy']
                                    if len(allNotCompTradesBuy) > 0:
                                        # self.forcePcLast(pointCode.get('timedate'), pointCode.get('price'), allNotCompTradesBuy.loc[allNotCompTradesBuy.index[-1]])
                                        pass
                                    # else:
                                    self.addOrder(type = 'sell', currency=spendUsdt,code = pointCode.get('code'), price = pointCode.get('price'), timedate = pointCode.get('timedate'))
                        else:
                            # self.forcePcLast(pointCode.get('timedate'), pointCode.get('price'), lastOrder)
                            self.addOrder(type = 'sell', code = pointCode.get('code'), price = pointCode.get('price'), timedate = pointCode.get('timedate'))
                    else:        
                        self.addOrder(type = 'sell', code = pointCode.get('code'), price = pointCode.get('price'), timedate = pointCode.get('timedate'))
                    p.printRunTime('loop p3.2.1')
                else:
                    print('has no point to opt', pointCode)

               

                # print('orders', self.orders)

                print(timeLeft, timeRight)
                # self.pingc(pointCode.get('timedate'), pointCode.get('price'))
                self.lastPointCode = pointCode
                self.dumpTrade(pointCode.get('timedate'), pointCode.get('price'))
                p.printRunTime('one loop end')
            else:
                break
        print("paint blue sky succ, %s-%s" % (timeStart, timeEnd))
        func.writeOrderStore(self.orders, self.tradeVariety)

    def getLevelPrice(self, level):
        startLevelPrice = self.initUsdtUint
        # return startLevelPrice
        levelPrice = 0
        if level == 0:
            levelPrice = startLevelPrice
        else:
            maxLevel = 8
            if level > maxLevel:
                level = maxLevel
                
            rel = 1 + (level - 1) * (level * 1 /maxLevel)

            levelPrice = startLevelPrice + level * (rel * startLevelPrice / maxLevel)

        return levelPrice

    def getTradeStr(self, timedate, price):
        self.pingc(timedate, price)
        df = pd.DataFrame(self.orders)
        showStr = ""
        dataListStr = ""
        if len(df) > 0:
            # print(df)
            dataListStr = func.printDataFrame(df)
            price = float(price)
            df_succ = df.loc[df.suc == 1]
            df_fail = df.loc[df.suc == 2]

            df_sell = df.loc[df.type == 'sell']
            df_buy = df.loc[df.type == 'buy']

            Ebpc = 0
            Espc = 0

            Ebc = 0
            Esc = 0
            for gk in range(len(df)):
                dfrow = df.loc[df.index[gk]]
                if dfrow['type'] == 'buy':
                    Ebpc = Ebpc + float(dfrow['currency']) / float(dfrow['price'])
                    Ebc = Ebc + float(dfrow['currency'])
                else:
                    Espc = Espc + float(dfrow['currency']) / float(dfrow['price'])
                    Esc = Esc + float(dfrow['currency'])

            Eamount = abs(Ebpc + (-Espc))

            Ecostusd =  abs(Ebc - Esc)

            self.midcresult['mc'] = (Ecostusd +  self.midcresult['mc']) / 2

            if Ecostusd > self.midcresult['mcMax']:
                self.midcresult['mcMax'] = Ecostusd

            if Ecostusd < self.midcresult['mcMin']:
                self.midcresult['mcMin'] = Ecostusd

            Eshow = ''
            if Ebc - Esc > 0:
                Eshow = "做多:数量{:.2f}，金额{:.2f}，成本价{:.2f}".format(Eamount, Ebc - Esc, (Ebc - Esc) / Eamount)
                pf = (price - (Ebc - Esc) / Eamount) * Eamount
            else:
                Eshow = "做空:数量{:.2f}，金额{:.2f}，成本价{:.2f}".format(Eamount, Esc - Ebc, (Esc - Ebc) / Eamount)
                pf = ((Esc - Ebc) / Eamount - price) * Eamount

           
            c_profit = df['profit'].astype('float64').sum()

            r_transfer = c_profit / self.midcresult['mc']

            showStr = showStr + ("最大占用 %.2f" % self.midcresult['mcMax']) + "\n"
            showStr = showStr + ("最小占用 %.2f" % self.midcresult['mcMin']) + "\n"

            showStr = showStr + ("转化率 %.2f" % (r_transfer * 100)) + "\n"

            showStr = showStr + ("总体盈利 %.2f" % c_profit) + "\n"
            
            

            showStr = showStr + ("总单数 %d , 多单 %d, 空单 %d" % (len(df), len(df_buy), len(df_sell))) + "\n"

            

            showStr = showStr + ("当前价格 %.2f" % price) + "\n"
            showStr = showStr + ("方向 %s" % Eshow) + "\n"
        return dataListStr + "\n" + showStr

    def dumpTrade(self, timedate, price):
        showStr = self.getTradeStr(timedate, price)
        print(showStr)

    def forcePcLast(self, timedate, price, lastOrder):
        for ik in range(len(self.orders)):
            order = dict(self.orders[ik])
            if order['code'] == lastOrder.get('code') and order['price'] == lastOrder.get('price'):
                i = ik
                break
        dft = pd.DataFrame(self.orders)
        if len(dft) > 0:
            price = float(price)
            absVal = abs(price - self.orders[i]['price'])
            absP = absVal / price
            self.orders[i]['complete'] = 1
            self.orders[i]['pprice'] = price
            self.orders[i]['ptimedate'] = func.transTimedateToDate(timedate)
            self.orders[i]['pt'] = absP

            if self.orders[i]['type'] == 'sell':
                if float(self.orders[i]['price']) > price:
                    self.orders[i]['suc'] = 1
                    self.orders[i]['profit'] = (float(self.orders[i]['price']) - price) / price * self.orders[i]['currency']
                else:
                    self.orders[i]['suc'] = 2
                    self.orders[i]['profit'] = -(price - float(self.orders[i]['price'])) / float(self.orders[i]['price']) * self.orders[i]['currency']
            else:
                if float(self.orders[i]['price']) < price:
                    self.orders[i]['suc'] = 1
                    self.orders[i]['profit'] = (price - float(self.orders[i]['price'])) / float(self.orders[i]['price']) * self.orders[i]['currency']
                    
                    (float(self.orders[i]['price']) - price) / price * self.orders[i]['currency']
                else:
                    self.orders[i]['suc'] = 2
                    self.orders[i]['profit'] = -(float(self.orders[i]['price']) - price) / price * self.orders[i]['currency']

    def pingc(self, timedate, price):
       
        price = float(price)
        
        for i in range(len(self.orders)):
            self.orders[i]['currency'] = float(self.orders[i]['currency'])
               
            absVal = abs(price - float(self.orders[i]['price']))
            absP = absVal / price
            # print('absp',absP)
            self.orders[i]['complete'] = 0
            self.orders[i]['pprice'] = price
            self.orders[i]['ptimedate'] = func.transTimedateToDate(timedate)
            self.orders[i]['pt'] = absP

            if self.orders[i]['type'] == 'sell':
                if float(self.orders[i]['price']) > price:
                    self.orders[i]['suc'] = 1
                    self.orders[i]['profit'] = (float(self.orders[i]['price']) - price) / price * self.orders[i]['currency']

                else:
                    
                    self.orders[i]['suc'] = 2
                    self.orders[i]['profit'] = -(price - float(self.orders[i]['price'])) / float(self.orders[i]['price']) * self.orders[i]['currency']
                    
            else:
                if float(self.orders[i]['price']) < price:
                    self.orders[i]['suc'] = 1
                    self.orders[i]['profit'] = (price - float(self.orders[i]['price'])) / float(self.orders[i]['price']) * self.orders[i]['currency']
                    (float(self.orders[i]['price']) - price) / price * self.orders[i]['currency']
                else:
                    self.orders[i]['suc'] = 2
                    self.orders[i]['profit'] = -(float(self.orders[i]['price']) - price) / price * self.orders[i]['currency']

            self.orders[i]['price'] = Decimal(self.orders[i]['price']).quantize(Decimal('0.00')) 
            self.orders[i]['pt'] = Decimal(absP).quantize(Decimal('0.00000')) 
            self.orders[i]['profit'] = Decimal(self.orders[i]['profit']).quantize(Decimal('0.000'))
                        
              

    def addOrder(self, type = 'buy', currency = 0, price = None, timedate = None, code = None):
        if currency == 0:
            currency = self.initUsdtUint

        order = {"type": type, "currency": currency, "price": float(price), "timedate": func.transTimedateToDate(timedate), "code": code, "complete": 0, "suc": 0, "profit": 0}
        self.orders.append(order)

    # def updateFirstOrder(self, suc = 1, profit = 0):
    #     if len(self.order) == 1:
    
    def printRunTime(self, showmark = "run time:"):
        start = self.startTime
        end = time.time()
        self.startTime = end
        # print("%s run sec %.2f" % (showmark, end - start))

if __name__ == "__main__":
    
    if (len(sys.argv) < 3) :
        print('usdt unit or variety not set')
        exit()


    initUsdtUint = float(sys.argv[1])
    if (initUsdtUint <= 0):
        print('usdt value error')
        exit()

    tradeVariety = sys.argv[2]

    p = Paint(tradeVariety)
    p.initUsdtUint = initUsdtUint
    p.tradeVariety = tradeVariety

    f = '%Y-%m-%d %H:%M:%S'
    now = time.strftime(f)

    p.printRunTime('sys started')

    timeStart = '2019-05-12 00:17:00'
    timeEnd = '2019-05-01 09:19:00'

    # timeStart = '2019-01-28 11:05:00'
    # timeEnd = '2019-01-28 12:58:00'
    
    # 180000 400000
    timeEnd = now
    p.cha.cacheTimeArea(timeStart, timeEnd)
    # p.getDataStr(timeStart, timeEnd, ah = 22, aw = 40, kh = 22, kw = 80)
    # p.drawIndexCode(timeStart, timeEnd, ah = 22, aw = 40, kh = 22, kw = p.kw, timeSepM = 0.3)
    # print(p.getPoint(timeStart, timeEnd))
    p.stepOrder(timeStart, timeEnd, timeSepM = 10)
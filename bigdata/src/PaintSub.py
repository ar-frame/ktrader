#!/usr/bin/env python3.6
# -*- coding: utf-8 -*-

'test for dev moudule'
__author__ = 'assnr'
import numpy as np
import pandas as pd

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



class PaintSub:

    def __init__(self):
        nowHour = datetime.datetime.now().strftime('%Y%m%d%H')

        mongo = cfg.getMongo()
        self.db_bigdata = MongoDB(mongo.get('DB'), 'gataio_eth_trades_h' + nowHour, mongo.get('DB_HOST'), mongo.get('DB_USER'), mongo.get('DB_PASS'))
        # self.db_bigdata = MongoDB('bigdata', 'gataio_eth_trades_h2019011918')
        self.sim = Simulate()
        self.cha = Characteristic()
        self.ts = TradeSave()
        self.threads = []

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

        amountBuyTotal = self.getIndexNumSub(dataBase, buydata, height, width)
        # amountBuyTotalSub = self.getIndexNumSub(dataBase, buydata, height, width)

        # print(amountBuyTotal, amountBuyTotalSub)
        # exit()

        amountSellTotal = self.getIndexNumSub(dataBase, selldata, height, width)

        amountBuyTotal_base = self.getIndexNumSub(dataBase, buydata_base, height, width)
        amountSellTotal_base = self.getIndexNumSub(dataBase, selldata_base, height, width)

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

    def getIndexNumSub(self, data, formatData, height, width):

        maxprice = data.price.astype('float64').max()
        minprice = data.price.astype('float64').min()

        maxamount = data.amount.astype('float64').max()
        minamount = data.amount.astype('float64').min()

        subPerHeight = (maxprice - minprice) / height
        
        showstage = {}
        for tradek in formatData.index:
            price = float(formatData.at[tradek, 'price'])
            amount = float(formatData.at[tradek, 'amount'])

            otype = formatData.at[tradek, 'type']

            nd_key = int((price - minprice) / subPerHeight)
            if nd_key == height:
                nd_key = height
            if nd_key in showstage:
                sdata = showstage.get(nd_key)
                sdata['key'] = nd_key

                oprice = float(sdata['price'])

                if otype == "buy":
                    if price >= oprice:
                        sdata['amount'] = amount + sdata['amount']
                else:
                    if price <= oprice:
                        sdata['amount'] = amount + sdata['amount']

                sdata['price'] = price
                showstage[nd_key] = sdata      
                
            else:
                showstage[nd_key] = {"key": nd_key, "amount": amount, "price": price}

   
        df = pd.DataFrame(showstage).T

        return df

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
                    tstr = tstr + '#'
                elif nd_arr[i, j] == 'p_down':
                    tstr = tstr + '#'
                else:
                    tstr = tstr + nd_arr[i, j]
            
                if j == colNum - 1:
                    tstr = tstr + "\n"

        return tstr

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
        mongo = cfg.getMongo()
        return "nd_psub_"+mongo.get('DB')+mongo.get('DB_HOST')+"_{times}_{timee}_st{step}_{ah}_{aw}_{kh}_{kw}".format(times = times, timee = timee, step = step, ah = ah, aw = aw, kh = kh, kw = kw)


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

        self.sim.writeTradeLog("\n" + nd_str)
        print(nd_str)
    
    def printCurrentStat(self):
        while True:
            data = self.db_bigdata.query_all()
            dataFrame = pd.DataFrame(list(data))
            nd_f = self.drawBase(dataFrame, dataFrame, 15 , 30, 15, 120)
            nd_str = self.transNdToStr(nd_f)
            print(nd_str)
            nowHour = datetime.datetime.now().strftime('%Y-%m-%d %H:%M:%S')
            print(nowHour)
            # time.sleep(3)

if __name__ == "__main__":
    p = PaintSub()
    # p.printCurrentStat()
   
    # p = Paint()
    f = '%Y-%m-%d %H:%M:%S'
    now = time.strftime(f)

    timeStart = '2019-01-22 19:00:00'

    timeStart = '2019-01-30 09:00:00'
    timeEnd = '2019-01-22 20:00:00'
    timeEnd = now
    # p.getDataStr(timeStart, timeEnd, ah = 20, aw = 40, kh = 20, kw = 50)
    p.stepOver(timeStart, timeEnd, 60*30, ah = 18, aw = 50, kh = 18, kw = 76, his = True, interval = 3, ploop = 2) 

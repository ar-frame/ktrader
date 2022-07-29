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
import traceback

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
from Trade import Trade

from Paint import Paint

from multiprocessing import Process
import multiprocessing
import signal
from Mysql import Mysql
from ws_server import *

class Shipan:

    def __init__(self, tradeVariety):
        self.midcresult = {"mc": 0, "mcMax": 0, "mcMin": 0}
        self.tradeVariety = tradeVariety
        pass

    def initResoure(self, tradeVariety):
        self.startTime = time.time()

        nowHour = datetime.datetime.now().strftime('%Y%m%d%H')

        # print(nowHour)
        # self.db_bigdata = MongoDB('bigdata', 'gataio_eth_trades_h' + nowHour)
        # self.db_bigdata = MongoDB('bigdata', 'gataio_eth_trades_h2019011918')
        mongo = cfg.getMongo(tradeVariety)
        self.db_bigdata = MongoDB(mongo.get('DB'), 'gataio_eth_trades_h' + nowHour, mongo.get('DB_HOST'), mongo.get('DB_USER'), mongo.get('DB_PASS'))

        self.paint = Paint(tradeVariety)

        self.sim = self.paint.sim
        self.cha = self.paint.cha

        self.ts = TradeSave()

        self.trade = Trade()

        self.threads = []

        self.orders = []
        self.getPointCount = 0
        self.lastPointCode = None
        self.initUsdtUint = 0

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
                sprice = Decimal(minPrice + i * sepPrice).quantize(Decimal('0.0000'))
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

    def gkey(self, times, timee, step, ah, aw, kh, kw):
        mongo = cfg.getMongo(self.tradeVariety)
        return "nd_"+mongo.get('DB')+mongo.get('DB_HOST')+"_{times}_{timee}_st{step}_{ah}_{aw}_{kh}_{kw}".format(times = times, timee = timee, step = step, ah = ah, aw = aw, kh = kh, kw = kw)


    def drawKline(self, data, dataBase, height, width):
        data = pd.DataFrame(data)
        dataBase = pd.DataFrame(dataBase)

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
        ar = []
        while True:
            if datetime.datetime.strptime(stimeEnd, f) <= datetime.datetime.strptime(timeEnd, f):
                sdate = func.transF1ToTimedateF2(timeStart)
                edate = func.transF1ToTimedateF2(stimeEnd)

                dataAll = self.cha.searchTimeArea(sdate, edate)

                if len(dataAll) < 30:
                    ps = datetime.datetime.strptime(stimeEnd, f)

                    stimeEnd = (ps+datetime.timedelta(minutes=timeSepM)).strftime(f)
                    continue

                nd_code = {}

                code = self.drawBaseIndexCode(dataAll, dataAll, ah, aw, kh, kw)
                print(code)
                nd_code['code'] = code

                ps = datetime.datetime.strptime(stimeEnd, f)
                nd_code['tm'] = ps.strftime('%H:%M')
                ar.append(nd_code)
                # print(nd_code)

                stimeEnd = (ps+datetime.timedelta(minutes=timeSepM)).strftime(f)
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
        return self.paint.getPoint(timeStart, timeEnd)

    def updateNewData(self):
        tdata = self.cha.getLastTimeAreaData()

        # print('last line cache data:')
        # print(tdata)

        currentHouerData = self.getCurrentHouerData()
        if len(currentHouerData) > 0:
            df_hdata = pd.DataFrame(currentHouerData)
            new_df_hdata = df_hdata.loc[df_hdata.timedate.astype('int64') >= int(tdata['timedate'])]

            moredata = []
            if len(new_df_hdata) > 0:
                # listdata = list(new_df_hdata)
                hask = 0
                addTempList = []
                for i in range(len(new_df_hdata)):
                    currentLine = new_df_hdata.loc[new_df_hdata.index[i]]

                    addTempList.append(dict(currentLine))

                    # print(currentLine)
                    if currentLine['id'] == tdata['id']:
                        hask = 1
                        continue

                    if hask == 1:
                        moredata.append(dict(currentLine))

                if hask == 0 and len(addTempList) > 0:
                    moredata = addTempList

            # print(len(df_hdata),len(moredata))

            if len(moredata) > 0:
                self.cha.addCacheData(moredata)

    def doPcRecordToResult(self, pointCode, msg):
        trade_result = self.getTradeResult(pointCode.get('timedate'), pointCode.get('price'))
        self.pingc(pointCode.get("timedate"), pointCode.get('price'), True)
        objs = {\
            "open_date": str(trade_result.get("open_date")), \
            "timedate": pointCode.get("timedate"), \
            "open_price": str(trade_result.get("open_price")), "end_price": str(pointCode.get('price')), \
            "amount": str(trade_result.get("amount")), "direct": str(trade_result.get("opt")), \
            "profit": str(trade_result.get("profit")), "msg": msg \
        }
        self.pcRecord(**objs)

    def stepOrder(self, timeStart, timeEnd, timeSepM = 1, proxy_list = [], data_share_map = {}, data_share_map_summay = {}):

        self.printRunTime('stepOrder start')

        f = '%Y-%m-%d %H:%M:%S'

        try:
            while True:
                if len(self.orders) > 158:
                    self.orders = self.orders[28:]

                proxy_list[:] = self.orders
                self.updateNewData()

                # now = time.strftime(f)
                # 替代
                now = datetime.datetime.now().strftime(f)

                stimeEnd = now

                timeRight = stimeEnd

                psLeft = datetime.datetime.strptime(timeRight, f)
                timeLeft = (psLeft+datetime.timedelta(minutes=-58)).strftime(f)
                print(timeLeft, timeRight)

                pc = self.getPoint(timeLeft, timeRight)


                # ps = datetime.datetime.strptime(stimeEnd, f)
                # stimeEnd = (ps+datetime.timedelta(minutes=timeSepM)).strftime(f)

                if pc is None:
                    print("point code none, last dump")

                    if self.lastPointCode is not None:
                        data_share_map['timedate'] = self.lastPointCode.get('timedate')
                        data_share_map['price'] = self.lastPointCode.get('price')
                        self.dumpTrade(self.lastPointCode.get('timedate'), self.lastPointCode.get('price'))
                        db_mysql = Mysql(self.tradeVariety)
                        db_mysql.updatePrice(type = self.lastPointCode.get('type'), price = self.lastPointCode.get('price'), timedate = func.transTimedateToDate(self.lastPointCode.get('timedate')), pair = self.tradeVariety)
                    else:
                        if len(self.orders) > 0:
                            lo = self.orders[-1]
                            self.dumpTrade(func.transF1ToTimedateF2(lo.get('timedate')), lo.get('price'))
                    time.sleep(1)
                    continue
                pointCode = dict(pc)

                #pointCode['code'] = 400000
                #pointCode['price'] = 0.1

                dft = pd.DataFrame(self.orders)

                if len(dft) == 0:
                    allNotCompTrades = []
                else:
                    dft['complete'] = dft['complete'].astype(float)
                    dft['currency'] = dft['currency'].astype(float)
                    dft['price'] = dft['price'].astype(float)

                    allNotCompTrades = dft.loc[dft.complete == 0]

                if pointCode.get('trade_opt') == 'buy':

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

                            # 加仓
                            if float(lastOrder['price']) > float(pointCode.get('price')):
                                pointPrice = (float(lastOrder['price']) - float(pointCode.get('price'))) / float(pointCode.get('price'))
                                # 点差影响
                                if pointPrice > 0.00618:
                                    allNotCompTradesSell = allNotCompTrades.loc[allNotCompTrades.type == 'sell']
                                    if len(allNotCompTradesSell) > 0:

                                        trade_result = self.getTradeResult(pointCode.get('timedate'), pointCode.get('price'))
                                        opt_usdt = spendUsdt

                                        need_pc = False
                                        stock_usdt = 0

                                        if trade_result.get("opt") == 'sell':

                                            if float(trade_result.get("profit")) > 0:
                                                stock_usdt = float(trade_result.get("amount")) * float(pointCode.get('price'))
                                                if stock_usdt > 100:
                                                    opt_usdt = stock_usdt
                                                    need_pc = True

                                        optres = self.trade.buy(usdT = opt_usdt, price = pointCode.get('price'), tradeVariety = self.tradeVariety)
                                        if optres is not None:
                                            self.addOrder(optype = 'buy', currency = optres.get('deal_money'), code = pointCode.get('code'), price = optres.get('filledRate'), timedate = pointCode.get('timedate'), ispc=True)

                                            if need_pc == True and stock_usdt > 0:
                                                if float(optres.get('deal_money')) >= stock_usdt - 5:
                                                    self.doPcRecordToResult(pointCode, "空单止盈平仓")

                                    else:
                                        self.addOrder(optype = 'buy', currency = spendUsdt, code = pointCode.get('code'), price = pointCode.get('price'), timedate = pointCode.get('timedate'))
                        else:
                            # 反向开单
                            if float(lastOrder['price']) > float(pointCode.get('price')):
                                pointPrice = (float(lastOrder['price']) - float(pointCode.get('price'))) / float(pointCode.get('price'))
                                 # 点差影响
                                if pointPrice > 0.00818:

                                    trade_result = self.getTradeResult(pointCode.get('timedate'), pointCode.get('price'))
                                    opt_usdt = self.initUsdtUint

                                    need_pc = False
                                    stock_usdt = 0

                                    if trade_result.get("opt") == 'sell':
                                        opt_usdt = 2 * self.initUsdtUint

                                        if float(trade_result.get("profit")) > 0:
                                            stock_usdt = float(trade_result.get("amount")) * float(pointCode.get('price'))
                                            if stock_usdt > 200:
                                                opt_usdt = stock_usdt
                                                need_pc = True

                                    optres = self.trade.buy(usdT = opt_usdt, price = pointCode.get('price'), tradeVariety = self.tradeVariety)
                                    if optres is not None:
                                        self.addOrder(optype = 'buy', currency = optres.get('deal_money'), code = pointCode.get('code'), price = optres.get('filledRate'), timedate = pointCode.get('timedate'), ispc=True)

                                        if need_pc == True and stock_usdt > 0:
                                            if float(optres.get('deal_money')) >= stock_usdt - 5:
                                                self.doPcRecordToResult(pointCode, "空单反向止盈平仓")

                    else:
                        self.addOrder(optype = 'buy', code = pointCode.get('code'), price = pointCode.get('price'), timedate = pointCode.get('timedate'))


                elif pointCode.get('trade_opt') == 'sell':

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

                            # 加空单
                            if float(lastOrder['price']) < float(pointCode.get('price')):
                                pointPrice = (float(pointCode.get('price')) - float(lastOrder['price'])) / float(lastOrder['price'])
                                if pointPrice > 0.00618:
                                    allNotCompTradesBuy = allNotCompTrades.loc[allNotCompTrades.type == 'buy']
                                    if len(allNotCompTradesBuy) > 0:

                                        trade_result = self.getTradeResult(pointCode.get('timedate'), pointCode.get('price'))
                                        opt_usdt = spendUsdt

                                        need_pc = False
                                        stock_usdt = 0
                                        if trade_result.get("opt") == 'buy':
                                            if float(trade_result.get("profit")) > 0:
                                                stock_usdt = float(trade_result.get("amount")) * float(pointCode.get('price'))
                                                if stock_usdt > 100:
                                                    opt_usdt = stock_usdt
                                                    need_pc = True

                                        optres = self.trade.sell(usdT = opt_usdt, price = pointCode.get('price'), tradeVariety = self.tradeVariety)
                                        if optres is not None:
                                            self.addOrder(optype = 'sell', currency = optres.get('deal_money'), code = pointCode.get('code'), price = optres.get('filledRate'), timedate = pointCode.get('timedate'), ispc = True)

                                            if need_pc == True and stock_usdt > 0:
                                                if float(optres.get('deal_money')) >= stock_usdt - 5:
                                                    self.doPcRecordToResult(pointCode, "多单止盈平仓")
                                    else:
                                        self.addOrder(optype = 'sell', currency = spendUsdt, code = pointCode.get('code'), price = pointCode.get('price'), timedate = pointCode.get('timedate'))
                        else:
                            # 反向单
                            if float(lastOrder['price']) < float(pointCode.get('price')):
                                pointPrice = (float(pointCode.get('price')) - float(lastOrder['price'])) / float(lastOrder['price'])
                                if pointPrice > 0.00818:

                                    trade_result = self.getTradeResult(pointCode.get('timedate'), pointCode.get('price'))
                                    opt_usdt = self.initUsdtUint

                                    need_pc = False
                                    stock_usdt = 0
                                    if trade_result.get("opt") == 'buy':
                                        opt_usdt = 2 * self.initUsdtUint

                                        if float(trade_result.get("profit")) > 0:
                                            stock_usdt = float(trade_result.get("amount")) * float(pointCode.get('price'))
                                            if stock_usdt > 200:
                                                opt_usdt = stock_usdt
                                                need_pc = True

                                    optres = self.trade.sell(usdT = opt_usdt, price = pointCode.get('price'), tradeVariety = self.tradeVariety)
                                    if optres is not None:
                                        self.addOrder(optype = 'sell', currency = optres.get('deal_money'), code = pointCode.get('code'), price = optres.get('filledRate'), timedate = pointCode.get('timedate'), ispc = True)
                                        if need_pc == True and stock_usdt > 0:
                                            if float(optres.get('deal_money')) >= stock_usdt - 5:
                                                self.doPcRecordToResult(pointCode, "多单反向止盈平仓")
                    else:
                        self.addOrder(optype = 'sell', code = pointCode.get('code'), price = pointCode.get('price'), timedate = pointCode.get('timedate'))

                else:
                    print('has no point to opt')

                    # print('orders', self.orders)
                    # self.pingc(pointCode.get('timedate'), pointCode.get('price'))
                #print(pointCode)

                # print('hhhhupcode-------------',pointCode, self.lastPointCode)

                self.lastPointCode = pointCode

                db_mysql = Mysql(self.tradeVariety)
                db_mysql.updatePrice(type = self.lastPointCode.get('type'), price = self.lastPointCode.get('price'), timedate = func.transTimedateToDate(self.lastPointCode.get('timedate')), pair = self.tradeVariety)

                data_share_map['timedate'] = self.lastPointCode.get('timedate')
                data_share_map['price'] = self.lastPointCode.get('price')

                # objs = self.getTradeObj(pointCode.get('timedate'), pointCode.get('price'))
                # for ok in objs:
                #     data_share_map_summay[ok] = objs[ok]

                # trade_result = self.getTradeResult(pointCode.get('timedate'), pointCode.get('price'))
                # print(trade_result.get("result_str"))
                self.dumpTrade(pointCode.get('timedate'), pointCode.get('price'))

                print(pointCode.get("trade_msg"), " opt: " + pointCode.get("trade_opt"), ", code: %s\n" % pointCode.get("code"))
                print(pointCode.get("nd_obj").get("nd_point_str"))

                # time.sleep(timeSepM * 60)
                # time.sleep(10)
                time.sleep(random.randint(5, 15))

        except Exception as e:
            curpath = os.path.dirname(os.path.realpath(__file__))
            logpath = os.path.join(curpath, "data/ShipanStepOrderException.log")

            print('handle exception: %s' % e)

            writeLog(logpath, e)
            writeLog(logpath, traceback.print_exc())
            writeLog(logpath, 'traceback.format_exc():\n%s' % traceback.format_exc())

            time.sleep(3)

    def getLevelPrice(self, level, currency = 0):
        currency = float(currency)
        if currency == 0:
            startLevelPrice = self.initUsdtUint
        else:
            startLevelPrice = currency
        # return startLevelPrice
        levelPrice = 0
        if level == 0:
            levelPrice = startLevelPrice
        else:
            maxLevel = 16
            if level > maxLevel:
                level = maxLevel

            rel = 1 + (level - 1) * (level * 1 /maxLevel)

            levelPrice = startLevelPrice + level * (rel * startLevelPrice / maxLevel)

            if levelPrice > 3 * startLevelPrice:
                levelPrice = 3 * startLevelPrice

        return float("%.2f" % levelPrice)

    def getCurrentHouerData(self):
        nowHour = datetime.datetime.now().strftime('%Y%m%d%H')
        print('update data houer %s' % nowHour)
        mongo = cfg.getMongo(self.tradeVariety)
        db = MongoDB(mongo.get('DB'), 'gataio_eth_trades_h' + nowHour, mongo.get('DB_HOST'), mongo.get('DB_USER'), mongo.get('DB_PASS'))
        return list(db.query_all())

    def getOrderLevel(self, linek):
        df = pd.DataFrame(list(self.orders))
        level = 0
        if len(df) > 0:
            dfrow = df.loc[df.index[linek]]
            for gk in range(linek):
                crow = df.loc[df.index[linek - gk - 1]]
                if crow['type'] == dfrow['type']:
                    level = level + 1
                else:
                    break
        return level

    def getTradeResult(self, timedate, price):
        self.pingc(timedate, price)
        df = pd.DataFrame(self.orders)
        showStr = ""
        dataListStr = ""

        opt = 'none'
        amount = 0
        open_price = 0
        profit = 0
        open_date = 'empty'

        df['complete'] = df['complete'].astype(float)

        df = df.loc[df.complete == 0]

        if len(df) > 0:
            open_date = df.loc[0]['timedate']

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
            opt = "none"
            amount = Eamount
            open_price = 0

            if Ebc - Esc > 0:
                open_price = (Ebc - Esc) / Eamount
                Eshow = "做多:数量{:.4f}，金额{:.2f}，成本价{:.2f}".format(Eamount, Ebc - Esc, open_price)
                # pf = (price - (Ebc - Esc) / Eamount) * Eamount
                opt = "buy"

            elif Ebc - Esc < 0:
                open_price = (Esc - Ebc) / Eamount
                Eshow = "做空:数量{:.4f}，金额{:.2f}，成本价{:.2f}".format(Eamount, Esc - Ebc, open_price)
                # pf = ((Esc - Ebc) / Eamount - price) * Eamount
                opt = "sell"
            else:
                pass

            c_profit = df['profit'].astype('float64').sum()
            profit = c_profit

            r_transfer = c_profit / self.midcresult['mc']

            showStr = showStr + ("最大占用 %.2f" % self.midcresult['mcMax']) + "\n"
            # showStr = showStr + ("最小占用 %.2f" % self.midcresult['mcMin']) + "\n"

            showStr = showStr + ("转化率 %.2f" % (r_transfer * 100)) + "\n"

            showStr = showStr + ("总体盈利 %.2f" % c_profit) + "\n"
            showStr = showStr + ("总单数 %d , 多单 %d, 空单 %d" % (len(df), len(df_buy), len(df_sell))) + "\n"

            showStr = showStr + ("当前价格 %.2f" % price) + "\n"
            showStr = showStr + ("方向 %s" % Eshow) + "\n"

        result_str = dataListStr + "\n" + showStr

        return {"result_str": result_str, "opt": opt, "amount": "%.5f" % amount, "open_price": "%.2f" % open_price, "profit": "%.2f" % profit, "open_date": open_date}

    def dumpTrade(self, timedate, price):
        result_obj = self.getTradeResult(timedate, price)
        print(result_obj.get("result_str"))

    def pingc(self, timedate, price, forcepc = False):
        price = float(price)
        for i in range(len(self.orders)):
            if self.orders[i]['complete'] == 1:
                continue
            self.orders[i]['currency'] = float(self.orders[i]['currency'])
            absVal = abs(price - float(self.orders[i]['price']))
            absP = absVal / price
            # print('absp',absP)
            if forcepc == True:
                self.orders[i]['complete'] = 1
            else:
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

            self.orders[i]['price'] = Decimal(self.orders[i]['price']).quantize(Decimal('0.0000'))
            self.orders[i]['pt'] = Decimal(absP).quantize(Decimal('0.00000'))
            self.orders[i]['profit'] = Decimal(self.orders[i]['profit']).quantize(Decimal('0.000'))

        if forcepc == True:
            db_mysql = Mysql(self.tradeVariety)
            db_mysql.updatepcOrders()
            self.midcresult['mcMax'] = 0

    def addOrder(self, optype = 'buy', currency = 0, price = None, timedate = None, code = None, ispc = False):
        if currency == 0:
            currency = self.initUsdtUint
        if ispc == True:
            order = {"type": optype, "currency": currency, "price": price, "timedate": func.transTimedateToDate(timedate), "code": code, "complete": 0, "suc": 0, "profit": 0}
            self.orders.append(order)

            db_mysql = Mysql(self.tradeVariety)
            db_mysql.insertOrders(type=optype, currency=order.get('currency'), price=float(order.get('price')), timedate=func.transTimedateToDate(timedate), code=code, complete=0, suc=0, profit=0)

        else:
            if optype == 'buy':
                optres = self.trade.buy(currency, price, tradeVariety = self.tradeVariety)
            else:
                optres = self.trade.sell(currency, price, tradeVariety = self.tradeVariety)

            if optres is not None:
                order = {"type": optype, "currency": optres.get('deal_money'), "price": optres.get('filledRate'), "timedate": func.transTimedateToDate(timedate), "code": code, "complete": 0, "suc": 0, "profit": 0}
                self.orders.append(order)

                db_mysql = Mysql(self.tradeVariety)
                db_mysql.insertOrders(type=optype, currency=order.get('currency'), price=float(order.get('price')), timedate=func.transTimedateToDate(timedate), code=code, complete=0, suc=0, profit=0)

    # def updateFirstOrder(self, suc = 1, profit = 0):
    #     if len(self.order) == 1:

    def printRunTime(self, showmark = "run time:"):
        start = self.startTime
        end = time.time()
        self.startTime = end
        # print("%s run sec %.2f" % (showmark, end - start))

    def autoStart(self, datalist, data_share_map, data_share_map_summay):
        # for i in range(100):
        #     datalist.append(i)
        #     time.sleep(1)
        # sp = Shipan()

        initUsdtUint = float(sys.argv[1])
        tradeVariety = sys.argv[2]


        self.initResoure(tradeVariety)

        self.initUsdtUint = initUsdtUint
        self.tradeVariety = tradeVariety

        store_orders = func.getOrderFromStore(tradeVariety)

        if len(store_orders) > 0:
            self.orders = list(store_orders)

        f = '%Y-%m-%d %H:%M:%S'
        now = time.strftime(f)

        self.printRunTime('sys started')

        timeStart = now
        # timeEnd = '2020-02-14 09:40:00'

        # timeStart = '2019-01-28 11:05:00'
        # timeEnd = '2019-01-28 12:58:00'

        # 180000 400000
        # timeEnd = now
        self.cha.cacheTimeArea(timeStart, timeStart)
        # p.getDataStr(timeStart, timeEnd, ah = 22, aw = 40, kh = 22, kw = 80)
        # p.drawIndexCode(timeStart, timeEnd, ah = 22, aw = 40, kh = 22, kw = 80, timeSepM = 1)
        # print(p.getPoint(timeStart, timeEnd))
        self.stepOrder(timeStart, timeStart, timeSepM = 1, proxy_list = datalist, data_share_map = data_share_map, data_share_map_summay=data_share_map_summay)

    def pcRecord(self, open_date, timedate, open_price, end_price, amount, direct, profit, msg = ""):
        variety = self.tradeVariety
        curpath = os.path.dirname(os.path.realpath(__file__))
        record_file = os.path.join(curpath, "data/"+"trade_record_" + variety.lower().replace("-", "_") + ".txt")
        objs = {"variety": variety, "open_date": open_date, "timedate": timedate, "open_price": str(open_price), "end_price": str(end_price), "amount": str(amount), "direct": str(direct), "profit": str(profit), "msg": msg}
        head_title = ",".join(objs.keys())

        file_content = ''
        try:
            with open(record_file, 'r', encoding='utf-8') as f:
                file_content = f.read()
        except Exception as e:
            pass

        cal_profit = 0
        if len(file_content) > 0:
            split_content = file_content.split("\n")
            for i in range(len(split_content)):
                if i > 0 and i < len(split_content) - 1:
                    row = split_content[i]
                    cal_profit = cal_profit + float(row.split(",")[-2])

            cal_profit = cal_profit + float(profit)
            last_row_str = "合计盈利：%.2f" % cal_profit

            del(split_content[-1])
            with open(record_file, 'w', encoding='utf-8') as f:
                f.write("\n".join(split_content) + "\n")
                f.write(",".join(objs.values()))
        else:
            last_row_str = "合计盈利：%.2f" % float(profit)
            with open(record_file, 'w', encoding='utf-8') as f:
                f.write(head_title + "\n")
                f.write(",".join(objs.values()))

        with open(record_file, 'a', encoding='utf-8') as f:
            f.write("\n" + last_row_str)


class DecimalEncoder(json.JSONEncoder):
    def default(self, obj):
        if isinstance(obj, Decimal):
            return float(obj)
        elif isinstance(obj,datetime.datetime):
            return obj.strftime("%Y-%m-%d %H:%M:%S")
        else:
            return json.JSONEncoder.default(self,obj)

if __name__ == "__main__":
    if (len(sys.argv) < 3) :
        print('usdt unit or variety not set')
        exit()

    initUsdtUint = float(sys.argv[1])
    if (initUsdtUint <= 0):
        print('usdt value error')
        exit()
    tradeVariety = sys.argv[2]

    # tradeVariety  'ETH-USDT' 'EOS-USDT' 'BTC-USDT':

    sp = Shipan(tradeVariety)
    sp.initUsdtUint = initUsdtUint
    sp.tradeVariety = tradeVariety

    while True:
        print('starting main thread...')
        sp.autoStart(datalist = [], data_share_map = {}, data_share_map_summay = {})
        print('main thread stoped')


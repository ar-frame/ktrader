#!/usr/bin/env python3.6
# -*- coding: utf-8 -*-
# encoding=utf-8  

'simulate fot eth_usdt trade moudule'
__author__ = 'assnr'

from dbconn import MongoDB
import random
import time
import datetime
import json
from log import writeLog
import pandas as pd
import func
import cfg
class Simulate:
    def __init__(self, initStockName):
        mongo = cfg.getMongo()
        nowDay = datetime.datetime.now().strftime('%Y%m%d')
        if initStockName.startswith('6'):
            dbName = 'SH' + initStockName
        else:
            dbName = 'SZ' + initStockName

        self.db_bigdata = MongoDB(dbName, nowDay, mongo.get('DB_HOST'), mongo.get('DB_USER'), mongo.get('DB_PASS'))

    def getTradeData(self):
        trade_collections = self.get_trade_cols()
        for colName in trade_collections:
            # selectName = trade_collections[7]
            selectName = colName
            self.db_bigdata.set_current_collections(selectName)
            currentData = list(self.db_bigdata.query_all())
            # print(currentData)
            self.getSummay(currentData)

        # print(trade_collections)

    def getTimeData(self, timedate):
        year = timedate[0:8]
        timef = timedate[-6:]
        return {'year': year, 'timef': timef}

    def getSummay(self, dataLines):
        df = pd.DataFrame(dataLines)
        selldf = df.loc[df['type'] == 'sell']

        amount_sell = selldf['amount'].astype('float64')

        usdt_sell_total = selldf['amount'].astype('float64') * selldf['price'].astype('float64')

        buydf = df.loc[df['type'] == 'buy']
        amount_buy = buydf['amount'].astype('float64')

        usdt_buy_total = buydf['amount'].astype('float64') * buydf['price'].astype('float64')

        maxp =df['price'].astype('float64').max()
        self.writeTradeLog("最高价: %s " % maxp)

        minp = df['price'].astype('float64').min()

        self.writeTradeLog("最低价: %s " % minp)


        self.writeTradeLog("买入量: %.2f" % amount_buy.sum())
        self.writeTradeLog("卖出量: %.2f" % amount_sell.sum())
        self.writeTradeLog("成交量: %.2f" % (amount_buy.sum() + amount_sell.sum()))

        self.writeTradeLog("买入金额: %.2f" % usdt_buy_total.sum())
        self.writeTradeLog("卖出金额: %.2f" % usdt_sell_total.sum())
        finusdt = usdt_buy_total.sum() - usdt_sell_total.sum()
        totalusdt = usdt_buy_total.sum() + usdt_sell_total.sum()
        self.writeTradeLog("流入金额: %.2f usdt" % finusdt)
        self.writeTradeLog("成交金额: %.2f" % totalusdt)

        dataCount = len(dataLines)

        avgbuycount = usdt_buy_total.sum() / len(buydf)

        maxbuynum = buydf['amount'].astype('float64').max()
        dfmaxbuy = buydf.loc[buydf.amount.astype('float64') == maxbuynum]

        if len(dfmaxbuy) == 0:
            takeTime = 0
            showtime = 0
            takeBuyPrice = 0
        else:
            takeTime = dfmaxbuy['timedate'][dfmaxbuy['timedate'].index[0]]
            showtime = self.getTimeData(takeTime)
            showtime = showtime['timef']
            takeBuyPrice = dfmaxbuy['price'][dfmaxbuy['price'].index[0]]

        maxsellnum = selldf['amount'].astype('float64').max()

        dfmaxsell = selldf.loc[selldf.amount.astype('float64') == maxsellnum]
        print(dfmaxsell, len(dfmaxsell))
        if len(dfmaxsell) == 0:
            takeSellPrice = 0
            takeSellTime = 0
            showselltime = 0
        else:
            takeSellPrice = dfmaxsell['price'][dfmaxsell['price'].index[0]]

            takeSellTime = dfmaxsell['timedate'][dfmaxsell['timedate'].index[0]]
            showselltime = self.getTimeData(takeSellTime)
            showselltime = showselltime['timef']
        # print(dfmaxsell)
       


        minbuynum = buydf['amount'].astype('float64').min()
        self.writeTradeLog("交易笔数: %d" % dataCount)
        self.writeTradeLog("买单笔数: %d,平均每单：%.2f usdt, 最大单交易量：%.4f, 发生时间:%s 价格：%s, 最小交易量: %.6f " % (len(buydf), avgbuycount, maxbuynum, showtime, takeBuyPrice, minbuynum))
        avgsellcount = usdt_sell_total.sum() / len(selldf)
        # maxsellnum = selldf['amount'].astype('float64').max()
        minsellnum = selldf['amount'].astype('float64').min()
        self.writeTradeLog("卖单笔数: %d,平均每单：%.2f usdt, 最大单交易量：%.4f ，发生时间:%s 价格:%s ， 最小交易量: %.6f " % (len(selldf), avgsellcount, maxsellnum, showselltime, takeSellPrice, minsellnum))


        openprice = df['price'].astype('float64')[df['price'].index[0]]
        self.writeTradeLog("开盘价格: %.2f" % openprice)

        endprice = df['price'].astype('float64')[df['price'].index[-1]]
        # print(endprice)
        
        self.writeTradeLog("收盘价格: %.2f" % endprice)

        if endprice > openprice:
            ratio = (endprice - openprice) / openprice * 100
            self.writeTradeLog("涨幅^ %.2f%%" % ratio)
        elif endprice < openprice:
            ratio = (openprice - endprice) / openprice * 100
            self.writeTradeLog("跌幅v %.2f%%" % ratio)
        else:
            self.writeTradeLog("涨幅 0%")
        zfratio = (maxp - minp) / minp * 100
        self.writeTradeLog("振幅: %.2f%%" % zfratio)

        self.writeTradeLog("数据日期: %s" % self.getTimeData(df['timedate'][df['timedate'].index[0]]))


        self.writeTradeLog("-------------------------------------\n\n\n")

    def getSummayObj(self, dataLines):
        df = pd.DataFrame(dataLines)
        summary = {}

        selldf = df.loc[df['type'] == 'sell']

        amount_sell = selldf['amount'].astype('float64')

        usdt_sell_total = selldf['amount'].astype('float64') * selldf['price'].astype('float64')

        buydf = df.loc[df['type'] == 'buy']
        amount_buy = buydf['amount'].astype('float64')

        usdt_buy_total = buydf['amount'].astype('float64') * buydf['price'].astype('float64')

        maxp =df['price'].astype('float64').max()
        # self.writeTradeLog("最高价: %s " % maxp)

        summary['maxPrice'] = "最高价: %s " % maxp

        minp = df['price'].astype('float64').min()

        # self.writeTradeLog("最低价: %s " % minp)
        summary['minPrice'] = "最低价: %s " % minp

        # self.writeTradeLog("买入量: %.2f" % amount_buy.sum())
        summary['buyAmount'] = "买入量: %.2f" % amount_buy.sum()

        # self.writeTradeLog("卖出量: %.2f" % amount_sell.sum())
        summary['sellAmount'] = "卖出量: %.2f" % amount_sell.sum()

        # self.writeTradeLog("成交量: %.2f" % (amount_buy.sum() + amount_sell.sum()))

        # self.writeTradeLog("买入金额: %.2f" % usdt_buy_total.sum())
        # self.writeTradeLog("卖出金额: %.2f" % usdt_sell_total.sum())
        finusdt = usdt_buy_total.sum() - usdt_sell_total.sum()
        totalusdt = usdt_buy_total.sum() + usdt_sell_total.sum()

        # self.writeTradeLog("流入金额: %.2f usdt" % finusdt)
        summary['desUsdt'] = "流入金额: %.2f usdt" % finusdt

        # self.writeTradeLog("成交金额: %.2f" % totalusdt)
        summary['dealUsdt'] = "成交金额: %.2f" % totalusdt

        dataCount = len(dataLines)

        avgbuycount = usdt_buy_total.sum() / len(buydf)

        maxbuynum = buydf['amount'].astype('float64').max()
        dfmaxbuy = buydf.loc[buydf.amount.astype('float64') == maxbuynum]

        if len(dfmaxbuy) == 0:
            takeTime = 0
            showtime = 0
            takeBuyPrice = 0
        else:
            takeTime = dfmaxbuy['timedate'][dfmaxbuy['timedate'].index[0]]
            showtime = self.getTimeData(takeTime)
            showtime = showtime['timef']
            takeBuyPrice = dfmaxbuy['price'][dfmaxbuy['price'].index[0]]

        maxsellnum = selldf['amount'].astype('float64').max()

        dfmaxsell = selldf.loc[selldf.amount.astype('float64') == maxsellnum]
        # print(dfmaxsell, len(dfmaxsell))
        if len(dfmaxsell) == 0:
            takeSellPrice = 0
            takeSellTime = 0
            showselltime = 0
        else:
            takeSellPrice = dfmaxsell['price'][dfmaxsell['price'].index[0]]

            takeSellTime = dfmaxsell['timedate'][dfmaxsell['timedate'].index[0]]
            showselltime = self.getTimeData(takeSellTime)
            showselltime = showselltime['timef']
        # print(dfmaxsell)
       
        minbuynum = buydf['amount'].astype('float64').min()
        # self.writeTradeLog("交易笔数: %d" % dataCount)
        # self.writeTradeLog("买单笔数: %d,平均每单：%.2f usdt, 最大单交易量：%.4f, 发生时间:%s 价格：%s, 最小交易量: %.6f " % (len(buydf), avgbuycount, maxbuynum, showtime, takeBuyPrice, minbuynum))
        avgsellcount = usdt_sell_total.sum() / len(selldf)
        # maxsellnum = selldf['amount'].astype('float64').max()
        minsellnum = selldf['amount'].astype('float64').min()
        # self.writeTradeLog("卖单笔数: %d,平均每单：%.2f usdt, 最大单交易量：%.4f ，发生时间:%s 价格:%s ， 最小交易量: %.6f " % (len(selldf), avgsellcount, maxsellnum, showselltime, takeSellPrice, minsellnum))


        openprice = df['price'].astype('float64')[df['price'].index[0]]
        # self.writeTradeLog("开盘价格: %.2f" % openprice)

        endprice = df['price'].astype('float64')[df['price'].index[-1]]
        # print(endprice)
        
        # self.writeTradeLog("收盘价格: %.2f" % endprice)

        if endprice > openprice:
            ratio = (endprice - openprice) / openprice * 100
            # self.writeTradeLog("涨幅^ %.2f%%" % ratio)
        elif endprice < openprice:
            ratio = (openprice - endprice) / openprice * 100
            # self.writeTradeLog("跌幅v %.2f%%" % ratio)
        else:
            pass
            # self.writeTradeLog("涨幅 0%")
        zfratio = (maxp - minp) / minp * 100
        # self.writeTradeLog("振幅: %.2f%%" % zfratio)

        # self.writeTradeLog("数据日期: %s" % self.getTimeData(df['timedate'][df['timedate'].index[0]]))
        lastDate = func.transTimedateToDate(df['timedate'][df['timedate'].index[len(df['timedate']) - 1]])
        firstDate = func.transTimedateToDate(df['timedate'][df['timedate'].index[0]])
        summary['date'] = "数据日期: %s-%s" % (firstDate, lastDate)

        return summary




    def get_trade_cols(self):
        collections = self.db_bigdata.get_all_collections()
        collections_trade = [colName for colName in collections]
        collections_trade.sort()
        return collections_trade

    def writeTradeLog(self, logstr):
        print(logstr)
        # writeLog('ts.log', logstr)



if __name__ == "__main__":
    sim = Simulate()
    sim.getTradeData()
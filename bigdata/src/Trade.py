#!/usr/bin/env python3.6
# -*- coding: utf-8 -*-

'trade moudule'
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
from decimal import Decimal
try:
    import thread
except ImportError:
    import _thread as thread
import os
import func
import cfg
from gateAPI import GateIO
from okex.lever_api import LeverAPI
class Trade:

    def __init__(self):
        config = cfg.getCfg()
        self.startTime = time.time()
        self.TRADE_TYPE = config.get('set', 'TRADE_TYPE')
        self.SHIPAN_ENABLE = config.get('set', 'SHIPAN_ENABLE')

        nowHour = datetime.datetime.now().strftime('%Y%m%d%H')

        ## 填写 apiKey APISECRET
        apiKey = config.get('okex', 'apiKey')
        secretKey = config.get('okex', 'secretKey')
        passphrase = config.get('okex', 'passphrase')

        API_QUERY_URL = config.get('gateio', 'API_QUERY_URL')
        API_TRADE_URL = config.get('gateio', 'API_TRADE_URL')

        if self.TRADE_TYPE == 'gateio':
        	self.gate_trade = GateIO(API_TRADE_URL, apiKey, secretKey)
        else:
        	self.gate_trade = LeverAPI(apiKey, secretKey, passphrase, True)


    def sell(self, usdT = 5, price = None, trytime = 3, tradeVariety = 'ETH-USDT'):

        if self.SHIPAN_ENABLE != 'yes':
            print("SHIPAN DISABLED")
            return False
        if self.TRADE_TYPE == 'gateio':
            return self.sell_gate(usdT, price, trytime, tradeVariety)
        else:
            return self.sell_okex(usdT, price, trytime, tradeVariety)

    def buy(self, usdT = 5, price = None, trytime = 3, tradeVariety = 'ETH-USDT'):

        if self.SHIPAN_ENABLE != 'yes':
            print("SHIPAN DISABLED")
            return False

        if self.TRADE_TYPE == 'gateio':
            return self.buy_gate(usdT, price, trytime, tradeVariety)
        else:
            return self.buy_okex(usdT, price, trytime, tradeVariety)


    def sell_okex(self, usdT = 5, price = None, trytime = 3, tradeVariety = 'ETH-USDT'):
        cpair = 'eth-usdt'
        if tradeVariety == 'ETH-USDT':
            cpair = 'eth-usdt'
        elif tradeVariety == 'EOS-USDT':
            cpair = 'eos-usdt'
        elif tradeVariety == 'BTC-USDT':
            cpair = 'btc-usdt'

        print("cpair %s" % cpair, "tradeVariety %s" % tradeVariety)
        if trytime == 0:
            return None

        if trytime == 1:
            price = Decimal(price) - Decimal(price) * Decimal('0.0018')
            pass

        amount = "%.6f" % (Decimal(usdT) / Decimal(price))
        print(price, amount, trytime, 'sell')
        try:
            sell_result = self.gate_trade.sell(price, amount, cpair = cpair)
        except Exception as e:
            print("sell json load err:")
            print(e)
            return None
        # deal_money filledRate deal_stock result
        print("sell_order_result", sell_result)

        if sell_result.get('result') == 'false':
            print("data error")
            print(sell_result)
            return None
        else:

            if float(sell_result.get('deal_stock')) > 0:
                print(sell_result)
                return sell_result
            else:
                time.sleep(0.1)
                return self.sell(usdT, price, trytime - 1, tradeVariety = tradeVariety)


    def sell_gate(self, usdT = 5, price = None, trytime = 5, tradeVariety = 'ETH-USDT'):
        if trytime == 0:
            return None

        if trytime == 1:
            price = Decimal(price) - Decimal(price) * Decimal('0.0018')

        cpair = 'eth_usdt'
        if tradeVariety == 'ETH-USDT':
            cpair = 'eth_usdt'
        elif tradeVariety == 'EOS-USDT':
            cpair = 'eos_usdt'
        elif tradeVariety == 'BTC-USDT':
            cpair = 'btc_usdt'

        amount = "%.4f" % (Decimal(usdT) / Decimal(price))
        print(price, amount, trytime, 'sell')
        try:
            sell_result = json.loads(self.gate_trade.sell(cpair, price, amount))
        except Exception as e:
            print("sell json load err:")
            print(e)
            return None
        print(sell_result)

        if sell_result.get('result') == 'false':
            print("data error")
            print(sell_result)
            return None
        else:

            if float(sell_result.get('filledAmount')) > 0:
                deal_stock = float(sell_result.get('filledAmount'))
                deal_price = float(sell_result.get('filledRate'))
                deal_money = deal_stock * deal_price
                return {'result': 'true', 'deal_stock': deal_stock, 'deal_money': deal_money, 'filledRate': deal_price}

            else:
                time.sleep(0.1)
                return self.sell(usdT, price, trytime - 1, tradeVariety = tradeVariety)

    def buy_okex(self, usdT = 5, price = None, trytime = 3, tradeVariety = 'ETH-USDT'):
        cpair = 'eth-usdt'
        if tradeVariety == 'ETH-USDT':
            cpair = 'eth-usdt'
        elif tradeVariety == 'EOS-USDT':
            cpair = 'eos-usdt'
        elif tradeVariety == 'BTC-USDT':
            cpair = 'btc-usdt'

        print('cpair', cpair)

        if trytime == 0:
            return None
        if trytime == 1:
            price = Decimal(price) +  Decimal(price) * Decimal('0.0018')
            pass

        amount = "%.6f" % (Decimal(usdT) / Decimal(price))
        print(price, amount, trytime , 'buy')
        try:
            buy_result = self.gate_trade.buy(price, amount, cpair = cpair)
        except Exception as e:
            print("buy json load err:")
            print(e)
            return None
        print("buy_order_result", buy_result)

        if buy_result.get('result') == 'false':
            print("data error")
            print(buy_result)
            return None
        else:

            if float(buy_result.get('deal_stock')) > 0:
                print(buy_result)
                return buy_result
            else:
                time.sleep(0.1)
                return self.buy(usdT, price, trytime - 1, tradeVariety = tradeVariety)

    def buy_gate(self, usdT = 5, price = None, trytime = 5, tradeVariety = 'ETH-USDT'):
        if trytime == 0:
            return None
        if trytime == 1:
            price = Decimal(price) +  Decimal(price) * Decimal('0.0018')

        cpair = 'eth_usdt'
        if tradeVariety == 'ETH-USDT':
            cpair = 'eth_usdt'
        elif tradeVariety == 'EOS-USDT':
            cpair = 'eos_usdt'
        elif tradeVariety == 'BTC-USDT':
            cpair = 'btc_usdt'



        amount = "%.4f" % (Decimal(usdT) / Decimal(price))
        print(price, amount, trytime , 'buy')
        try:
            buy_result = json.loads(self.gate_trade.buy(cpair, price, amount))
        except Exception as e:
            print("buy json load err:")
            print(e)
            return None
        # print(buy_result)

        if buy_result.get('result') == 'false':
            print("data error")
            print(buy_result)
            return None
        else:

            if float(buy_result.get('filledAmount')) > 0:

                deal_stock = float(buy_result.get('filledAmount'))
                deal_price = float(buy_result.get('filledRate'))
                deal_money = deal_stock * deal_price
                return {'result': 'true', 'deal_stock': deal_stock, 'deal_money': deal_money, 'filledRate': deal_price}
            else:
                time.sleep(0.1)
                return self.buy(usdT, price, trytime - 1, tradeVariety = 'ETH-USDT')

if __name__ == "__main__":
    t = Trade()
    # res = t.sell(1, 148.3)
    res = t.buy(0.19, 200, tradeVariety = 'ETH-USDT')
    #res = t.sell(10, 9600, tradeVariety = 'BTC-USDT')
    print(res)


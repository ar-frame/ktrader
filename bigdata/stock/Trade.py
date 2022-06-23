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
        self.startTime = time.time()

        nowHour = datetime.datetime.now().strftime('%Y%m%d%H')
        
        config = cfg.getCfg()

        ## 填写 apiKey APISECRET
        apiKey = config.get('okex', 'apiKey')
        secretKey = config.get('okex', 'secretKey')
        passphrase = config.get('okex', 'passphrase')
        # API_QUERY_URL = config.get('gateio', 'API_QUERY_URL')
        # API_TRADE_URL = config.get('gateio', 'API_TRADE_URL')
        

        # self.gate_trade = GateIO(API_TRADE_URL, apiKey, secretKey)
        self.gate_trade = LeverAPI(apiKey, secretKey, passphrase, True)

    def sell(self, usdT = 5, price = None, trytime = 3):
        if trytime == 0:
            return None

        if trytime == 1:
            price = Decimal(price) - Decimal(price) * Decimal('0.0018')
            pass

        amount = "%.4f" % (Decimal(usdT) / Decimal(price))
        print(price, amount, trytime, 'sell')
        try: 
            sell_result = self.gate_trade.sell(price, amount, cpair = 'eth_usdt')
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
                return self.sell(usdT, price, trytime - 1)


    def buy(self, usdT = 5, price = None, trytime = 3):
        if trytime == 0:
            return None
        if trytime == 1:
            price = Decimal(price) +  Decimal(price) * Decimal('0.0018')
            pass

        amount = "%.4f" % (Decimal(usdT) / Decimal(price))
        print(price, amount, trytime , 'buy')
        try: 
            buy_result = self.gate_trade.buy(price, amount, cpair = 'eth_usdt')
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
                return self.buy(usdT, price, trytime - 1)

if __name__ == "__main__":
    t = Trade()
    # res = t.sell(1, 148.3)
    res = t.buy(0.5, 142.35)
    print(res)
    
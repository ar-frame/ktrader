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
class Trade:

    def __init__(self):
        self.startTime = time.time()

        nowHour = datetime.datetime.now().strftime('%Y%m%d%H')
        
        config = cfg.getCfg()

        ## 填写 apiKey APISECRET
        apiKey = config.get('gateio', 'apiKey')
        secretKey = config.get('gateio', 'secretKey')

        API_QUERY_URL = config.get('gateio', 'API_QUERY_URL')
        API_TRADE_URL = config.get('gateio', 'API_TRADE_URL')
        

        self.gate_trade = GateIO(API_TRADE_URL, apiKey, secretKey)

    def sell(self, usdT = 5, price = None, trytime = 5, tradeVariety = 'ETH-USDT'):
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

    def buy(self, usdT = 5, price = None, trytime = 5, tradeVariety = 'ETH-USDT'):
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
    # res = t.sell(2, 222.3, tradeVariety = 'ETH-USDT')
    res = t.buy(2, 7.3, tradeVariety = 'EOS-USDT')
    
    print(res)
    
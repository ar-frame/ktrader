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
import random
from gateAPI import GateIO
from okex.lever_api import LeverAPI
from binance.spot import Spot as Client

class Trade:

    def __init__(self):
        config = cfg.getCfg()
        self.startTime = time.time()
        self.TRADE_TYPE = config.get('set', 'TRADE_TYPE')
        self.SHIPAN_ENABLE = config.get('set', 'SHIPAN_ENABLE')

        nowHour = datetime.datetime.now().strftime('%Y%m%d%H')

        ## 填写 apiKey APISECRET
        apiKey = config.get(self.TRADE_TYPE, 'apiKey')
        secretKey = config.get(self.TRADE_TYPE, 'secretKey')

        if self.TRADE_TYPE == 'gateio':
            API_QUERY_URL = config.get('gateio', 'API_QUERY_URL')
            API_TRADE_URL = config.get('gateio', 'API_TRADE_URL')
            self.gate_trade = GateIO(API_TRADE_URL, apiKey, secretKey)
        elif self.TRADE_TYPE == 'binance':
            httpProxies = config.get(self.TRADE_TYPE, 'httpProxies')
            proxies = None
            if len(httpProxies) > 0:
                proxies = {'https': httpProxies}
            self.gate_trade = Client(key = apiKey, secret = secretKey, proxies = proxies)
        else:
            passphrase = config.get(self.TRADE_TYPE, 'passphrase')
            self.gate_trade = LeverAPI(apiKey, secretKey, passphrase, True)

    def sell(self, usdT = 5, price = None, trytime = 3, tradeVariety = 'ETH-USDT'):
        if self.SHIPAN_ENABLE != 'yes':
            print("SHIPAN DISABLED")
            return False
        if self.TRADE_TYPE == 'gateio':
            return self.sell_gate(usdT, price, trytime, tradeVariety)
        elif self.TRADE_TYPE == 'binance':
            return self.trade_binance('SELL', usdT, price, trytime, tradeVariety)
        else:
            return self.sell_okex(usdT, price, trytime, tradeVariety)

    def buy(self, usdT = 5, price = None, trytime = 3, tradeVariety = 'ETH-USDT'):

        if self.SHIPAN_ENABLE != 'yes':
            print("SHIPAN DISABLED")
            return False

        if self.TRADE_TYPE == 'gateio':
            return self.buy_gate(usdT, price, trytime, tradeVariety)
        elif self.TRADE_TYPE == 'binance':
            return self.trade_binance('BUY', usdT, price, trytime, tradeVariety)
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
                return self.buy(usdT, price, trytime - 1, tradeVariety = tradeVariety)

    def trade_binance(self, opt, usdT, price , trytime, tradeVariety):
        cpair = tradeVariety.upper().replace("-", "")
        print('cpair', cpair)

        if trytime == 0:
            return None

        if trytime == 1:
            if opt == 'BUY':
                price = Decimal(price) + Decimal(price) * Decimal('0.0018')
            else:
                price = Decimal(price) - Decimal(price) * Decimal('0.0018')

        price = Decimal(price).quantize(Decimal('0.00'))

        double_format = "%.6f"
        if cpair == 'BTCUSDT':
            double_format = "%.5f"
        amount = double_format % (Decimal(usdT) / Decimal(price))

        print(price, amount, trytime , opt)
        try:
            # asset borrow repay
            user_assets = self.gate_trade.margin_account()
            df = pd.DataFrame(user_assets['userAssets'])
            df.index = df['asset']

            asset_name = cpair[0:-4]
            current_asset = df.loc[asset_name]
            usdt_asset = df.loc['USDT']

            if opt == 'BUY':
                if float(usdt_asset['free']) < usdT:
                    borrow_usdt = self.gate_trade.margin_borrow('USDT', usdT)
                    print("need borrow usdt:", borrow_usdt)
            else:
                if float(current_asset['free']) < float(amount):
                    borrow_asset = self.gate_trade.margin_borrow(asset_name, amount)
                    print("need borrow asset", borrow_asset)
        except Exception as e:
            print("binance outer api error")
            print(e)
            return None

        try:
            params = {
                'symbol': cpair,
                'side': opt, # SELL OR BUY
                'type': 'LIMIT',
                'timeInForce': 'GTC',
                'quantity': amount,
                'price': price
            }

            print(params)
            new_order = self.gate_trade.new_margin_order(**params)

            print(new_order)
        except Exception as e:
            print("opt load err:")
            print(e)
            return None
        print("opt_order_result", params, new_order)
        if new_order.get('status') == 'FILLED':
            print('opt succ', new_order)
            order = {"deal_money": new_order['cummulativeQuoteQty'], "filledRate": new_order['price']}

            try:
                repay_asset = 'USDT'
                borrow_num = float(usdt_asset['borrowed'])
                free_num = float(usdt_asset['free'])

                if opt == 'BUY':
                    repay_asset = asset_name
                    borrow_num = float(current_asset['borrowed'])
                    free_num = float(current_asset['free'])

                if free_num > borrow_num:
                    repay_result = self.gate_trade.margin_repay(repay_asset, borrow_num)
                    print(repay_result)

            except Exception as e:
                print("repay error", e)

            return order
        else:
            time.sleep(random.randint(1, 5))
            open_orders = self.gate_trade.margin_open_orders()
            if len(open_orders) > 0:
                print("clear orders")
                try:
                    self.gate_trade.margin_open_orders_cancellation(cpair)
                    if opt == 'BUY':
                        return self.buy(usdT, price, trytime - 1, tradeVariety = tradeVariety)
                    else:
                        return self.sell(usdT, price, trytime - 1, tradeVariety = tradeVariety)
                except Exception as e:
                    print(e, str(e).find('Unknown order sent') > 0)
                    if str(e).find('Unknown order sent') > 0:
                        print("cancel time trade")
                        show_order = self.gate_trade.margin_order(symbol = cpair, orderId = new_order['orderId'])
                        print(show_order)
                        order = {"deal_money": show_order['cummulativeQuoteQty'], "filledRate": show_order['price']}
                        return order
                    else:
                        return None
            else:
                print("empty time trade")
                show_order = self.gate_trade.margin_order(symbol = cpair, orderId = new_order['orderId'])
                print(show_order)

                order = {"deal_money": show_order['cummulativeQuoteQty'], "filledRate": show_order['price']}
                return order

if __name__ == "__main__":
    t = Trade()
    # res = t.sell(1, 148.3)
    #  usdT = 5, price = None, trytime = 3, tradeVariety = 'ETH-USDT'
    # binance btc test for sell min amount > : 0.00017 4$ , for buy amount > : 0.001 25$ , if low get  'MIN_NOTIONAL' msg
    res = t.buy(usdT = 25, price = 5000, trytime = 3, tradeVariety = 'BTC-USDT')
    #res = t.sell(10, 9600, tradeVariety = 'BTC-USDT')
    print(res)


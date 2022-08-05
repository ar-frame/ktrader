import time
import json
import os
import datetime
from decimal import Decimal
import pandas as pd
from Mysql import Mysql
from dbconn import MongoDB
import cfg

def transTimeToTimedate(tstime):
    f2 = '%Y%m%d%H%M%S'
    tm_s_stu = time.gmtime(tstime)
    return time.strftime(f2, tm_s_stu)

def transTimeToTimedateF1(tstime):
    f = '%Y-%m-%d %H:%M:%S'
    tm_s_stu = time.gmtime(tstime)
    return time.strftime(f, tm_s_stu)

def transTimedateToTime(timedate):
    f2 = '%Y%m%d%H%M%S'
    timedate_stuct = time.strptime(str(timedate), f2)
    tm_s = time.mktime(timedate_stuct)
    return tm_s

def transF1DateToTime(timedate):
    f = '%Y-%m-%d %H:%M:%S'
    timedate_stuct = time.strptime(str(timedate), f)
    tm_s = time.mktime(timedate_stuct)
    return tm_s

def transTimedateToDate(timedate):
    tm_s = transTimedateToTime(timedate) + 8 * 3600
    return transTimeToTimedateF1(tm_s)

def transF1ToTimedateF2(dateFormatF1):
    f1 = '%Y-%m-%d %H:%M:%S'
    f2 = '%Y%m%d%H%M%S'

    timedate_stuct = time.strptime(str(dateFormatF1), f1)
    tm_s = time.mktime(timedate_stuct) + 8 * 3600

    tm_s_stu = time.gmtime(tm_s)
    return time.strftime(f2, tm_s_stu)

def printDataFrame(df):
    if len(df) > 0 :
        filter_ids = ['_id', 'id']

        for ids in filter_ids:
            if ids in df:
                del(df[ids])

        dumpstr = ""
        joinConnector = " "
        columns = df.columns.insert(0, 'index')
        padLen = 8
        for index,row in df.iterrows():
            if index == 0:
                header = []
                for col in columns:

                    if str(col) in ['ptimedate', 'timedate']:
                        header.append(str(col).ljust(19))
                    else:
                        header.append(str(col).ljust(padLen))

                    dumpstr = joinConnector . join(header)

            vals = [str(index).ljust(padLen)]
            for item in dict(row).values():

                vals.append(str(item).ljust(padLen))
            # dict(row).values()
            rowstr = joinConnector . join(vals)
            dumpstr = dumpstr + "\n" + rowstr

        return ("\ntrade records \n" + dumpstr)
    else:

        return "empty records"


def writeOrderStore(orders, tradeVariety):
    if len(orders) > 0:
        ordersStr = json.dumps(orders, cls=DecimalEncoder)
    else:
        ordersStr = ""

    storeFile = os.path.dirname(os.path.realpath(__file__)) + '/orders-' + tradeVariety + '.json'
    with open(storeFile, 'w') as f:
        f.write(ordersStr)

def getOrderFromStore(tradeVariety):
    # storeFile = os.path.dirname(os.path.realpath(__file__)) + '/orders-'+tradeVariety + '.json'
    # if os.path.exists(storeFile):
    #     with open(storeFile, 'r') as f:
    #             orderStr = f.read()
    #             if len(orderStr) > 0:
    #                 return list(json.loads(orderStr))
    #             else:
    #                 return []
    # else:
    #     return []
    db_type = cfg.getCfg().get('set', 'SHIPAN_DB_TYPE')
    if db_type == 'mysql':
        db_mysql = Mysql(tradeVariety)
        resdata = db_mysql.getOrders(rowCount=100)
        return resdata
    else:
        mongo_store = cfg.getMongo('store')
        db_mongo_store = MongoDB(mongo_store.get('DB'), 'orders', mongo_store.get('DB_HOST'), mongo_store.get('DB_USER'), mongo_store.get('DB_PASS'))
        return list(db_mongo_store.query_all(con = {"complete": {"$eq": '0'}})) + list(db_mongo_store.query_all(con = {"complete": {"$eq": 0}}))

def getTradeObjByOrders(resdata, price, currency = 2):
    df = pd.DataFrame(list(resdata))

    tradeObj = {}
    tradeObj['maxStore'] = 0
    tradeObj['transferRate'] = 0
    tradeObj['profit'] = 0
    tradeObj['orderCount'] = 0
    tradeObj['orderBuyCount'] = 0
    tradeObj['orderSellCount'] = 0
    tradeObj['cprice'] = 0
    tradeObj['summary'] = ""

    tradeObj['unit'] = currency
    price = float(price)
    if len(df) > 0:
        # print(df)
        firstData = df.loc[df.index[0]]
        dataListStr = printDataFrame(df)

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

        Eshow = ''
        if Ebc - Esc > 0:
            Eshow = "多单:数量{:.4f}，金额{:.4f}，成本价{:.4f}".format(Eamount, Ebc - Esc, (Ebc - Esc) / Eamount)
            pf = (price - (Ebc - Esc) / Eamount) * Eamount

            r_transfer = pf / (Ebc - Esc)

        elif Ebc - Esc == 0:
            Eshow = "空仓:数量0，金额0，成本价0"
            pf = 0
            r_transfer = 0
        else:
            Eshow = "空单:数量{:.4f}，金额{:.4f}，成本价{:.4f}".format(Eamount, Esc - Ebc, (Esc - Ebc) / Eamount)
            pf = ((Esc - Ebc) / Eamount - price) * Eamount
            r_transfer = pf / (Esc - Ebc)

        tradeObj['transferRate'] = ("%.4f" % (r_transfer * 100))
        tradeObj['profit'] = ("%.4f" % pf)
        tradeObj['orderCount'] = len(df)
        tradeObj['orderBuyCount'] = len(df_buy)
        tradeObj['orderSellCount'] = len(df_sell)
        tradeObj['cprice'] = price
        tradeObj['summary'] = Eshow

    return tradeObj


class DecimalEncoder(json.JSONEncoder):
    def default(self, o):
        if isinstance(o, Decimal):
            return float(o)
        super(DecimalEncoder, self).default(o)

if __name__ == "__main__":
    print("get str")
    # writeOrderStore()
    orders = getOrderFromStore('ETH-USDT')
    print(orders)

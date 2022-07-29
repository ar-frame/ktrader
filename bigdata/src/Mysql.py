#!/usr/bin/env python3.6
# -*- coding: utf-8 -*-

'trade moudule'
__author__ = 'assnr'
import pymysql
import cfg
import func

class Mysql:
    def __init__(self, tradeVariety):
        self.table_suffix = tradeVariety
        # print('start mysql conn')

    def getDb(self):
        # db = pymysql.connect("localhost","root","qweasd","trader")
        # print(111)

        cfg_mysql = cfg.getMysql()
        db = pymysql.connect(host = cfg_mysql.get('DB_HOST'),user = cfg_mysql.get('DB_USER'),password = cfg_mysql.get('DB_PASS'),database = cfg_mysql.get('DB'), port=cfg_mysql.get('DB_PORT'))
        return db

    def getOrders(self, rowCount = 100):
        results = []
        try:
            # 打开数据库连接
            db = self.getDb()
            # 使用cursor()方法获取操作游标
            cursor = db.cursor(cursor=pymysql.cursors.DictCursor)
            # SQL 插入语句
            sql = "SELECT * FROM `record_"+self.table_suffix+"` WHERE `complete` = '0' ORDER BY id DESC LIMIT %d" % (rowCount)

            try:
                # 执行SQL语句
                cursor.execute(sql)
                # 获取所有记录列表
                results = cursor.fetchall()

                # for row in results:
                #     print(row)

                    # 打印结果
                    # print ("fname=%s,lname=%s,age=%s,sex=%s,income=%s" % \
                    #         (fname, lname, age, sex, income ))
            except Exception as e:
                print ("Error: unable to fetch data", e)


            # 关闭数据库连接
            db.close()
            if len(results) > 0:
                results = results[::-1]
            return results

        except Exception as e:
            print ("Error: db error", e)
            return []



    def updatepcOrders(self):
        print("updatepcorders")
        #'buy' 0.7794332 4.186 2020-02-17 21:11:30 400000 0 0 0
        #print("catch insert data")
        try:
            # 打开数据库连接
            db = self.getDb()
            # 使用 cursor() 方法创建一个游标对象 cursor
            cursor = db.cursor()
            # SQL 插入语句
            sql = "UPDATE `record_"+self.table_suffix+"` set `complete` = '1' WHERE `complete` = '0'"
            try:
                # 执行sql语句
                cursor.execute(sql)
                # 执行sql语句
                db.commit()
            except Exception as e:
                # 发生错误时回滚
                db.rollback()
                print ("Error: db insert error", e)
            # 关闭数据库连接
            db.close()
        except Exception as e:
            print ("Error: db updatepcOrders error", e)

    def getPrice(self):
        results = []
        try:
            # 打开数据库连接
            db = self.getDb()
            # 使用cursor()方法获取操作游标
            cursor = db.cursor(cursor=pymysql.cursors.DictCursor)
            # SQL 插入语句
            sql = "SELECT * FROM `price_"+self.table_suffix+"` ORDER BY id DESC LIMIT %d" % (1)

            try:
                # 执行SQL语句
                cursor.execute(sql)
                # 获取所有记录列表
                results = cursor.fetchall()
            except Exception as e:
                print ("Error: unable to fetch data", e)

            # 关闭数据库连接
            db.close()
            if len(results) == 0:
                return None
            else:
                return dict(results[0])

        except Exception as e:
            print ("Error: db error", e)
            #return []
            return None

    def insertOrders(self, type, currency, price, timedate, code, complete, suc, profit):
        print("insertOrders", type, currency, price, timedate, code, complete, suc, profit)
        #'buy' 0.7794332 4.186 2020-02-17 21:11:30 400000 0 0 0
        #print("catch insert data")
        try:
            # 打开数据库连接
            db = self.getDb()
            # 使用 cursor() 方法创建一个游标对象 cursor
            cursor = db.cursor()
            # SQL 插入语句
            sql = "INSERT INTO `record_"+self.table_suffix+"` (type, \
                currency, price, timedate, code, \
                complete, suc, profit) \
                VALUES ('%s', %s,  %s,  '%s',  %s, %s, %s, %s)" % \
                (type, currency, price, timedate, code, complete, suc, profit)
            try:
                # 执行sql语句
                cursor.execute(sql)
                # 执行sql语句
                db.commit()
            except Exception as e:
                # 发生错误时回滚
                db.rollback()
                print ("Error: db insert error", e)
            # 关闭数据库连接
            db.close()
        except Exception as e:
            print ("Error: db 2 error", e)


    def updatePrice(self, type, price, timedate, pair):
        nowPrice = self.getPrice()
        price = float(price)
        print("upprice",nowPrice, price)

        if nowPrice is not None:
            if float(nowPrice.get("price")) == price:
                return None

        try:
            # 打开数据库连接
            db = self.getDb()
            # 使用 cursor() 方法创建一个游标对象 cursor
            cursor = db.cursor()
            # SQL 插入语句
            sql = "INSERT INTO `price_"+self.table_suffix+"` (type, \
                price, timedate, pair) \
                VALUES ('%s', %f,  '%s',  '%s')" % \
                (type, price, timedate, pair)
            try:
                # 执行sql语句
                cursor.execute(sql)
                # 执行sql语句
                db.commit()
            except Exception as e:
                # 发生错误时回滚
                db.rollback()
                print ("Error: db insert error", e)
            # 关闭数据库连接
            db.close()
        except Exception as e:
            print ("Error: db error", e)


if __name__ == "__main__":
    db_mysql = Mysql('BTC-USDT')
#    db_mysql.insertOrders('sell' ,2.25 ,268.5 ,20190616003657 ,205011 ,0 ,0 ,0)
    #resdata = db_mysql.getOrders(rowCount=3000)
    #exit()
    #resobj = func.getTradeObjByOrders(resdata=resdata, price=11440.20)
    #print(resobj)

    #price = db_mysql.getPrice()

    db_mysql.updatePrice(type = "sell", price = 12.16, timedate = "2019-06-10 11:11:10", pair = "ETH-USDT")
    exit()
    #VALUES ('%s', %f,  %f,  '%s',  %d, %d, %d, %f)" % \
    db_mysql.insertOrders(type='sell', currency=10.01, price=260.4, timedate='2019-06-10 12:12:12', code=1110, complete=0, suc=0, profit=0)
    print("start ok")



# mongodb数据库操作
from pymongo import MongoClient
import time

class MongoDB:
    # 连接
    def __init__(self, db_name, db_collection_name, dbHost = '127.0.0.1', dbUser = '', dbPass = '', dbPort = 27017):
        '''
        数据库连接
        '''
        self.db_name = db_name
        self.db_collection_name = db_collection_name
        self.dbHost = dbHost
        self.dbUser = dbUser
        self.dbPass = dbPass
        self.dbPort = dbPort

        self.connect(db_name, db_collection_name, dbHost, dbUser, dbPass, dbPort)

    def connect(self, db_name, db_collection_name, dbHost = '127.0.0.1', dbUser = '',dbPass = '', dbPort = 27017):
        client = MongoClient(dbHost, dbPort, serverSelectionTimeoutMS = 100, connectTimeoutMS = 20000)
        try:
            #client.admin.command('ismaster')
            info = client.server_info()
        except Exception as e:
            print('db not in service')
            print(e)
            return False

        if dbUser is not None:
            if (dbPass == "") == False:
                client.admin.authenticate(dbUser, dbPass)
        
        self.client = client
        db = client[db_name]
        db_connection = db[db_collection_name]
        self.db = db
        self.db_connection = db_connection

        return True

    def reConnectDb(self):
        print('start reconnect db...')
        while self.connect(self.db_name, self.db_collection_name, self.dbHost, self.dbUser, self.dbPass) == False:
            time.sleep(2)
            self.reConnectDb()

        print('reconnected')

    def isAvailable(self):
        try:
            info = self.client.server_info()
            #print(info)
            #exit()
            # self.client.admin.command('ismaster')
            return True
        except Exception as e:
            print('db service unavailable')
            print(e)
            return False

    def set_current_collections(self, collection_name):
        if self.isAvailable() == False:
            self.reConnectDb()
        self.db_connection = self.db[collection_name]
        return self
    
    def get_all_collections(self):
        if self.isAvailable() == False:
            self.reConnectDb()
        return self.db.list_collection_names()

    # 删除所有数据
    def clear_collections(self):
        for i in self.db_connection.find():
            self.db_connection.delete_one({"_id": i['_id']})
        return self

    # insert
    def insert(self, data):
        if self.isAvailable() == False:
            self.reConnectDb()

        if isinstance(data, dict):
            return self.db_connection.insert_one(data)
        elif len(data) > 0:
            return self.db_connection.insert_many(data)
        
    # 查找一行
    def query_row(self, con):
        if self.isAvailable() == False:
            self.reConnectDb()
        return self.db_connection.find_one(con)

    # 查询所有
    def query_all(self, con = {}):
        if self.isAvailable() == False:
            self.reConnectDb()
        return self.db_connection.find(con)

    #修改记录
    def update(self, con = {}, data = {}):
        if self.isAvailable() == False:
            self.reConnectDb()
        return self.db_connection.update_many(con, {"$set":data})

    #修改记录无则插入
    def update_insert(self, con = {}, data = {}):
        if self.isAvailable() == False:
            self.reConnectDb()
        if self.count(con) > 0:
            return self.db_connection.update_many(con, {"$set":data})
        else:
            self.insert(data)

    #删除一个collection中的所有数据
    def remove(self):
        return self.clear_collections()

    # 删除记录
    def delete(self, con):
        if self.isAvailable() == False:
            self.reConnectDb()
        return self.db_connection.delete_many(con)

    # 行数
    def count(self, con):
        if self.isAvailable() == False:
            self.reConnectDb()
        return self.db_connection.count_documents(con)

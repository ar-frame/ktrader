# mongodb数据库操作
from pymongo import MongoClient
db_connection = None
db = None

class MongoDB:
    # 连接
    def __init__(self, db_name, db_collection_name, dbHost = '120.24.7.188', dbUser = 'mongoroot', dbPass = 'cdcmogo2019Root'):
        '''
        数据库连接
        '''
        self.db_name = db_name
        self.db_collection_name = db_collection_name
        self.dbHost = dbHost
        self.dbUser = dbUser
        self.dbPass = dbPass

       
        self.connect(db_name, db_collection_name, dbHost,dbUser,dbPass)

    def connect(self, db_name, db_collection_name, dbHost = '120.24.7.188', dbUser = 'mongoroot', dbPass = 'cdcmogo2019Root'):
        client = MongoClient(dbHost, 27017)
        try:
            client.admin.command('ismaster')
        except Exception as e:
            print('db not service')
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
            self.reConnectDb()

        print('reconnected')

    def isAvailable(self):
        try:
            self.client.admin.command('ismaster')
            return True
        except Exception as e:
            print('db service unavailable')
            print(e)
            return False

    def set_current_collections(self, collection_name):
        self.db_connection = self.db[collection_name]
    
    def get_all_collections(self):
        if self.isAvailable() == False:
            self.reConnectDb()
        return self.db.list_collection_names()

    # 删除所有数据
    def clear_collections(self):
        for i in self.db_connection.find():
            self.db_connection.delete_one({"_id": i['_id']})
    # insert
    def insert(self, data):
        if self.isAvailable() == False:
            self.reConnectDb()

        if isinstance(data, dict):
            return self.db_connection.insert(data)
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
        if self.isAvailable() == False:
            self.reConnectDb()
        return self.db_connection.remove()

    # 删除记录
    def delete(self, con):
        if self.isAvailable() == False:
            self.reConnectDb()
        return self.db_connection.delete_one(con)

    # 行数
    def count(self, con):
        if self.isAvailable() == False:
            self.reConnectDb()
        return self.db_connection.count(con)

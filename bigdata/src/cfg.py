import configparser
import os

def getCfg():
    #用os模块来读取
    curpath = os.path.dirname(os.path.realpath(__file__))
    cfgpath = os.path.join(curpath, "conf/conf.ini")
    config = configparser.ConfigParser()
    config.read(cfgpath, encoding = 'utf-8')
    return config

def getMongo(tradeVariety = None):
    cfg = getCfg()
    if tradeVariety is None:
        mongo = cfg.get('set', 'mongo')
    else:
        if tradeVariety == 'ETH-USDT':
            mongo = 'default'
        elif tradeVariety == "EOS-USDT":
            mongo = 'eos'
        elif tradeVariety == "BTC-USDT":
            mongo = 'btc'
        else:
            mongo = tradeVariety.lower()

    # cpair = tradeVariety[0:-5]

    DB = cfg.get('mongo_' + mongo, 'DB')
    DB_PASS = cfg.get('mongo_' + mongo, 'DB_PASS')
    DB_HOST = cfg.get('mongo_' + mongo, 'DB_HOST')
    DB_USER = cfg.get('mongo_' + mongo, 'DB_USER')

    # DB = 'bigdata-' + cpair.lower()
    # DB_PASS = ''
    # DB_HOST = '127.0.0.1'
    # DB_USER = ''

    return {"DB": DB, "DB_PASS": DB_PASS, "DB_USER": DB_USER, "DB_HOST": DB_HOST}

def getMysql():
    cfg = getCfg()
    DB = cfg.get("mysql", 'DB')
    DB_PASS = cfg.get('mysql', 'DB_PASS')
    DB_HOST = cfg.get('mysql', 'DB_HOST')
    DB_USER = cfg.get('mysql', 'DB_USER')
    DB_PORT = int(cfg.get('mysql', 'DB_PORT'))
    print(DB_PORT)
    return {"DB": DB, "DB_PASS": DB_PASS, "DB_USER": DB_USER, "DB_HOST": DB_HOST, "DB_PORT":DB_PORT}

if __name__ == "__main__":

    mongo = getMongo()
    print(mongo)

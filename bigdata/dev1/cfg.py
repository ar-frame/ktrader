import configparser
import os

def getCfg():
    #用os模块来读取
    curpath = os.path.dirname(os.path.realpath(__file__))
    cfgpath = os.path.join(curpath, "conf/conf.ini")
    config = configparser.ConfigParser()
    config.read(cfgpath)
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


    
    DB = cfg.get('mongo_' + mongo, 'DB')
    DB_PASS = cfg.get('mongo_' + mongo, 'DB_PASS')
    DB_HOST = cfg.get('mongo_' + mongo, 'DB_HOST')
    DB_USER = cfg.get('mongo_' + mongo, 'DB_USER')
    return {"DB": DB, "DB_PASS": DB_PASS, "DB_USER": DB_USER, "DB_HOST": DB_HOST}


if __name__ == "__main__":
   
    mongo = getMongo()
    print(mongo)
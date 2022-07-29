import time
import datetime

def writeLog(filename, content):
    with open(filename, 'a') as f:
        nowTime=datetime.datetime.now().strftime('%Y-%m-%d %H:%M:%S')
        f.write("time:%s,msg:%s" % (nowTime, content) + "\n")
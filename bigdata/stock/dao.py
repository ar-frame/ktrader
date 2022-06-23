import pymongo
import os
import sys

if (len(sys.argv) < 2) :
    print('stock code not set')
    exit()

#输入股票代码
daima = sys.argv[1]
if (daima[0]== "6") :
    daima = "SH" + daima
else:
    daima = "SZ" + daima

def listDir(rootDir):
    global daima
    osdir = []
    for filename in os.listdir(rootDir):
        pathname = os.path.join(rootDir, filename)
        if os.path.isdir(pathname):

            dataFile = os.path.join(pathname, daima + ".txt")
            if os.path.isfile(dataFile):

                osdir.append(filename)
    osdir.sort()
    return osdir

def getFileData(tradeFile, shijian):
    # shijian=shijian[0:4]+x1+x2+x3+x4
    # dz = zdz+"\\"+shijian+"\\"+daima+".txt"
    dataInsert = []
    if os.access(tradeFile, os.F_OK):
        f = open(tradeFile, 'r')   #设置文件对象
        line = f.readline()
        

        while line:             #直到读取完文件
              #读取一行文件，包括换行符
            line = line[:-1]     #去掉换行符，也可以不去

            lineArr = line.split()
            if (len(lineArr) == 3):
               

                line1=lineArr[0]
                line1=line1.strip()

                if line1.isdigit() == False:
                    print("line1 is not num", line1)
                    line = f.readline()
                    continue

                if (line1[0] != "1"):
                    line1="0"+line1
                
                line1= shijian + line1
                line2=lineArr[1]
                line2=line2.strip()


                if line2.isdigit() == False:
                    print("line2 is not num", line2)
                    line = f.readline()
                    continue

                # print(line2)
                line2=float(line2) / 100
                
                line3=lineArr[2]
                line3=line3.strip()

                if line3.isdigit() == False:
                    continue

                if("-" in line3):
                    line3=line3[1:10]
                    line4="sell"
                else:
                    line4="buy"

                dangtian= {
                    'timedate': line1,
                    'price': line2,
                    'amount': line3,
                    'type': line4
                }

                dataInsert.append(dangtian)
                # print(line1,line2,line3,line4)
            line = f.readline()
        f.close()

    return dataInsert
    

client = pymongo.MongoClient(host='localhost', port = 27017)
#输入地址，确保要更新的数据连续且不和DB已有数据重复
dataDir = "E:\\BaiduNetdiskDownload\\逐笔成交明细(2018)"

tradeDirs = listDir(dataDir)
# tradeDirs = sorted(tradeDirs)

if len(tradeDirs) > 0:
    client.drop_database(daima)
    for tradeDir in tradeDirs:
        # print(tradeDir)
        dataOneFileDir = os.path.join(dataDir, tradeDir)
        dataFile = os.path.join(dataOneFileDir, daima + ".txt")
        if os.path.isfile(dataFile):
           
            tradeDayData = getFileData(dataFile, tradeDir)
            # print(tradeDayData)
            # print(len(tradeDayData), tradeDir)
            # exit()


            if len(tradeDayData) > 0:
                db = client[daima]
                collection = db[tradeDir]
                collection.remove()
                result = collection.insert_many(tradeDayData)
               
                print("导入成功：%s, %d" % (tradeDir, len(tradeDayData)))
               
print("执行完成, 数据源：%d" % len(tradeDirs))

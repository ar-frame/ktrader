import time
def transTimeToTimedate(tstime):
    f2 = '%Y%m%d%H%M%S'
    tm_s_stu = time.gmtime(tstime)
    return time.strftime(f2, tm_s_stu)

def transTimeToTimedateF1(tstime):
    f = '%Y-%m-%d %H:%M:%S'
    tm_s_stu = time.gmtime(tstime)
    return time.strftime(f, tm_s_stu)

def transF1ToDay(f1time):
    tf2 = transF1ToTimedateF2(f1time)
    return tf2[0:8]

def transTimedateToTime(timedate):
    f2 = '%Y%m%d%H%M%S'
    timedate_stuct = time.strptime(str(timedate), f2)
    tm_s = time.mktime(timedate_stuct)
    return tm_s

def transDateF1ToTime(timedate):
    f1 = '%Y-%m-%d %H:%M:%S'
    timedate_stuct = time.strptime(str(timedate), f1)
    tm_s = time.mktime(timedate_stuct)
    return tm_s

def transTimedateToDate(timedate):
    tm_s = transTimedateToTime(timedate) + 8 * 3600
    return transTimeToTimedateF1(tm_s)

def getTimeSepMinutes(datef1_e, datef1_s):
    ms = (transDateF1ToTime(datef1_e) - transDateF1ToTime(datef1_s)) / 60
    return int(ms)


def transF1ToTimedateF2(dateFormatF1):
    f1 = '%Y-%m-%d %H:%M:%S'
    f2 = '%Y%m%d%H%M%S'
     
    timedate_stuct = time.strptime(str(dateFormatF1), f1)
    tm_s = time.mktime(timedate_stuct) + 8 * 3600

    tm_s_stu = time.gmtime(tm_s)
    return time.strftime(f2, tm_s_stu)

def printDataFrame(df):
    if len(df) > 0 :
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
        
        return ("\n trade records \n" + dumpstr)
    else:
        
        return "empty records"
        
       

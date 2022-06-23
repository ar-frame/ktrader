import os, time, sys, signal
pipe_name = os.path.dirname(os.path.realpath(__file__)) + '/log.sock'
pidFileName = os.path.dirname(os.path.realpath(__file__)) + '/Shipan.pid'

def getServerInfo():
    if not os.path.exists(pipe_name):
        os.mkfifo(pipe_name)  

    pipein = open(pipe_name, 'r')

    line = pipein.read()[:-1]
    
    if len(line) > 0:
        print(line)
    else:
        print('response none')
       

def sendSignal():
    with open(pidFileName, 'r') as f:
        pid = int(f.read())
        if pid > 0:
            os.kill(pid, signal.SIGUSR1)

cpid = os.fork()
if cpid > 0:
    getServerInfo()
else:
    sendSignal()

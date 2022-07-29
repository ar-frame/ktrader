import os, time, sys, signal, json
import websocket
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


def on_error(ws, error):
    print("on ws error %s" % error)
    

def on_close(ws):
    print("### ws closed ###")

def on_open(ws):
    print('on ws open')
    show_code = {"code": "show_pipetrade"}
    ws.send(json.dumps(show_code))
    ws.close()

def on_message(ws, message): 
    print("on ws msg", message)
    

def sendSocketSig():

    ws = websocket.WebSocketApp("ws://localhost:12315/",
                            on_message = on_message,
                            on_error = on_error,
                            on_close = on_close,
                            on_open=on_open)    
    ws.run_forever()
   



cpid = os.fork()
if cpid > 0:
    getServerInfo()
else:
    # sendSignal()
    # 改为socket 通知
    sendSocketSig()
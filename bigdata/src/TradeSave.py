import pickle
import numpy as np
import os

class TradeSave:
    def __init__(self):
        self.savePath = os.path.dirname(os.path.realpath(__file__)) + '/data/tradend/'
        pass

    def saveTradeData(self, data, key):
        keyf = self.savePath + key
        # 序列化
        with open(keyf, 'wb') as f:
            return pickle.dump(data, f)
       

    def getTradeData(self, key):     
        keyf = self.savePath + key
        if os.path.exists(keyf):
            # 序列化
            with open(keyf, 'rb') as f:
                return pickle.load(f)
        else:
            return None

if __name__ == "__main__":

    ts = TradeSave()
    oridata = np.zeros((200, 300))
    sf = ts.saveTradeData(oridata, 'nd2')

    og = ts.getTradeData('nd2')

    print(og)
from .ServerResponseException import ServerResponseException
from .Config import Config
from .Cipher import Cipher
import time
import requests
import json

class Fetch:
    config = None
    def __init__(self, initconfig):
        self.config = initconfig

    def t1(self):
        print('t1t1t1')

    def getResponse(self, ws):
        url = self.config.SERVER_ADDRESS
        data = {
            "ws": ws
        }

        try:
            response = requests.post(url, data = data)
        except Exception as e:
            if str(e).find("Failed to establish a new connection") > 0:
                print(e)
                time.sleep(20)
                print("reconnected ..")
                return self.getResponse(ws)
            else:
                raise(ServerResponseException("err connection:" + str(e)))

        if len(response.text) > 0:
            find_sep_index = response.text.find(self.config.SERVER_RESPONSE_TAG)
            if (find_sep_index >= 0) :
                retstring = response.text[find_sep_index + len(self.config.SERVER_RESPONSE_TAG):]
                retstring = Cipher.hexStr2Str(retstring)
                return retstring
            else:
                raise(ServerResponseException("err data:" + response.text))
        else:
            raise(ServerResponseException("return empty"))


    def sendRequest(self, api, workerName, params):
        dataMap = {}
        dataMap['type'] = "array"

        authSign = {}

        config = self.config

        authSign['AUTH_SERVER_OPKEY'] = config.AUTH_SERVER_OPKEY
        authSign['USER_AUTH_KEY'] = config.USER_AUTH_KEY
        authSign['USER_ACCESS_TOKEN'] = config.USER_ACCESS_TOKEN

        apimap = {}
        apimap['class'] = api
        apimap['method'] = workerName

        if params is not None and len(params) > 0:
            apimap['param'] = json.dumps(params)
        else:
            apimap['param'] = "[\"\"]"

        apimap['authSign'] = authSign
        apimap['CLIENT_SERVER'] = "GETCODER-PYTHON-SDK-20201104"

        dataMap['data'] = apimap

        sendJsonString = json.dumps(dataMap)

        ws = Cipher.str2HexStr(sendJsonString)

        return self.getResponse(ws)

    def getObject(self, api, workerName, params):
        retstring = self.sendRequest(api, workerName, params)
        data_dic = json.loads(retstring)
        if (data_dic['type'] == 'object'):
            return data_dic['data']
        else:
            raise(ServerResponseException("type check error, 'object' expected but "+ data_dic["type"] + " provided," + retstring))

    def getArray(self, api, workerName, params):
        retstring = self.sendRequest(api, workerName, params)
        data_dic = json.loads(retstring)
        if (data_dic['type'] == 'array'):
            return list(data_dic['data'])
        else:
            raise(ServerResponseException("type check error, 'array' expected but "+ data_dic["type"] + " provided," + retstring))

    def getString(self, api, workerName, params):
        retstring = self.sendRequest(api, workerName, params)
        data_dic = json.loads(retstring)
        if (data_dic['type'] == 'string'):
            return str(data_dic['data'])
        else:
            raise(ServerResponseException("type check error, 'str' expected but "+ data_dic["type"] + " provided," + retstring))

    def getInt(self, api, workerName, params):
        retstring = self.sendRequest(api, workerName, params)
        data_dic = json.loads(retstring)
        if (data_dic['type'] == 'int'):
            return int(data_dic['data'])
        else:
            raise(ServerResponseException("type check error, 'int' expected but "+ data_dic["type"] + " provided," + retstring))


    def getDouble(self, api, workerName, params):
        retstring = self.sendRequest(api, workerName, params)
        data_dic = json.loads(retstring)
        if (data_dic['type'] == 'float'):
            return float(data_dic['data'])
        else:
            raise(ServerResponseException("type check error, 'float' expected but "+ data_dic["type"] + " provided," + retstring))

    def getFloat(self, api, workerName, params):
        return self.getDouble(api, workerName, params)

    def getBool(self, api, workerName, params):
        retstring = self.sendRequest(api, workerName, params)
        data_dic = json.loads(retstring)
        if (data_dic['type'] == 'bool'):
            if str(data_dic['data']).lower() == 'true':
                return True
            else:
                return False
        else:
            raise(ServerResponseException("type check error, 'bool' expected but "+ data_dic["type"] + " provided," + retstring))
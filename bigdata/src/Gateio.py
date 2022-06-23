# -*- coding: utf-8 -*-
#author: か壞尐孩キ

from websocket import create_connection
import gzip
import time
import json
import hmac
import base64
import hashlib

def get_sign(secret_key, message):
	h = hmac.new(bytes(secret_key, 'utf-8'), bytes(message, 'utf-8'), hashlib.sha512)
	return str(base64.b64encode(h.digest()))

class GateWs:
	def __init__(self, url, apiKey, secretKey):
		self.__url = url
		self.__apiKey = apiKey
		self.__secretKey = secretKey

	def gateGet(self,id,method,params):
		if(params==None):
			params=[]
		ws = create_connection(self.__url)
		data= { 'id' : id, 'method' : method, 'params' : params}
		js=json.dumps(data)
		ws.send(js)
		return ws.recv()

	def gateRequest(self,id,method,params):
		ws = create_connection(self.__url)
		nonce = int(time.time() * 1000)
		signature = get_sign(self.__secretKey, str(nonce))
		data= { 'id' : id, 'method' : 'server.sign' , 'params' : [self.__apiKey, signature, nonce]}
		js=json.dumps(data)
		ws.send(js)
		if method == "server.sign":
			return ws.recv()
		else: 
			ws.recv()
			data= { 'id' : id, 'method' : method, 'params' : params}
			js=json.dumps(data)
			ws.send(js)
			return ws.recv()

		
####https://www.gateio.io/####
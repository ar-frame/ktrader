#!/usr/bin/python
# -*- coding: utf-8 -*-
import requests

import http.client
import urllib
import json
import hashlib
import hmac


def getSign(params, secretKey):
    bSecretKey = bytes(secretKey, encoding='utf8')

    sign = ''
    for key in params.keys():
        value = str(params[key])
        sign += key + '=' + value + '&'
    bSign = bytes(sign[:-1], encoding='utf8')

    mySign = hmac.new(bSecretKey, bSign, hashlib.sha512).hexdigest()
    return mySign


def httpGet(url, resource, params=''):
    # print('get:')
    # print(url)
    # conn = http.client.HTTPSConnection("localhost", 1080)
    # conn.set_tunnel(url)

    conn = http.client.HTTPSConnection(url, timeout=10)
    conn.request("GET", resource + '/' + params)
    response = conn.getresponse()
    data = response.read().decode('utf-8')
    # print(data)
    return json.loads(data)


def httpPostRequest(url, resource, params, apiKey, secretKey):
    headers = {
        "Content-type": "application/x-www-form-urlencoded",
        "KEY": apiKey,
        "SIGN": getSign(params, secretKey)
    }

    # data = '{"username":"jack","password":"123"}'
#     print(url+resource)
    rep = requests.post(url=url+resource, data=params, headers=headers)
    return rep.text


def httpPost(url, resource, params, apiKey, secretKey):
    headers = {
        "Content-type": "application/x-www-form-urlencoded",
        "KEY": apiKey,
        "SIGN": getSign(params, secretKey)
    }
    # print(url)

    # conn = http.client.HTTPSConnection("localhost", 1080)
    # conn.set_tunnel(url)

    conn = http.client.HTTPSConnection(url, timeout=10)

    tempParams = urllib.parse.urlencode(params) if params else ''
    # print(tempParams)
    conn.request("POST", resource, tempParams, headers)

    response = conn.getresponse()
    data = response.read().decode('utf-8')
    params.clear()
    conn.close()
    return data


def httpPostBackJson(url, resource, params, apiKey, secretKey):
    headers = {
        "Content-type": "application/x-www-form-urlencoded",
        "KEY": apiKey,
        "SIGN": getSign(params, secretKey)
    }

    # conn = http.client.HTTPSConnection("localhost", 1080)
    # conn.set_tunnel(url)
    conn = http.client.HTTPSConnection(url, timeout=10)

    tempParams = urllib.parse.urlencode(params) if params else ''
    # print(tempParams)

    conn.request("POST", resource, tempParams, headers)
    response = conn.getresponse()
    data = response.read().decode('utf-8')
    params.clear()
    conn.close()
    return json.loads(data)

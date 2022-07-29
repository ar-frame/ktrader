from websocket import create_connection
ws = create_connection("wss://fx-ws-testnet.gateio.io/v4/ws")
ws.send('{"time" : 123456, "channel" : "futures.order_book", "event": "subscribe", "payload" : ["BTC_USD", "20", "0"]}')
print(ws.recv())
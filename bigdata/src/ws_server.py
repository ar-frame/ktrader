from websocket_server import WebsocketServer
import json
# Called for every client connecting (after handshake)
def new_client(client, server):
    print("New client connected and was given id %d" % client['id'])
    # server.send_message_to_all()
    response = {"code": "welcome"}
    server.send_message(client, json.dumps(response))

# Called for every client disconnecting
def client_left(client, server):
	print("Client(%d) disconnected" % client['id'], client)


# Called when a client sends a message
def message_received(client, server, message):
    try:
        jsonobj = json.loads(message)
        if jsonobj.get('code') is None:
            server.send_message(client, "code error")
        else:
            code = jsonobj.get('code')
            response = {"code": code, "type": "response", "msg": ""}
            if code == "get_list":
                response["data"] = [{"a":1}, {"a":2}]
            elif code == "ping":
                response['msg'] = "pong"
            elif code == "close":
                pass
            responseStr = json.dumps(response)
            server.send_message(client, responseStr)

    except Exception as e:
        server.send_message(client, "msg error:" + message)
        print(e)
    # if len(message) > 200:
    #     message = message[:200]+'..'
    print("Client(%d) said: %s" % (client['id'], message))

if __name__ == "__main__":
    PORT = 9001
    server = WebsocketServer(PORT, host="0.0.0.0")
    server.set_fn_new_client(new_client)
    server.set_fn_client_left(client_left)
    server.set_fn_message_received(message_received)
    server.run_forever()
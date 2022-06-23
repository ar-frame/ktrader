from coop_fetch.ServerResponseException import ServerResponseException
from coop_fetch.Config import Config
from coop_fetch.Fetch import Fetch
from coop_fetch.Cipher import Cipher


config = Config("http://192.168.101.177:19008", "AABBCCKTRADER2022")
fetch = Fetch(config)

try:
    tr = fetch.getString('service.ctl.bestplan.data', 'testClientRecv', ['inini..'])
    print(type(tr), tr)

    pushobj = fetch.getObject('service.ctl.bestplan.data', 'pushPaintRecord', ['btc-usdt', '2022061120220612', "python3 paint.py start test", 'test ok11111111111111111111114412415aa'])
    print(type(pushobj), pushobj)

except Exception as e:
    print(e)

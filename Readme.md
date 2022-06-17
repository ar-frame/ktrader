# 端口映射
```
19001 sshd
19002 mysqld
19003 运营网站
19004 trader web client
19005 tchecker
19006 tchecker_admin
19007 tchecker_admin service
19008 bestplan client service
```
# web socket pair bind port
```
12315 => ETH-USDT
12316 => EOS-USDT
12317 => BTC-USDT
```
# docker create command centos

## debian 
` docker run -itd --privileged=true  -v /var/yp/trader:/var/yp/trader --name ader2.2 -p 19001:22 -p 19002:19002 -p 19003:19003 -p 19004:19004 -p 19005:19005 -p 19006:19006 -p 19007:19007 -p 19008:19008 -p 19009:19009 -p 12315:12315 -p 12316:12316 -p 12317:12317 -p 12318:12318 -p 12319:12319 debian_ssh /sbin/init `

## centos --volume dbus connect problem 
` docker run -itd --privileged=true  -v /var/yp/trader:/var/yp/trader --volume /sys/fs/cgroup:/sys/fs/cgroup:ro --name ader2.2 -p 19001:22 -p 19002:19002 -p 19003:19003 -p 19004:19004 -p 19005:19005 -p 19006:19006 -p 19007:19007 -p 19008:19008 -p 19009:19009 -p 12315:12315 -p 12316:12316 -p 12317:12317 -p 12318:12318 -p 12319:12319 debian_ssh /sbin/init `

# ws端口
* 开启
/var/yp/source/tchecker/checker/start.sh start

* 关闭 
/var/yp/source/tchecker/checker/start.sh stop 

# 数据服务

## 开启
```
nohup python3 /var/yp/source/bigdata/gateio/LiveWebSocket.py eth > /dev/null &
nohup python3 /var/yp/source/bigdata/gateio/LiveWebSocket.py eos > /dev/null &
nohup python3 /var/yp/source/bigdata/gateio/LiveWebSocket.py btc > /dev/null &
```
## 关闭


# 系统导航
后台 http://192.168.101.177:19006/login/login  adminarcz   123456

```
API_SERVICE_ADDRESS = http://192.168.101.177:19008
API_SERVICE_KEY = AABBCCKTRADER2022
```

# 回测
python3 Paint.py 100 BTC-USDT '2022-06-16 21:00:00' now 10


# 代理
./create_registercode.sh 生成代理激活码

# 客户端
## trader center H5 端
启动 npm start
编译 npm run build

## trader client 安卓端 TraderClientAndroid
android-studio  Build>generate signed apk    release版本

签名文件 tradestrategy.jks

key pass / key store pass:   123456
key alias : test

---
![测试图片](docs/img/p1.png)
---
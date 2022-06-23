# 【Ktrader 开源量化系统 v2.1】

您可以在遵循MIT协议下自由修改和发布此软件。


开源初衷：
这是之前团队在做外包的同时完善的内部产品。
上上策，一款依托大数据的量化交易系统。经过两年实战完善，系统已经包含策略模块，实盘模块，后台系统，网站端，安卓客户端模块。
之前设计的初衷只是个人交易辅助，外包的盈余资金又多做了一些开发，不过最终由于各种原因运营不了了之。之后此基础上接了几个量化软件的外包。
用过一些开源量化软件，有平台的，有策略版本的。各有各的好处，不过最大的问题就是不成体系，要不是数据问题，语言通信问题，整合问题，二开问题，
始终绕不过单机玩玩无法形成一套完善成品。
而上上策将解决这个问题，上上策开源后命名为“KTrader”。
Ktrader 将包括Python，Java，PHP, nodejs , H5 , react，安卓，linux，mongodb，mysql 等技术。
一套体系全部用一个docker 镜像打包集成。
KTrader核心集成了数字货币交易，改改前端，策略改变以下，买卖接口一换可以做任何期货交易对品种的回测实盘。

# 【1.准备篇】

操作系统: Linux 5.10.0-13 debian 11 64位
独立IP: 本教程所使用系统为本地搭建IP为 192.168.101.177
docker: Docker version 20.10.17, build 100c701

推荐 debian 安装docker 命令:

```
sudo apt-get update
sudo apt-get install \
    ca-certificates \
    curl \
    gnupg \
    lsb-release
    
curl -fsSL https://download.docker.com/linux/debian/gpg | sudo gpg --dearmor -o /usr/share/keyrings/docker-archive-keyring.gpg

echo \
  "deb [arch=$(dpkg --print-architecture) signed-by=/usr/share/keyrings/docker-archive-keyring.gpg] https://download.docker.com/linux/debian \
  $(lsb_release -cs) stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null

sudo apt-get update
sudo apt-get install docker-ce docker-ce-cli containerd.io

```


# 【2.运维篇】

## 1 导入镜像

### 下载镜像
ktrader2.1.tar.gz 下载地址

链接：https://pan.baidu.com/s/1mxQ_seHE5caIk_1DgxLbmQ?pwd=3x2r 


### 导入命令
gunzip -c ktrader2.1.tar.gz | docker import - ktrader2.1_debian_img

## 2 创建容器


### 1 debian 推荐
` docker run -itd --privileged=true  -v /var/yp/trader:/var/yp/trader --name ktrader2.1 -p 19001:22 -p 19002:19002 -p 19003:19003 -p 19004:19004 -p 19005:19005 -p 19006:19006 -p 19007:19007 -p 19008:19008 -p 19009:19009 -p 12315:12315 -p 12316:12316 -p 12317:12317 -p 12318:12318 -p 12319:12319 ktrader2.1_debian_img /sbin/init `

### 2 centos --volume dbus connect problem 
` docker run -itd --privileged=true  -v /var/yp/trader:/var/yp/trader --volume /sys/fs/cgroup:/sys/fs/cgroup:ro --name ktrader2.1 -p 19001:22 -p 19002:19002 -p 19003:19003 -p 19004:19004 -p 19005:19005 -p 19006:19006 -p 19007:19007 -p 19008:19008 -p 19009:19009 -p 12315:12315 -p 12316:12316 -p 12317:12317 -p 12318:12318 -p 12319:12319 ktrader2.1_debian_img /sbin/init `

## 3 恢复数据

### 数据下载地址
链接：https://pan.baidu.com/s/1jibyoaeAVHJxexhB_0qG5A?pwd=hcii 

trader.tar.gz 主要是mysql, mongodb单独数据
sftp 上传至 /var/yp/trader

## 4 替换ip

目前服务器测试ip 192.168.101.177 
/var/yp/source需要全部替换成 您的ip

参考替换命令

```
sed -i "s/192.168.101.177/你的ip/g" `grep 192.168.101.177 -rl /var/yp/source`

```

## 服务(app调用)
### 启动ws

```
/var/yp/source/tchecker/checker/start.sh stat
```
### 关闭ws

```
/var/yp/source/tchecker/checker/start.sh stop
```

## 数据(爬虫)数据来源gateio
开启
```
nohup python3 /var/yp/source/bigdata/src/LiveWebSocket.py eth > /dev/null &
nohup python3 /var/yp/source/bigdata/src/LiveWebSocket.py eos > /dev/null &
nohup python3 /var/yp/source/bigdata/src/LiveWebSocket.py btc > /dev/null &
```

关闭

`ps aux|grep LiveWeb|awk '{print $2}'|xargs kill -9`


# 【3.配置篇】

## 端口映射
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
## web socket pair bind port
```
12315 => ETH-USDT
12316 => EOS-USDT
12317 => BTC-USDT
```
## 磁盘绑定

/var/yp/trader > /var/yp/trader
主要用于存放 mysql, mongodb数据便于导出维护

# 【4.说明篇】

## 系统导航
### 后台 
http://192.168.101.177:19006/login/login  adminarcz  123456

### 产品前台 
http://192.168.101.177:19003

### web 客户端
http://192.168.101.177:19004/home

### *API_SERVICE_ADDRESS*
http://192.168.101.177:19008

### *API_SERVICE_KEY*
AABBCCKTRADER2022


### ssh
host: 192.168.101.177
port: 19001
user: root
password: 123456

### mysql 
root: 123456

### mongodb
端口27017 无auth

### 数据目录
/var/yp/trader
第一次导入需要先恢复数据 trader.tar.gz 
解压里面包含mysql, mongodb 目录上传到这个目录
给所属权限分别是mysql, mongodb

### 源码目录
/var/yp/source

# 【5.回测篇】

## 启动回测
python  | 脚本    | 网格单元金额 | 品种    | 开始日期             | now > 当前时间  | 10表示步进 为10分钟

` python3  /var/yp/source/bigdata/src/Paint.py 100           BTC-USDT '2022-06-16 21:00:00'  now               10   `

## 策略说明
KTrader 默认实现了一类似于RSI的网格系统，网格金额随着振幅加大逐渐增大，网格信号级别最大为8
增大级别简略说明
```
1 |
2 ||
3 ||||
4 |||||
5 ||||||||
6 |||||||||||||
7 ||||||||||||||||||||
8 |||||||||||||||||||||||||||||||||
```
信号越大，操作越靠谱



### 自定义策略

关键函数：
```
def getPoint(self, timeStart, timeEnd):
#核心只需要实现返回字典
# timeStart 步进开始时间
# timeEnd   步进结束时间
    #数据处理逻辑...
    return {"trade_opt": "buy|sell|no","trade_msg": "交易信息"}
```

# 【6.实盘篇】
系统集成了okex , gate.io 
配置及密钥修改:conf.ini
```
; 开启实盘 no | yex
SHIPAN_ENABLE = no

; 交易所 okex | gateio
TRADE_TYPE = okex

[gateio]
...
[okex]
...
```
实盘启动
python | 脚本 | 网格单元金额 | 品种
`python3 /var/yp/source/bigdata/src/Shipan.py 10 BTC-USDT`

策略和回测的地方保持一致即可

# 【7.运营篇】


# 客户端打包
## trader center H5 端
启动 npm start
编译 npm run build

## trader client 安卓端 TraderClientAndroid
android-studio  Build>generate signed apk    release版本

签名文件 tradestrategy.jks

key pass / key store pass:   123456
key alias : test

# 代理管理
./create_registercode.sh 生成代理激活码


# 【8.杂篇】
看需要吧，是否做一下视频操作教程

...


## dokcer 常用命令

### container
```
docker export c | gzip > ./c.tar.gz
gunzip -c *.tar.gz | docker import - name
```

### image
```
docker save
gunzip -c *.tar.gz | docker load

```

---
【MIT】
Copyright © 2022 dpbtrader, v: kozdpb 
有任何问题的小伙伴可以加V讨论 

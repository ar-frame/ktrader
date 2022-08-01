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


# 系统截图

![后台管理](https://gitee.com/ar-frame/ktrader/raw/master/docs/img/admin.png)

![后台管理2](https://gitee.com/ar-frame/ktrader/raw/master/docs/img/%E5%9B%9E%E6%B5%8B%E5%90%8E%E5%8F%B0.png)

![产品网站](https://gitee.com/ar-frame/ktrader/raw/master/docs/img/%E8%BF%90%E8%90%A5%E7%BD%91%E7%AB%99.png)

![回测](https://gitee.com/ar-frame/ktrader/raw/master/docs/img/huice.png)

## 系统架构图
![系统架构图](https://gitee.com/ar-frame/ktrader/raw/master/docs/img/tec_struct.png)


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
nohup python3 /var/yp/source/bigdata/src/LiveWebSocketGtNew.py eth > /dev/null &
nohup python3 /var/yp/source/bigdata/src/LiveWebSocketGtNew.py eos > /dev/null &
nohup python3 /var/yp/source/bigdata/src/LiveWebSocketGtNew.py btc > /dev/null &
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

### 交易策略
KTrader 默认实现了一类似于RSI的能级因子code，code在 10W ~ 50W之间波动，当超买或者超卖code会有显著差异

### 下单策略

核心是马丁，网格金额随着振幅加大逐渐增大，模拟盘网格信号级别最大为8，实盘最大加仓为 3倍单元金额

### 平仓策略

模拟盘无，实盘反向做单为2倍 单元金额，当盈利并且持仓超过指定金额，在下次减仓交易信号出现时平仓，记录交易日志

### 增大级别简略说明：
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

```
trade records 
index    type     currency price    timedate            code     complete suc      profit   pprice   ptimedate           pt      
0        buy      100.0    1102.00  2022-06-22 09:59:59 522710   0        1        4.626    1152.98  2022-06-24 09:49:57 0.04422 
1        buy      112.5    1088.29  2022-06-22 11:49:59 439010   0        1        6.687    1152.98  2022-06-24 09:49:57 0.05611 
2        sell     100.0    1102.40  2022-06-22 13:09:59 211507   0        2        -4.588   1152.98  2022-06-24 09:49:57 0.04387 
3        buy      100.0    1098.22  2022-06-22 13:49:59 475927   0        1        4.986    1152.98  2022-06-24 09:49:57 0.04749 
4        buy      112.5    1079.56  2022-06-22 14:19:59 480587   0        1        7.651    1152.98  2022-06-24 09:49:57 0.06368 
5        buy      131.25   1067.49  2022-06-22 15:09:59 387045   0        1        10.511   1152.98  2022-06-24 09:49:57 0.07415 
6        sell     100.0    1079.95  2022-06-22 16:29:57 244013   0        2        -6.762   1152.98  2022-06-24 09:49:57 0.06334 
7        buy      100.0    1075.44  2022-06-22 16:39:59 364584   0        1        7.210    1152.98  2022-06-24 09:49:57 0.06725 
8        sell     100.0    1091.70  2022-06-22 17:59:59 243382   0        2        -5.613   1152.98  2022-06-24 09:49:57 0.05315 
9        buy      100.0    1088.66  2022-06-22 18:39:59 399788   0        1        5.908    1152.98  2022-06-24 09:49:57 0.05579 
10       buy      112.5    1079.67  2022-06-22 21:19:59 472122   0        1        7.639    1152.98  2022-06-24 09:49:57 0.06358 
11       buy      131.25   1062.90  2022-06-23 00:09:59 522663   0        1        11.123   1152.98  2022-06-24 09:49:57 0.07813 
12       buy      165.625  1052.70  2022-06-23 04:49:59 320092   0        1        15.777   1152.98  2022-06-24 09:49:57 0.08697 
13       sell     100.0    1060.33  2022-06-23 06:09:57 236630   0        2        -8.738   1152.98  2022-06-24 09:49:57 0.08036 
14       buy      100.0    1055.21  2022-06-23 06:19:59 400762   0        1        9.265    1152.98  2022-06-24 09:49:57 0.08480 
15       sell     100.0    1060.66  2022-06-23 06:39:57 256350   0        2        -8.704   1152.98  2022-06-24 09:49:57 0.08007 
16       buy      100.0    1058.17  2022-06-23 07:19:55 443500   0        1        8.960    1152.98  2022-06-24 09:49:57 0.08223 
17       buy      112.5    1050.20  2022-06-23 07:49:58 542672   0        1        11.010   1152.98  2022-06-24 09:49:57 0.08914 
18       sell     100.0    1071.10  2022-06-23 08:39:56 230074   0        2        -7.644   1152.98  2022-06-24 09:49:57 0.07102 
19       sell     112.5    1077.83  2022-06-23 08:49:59 221830   0        2        -7.844   1152.98  2022-06-24 09:49:57 0.06518 
20       buy      100.0    1084.89  2022-06-23 09:59:59 350935   0        1        6.276    1152.98  2022-06-24 09:49:57 0.05906 
21       buy      112.5    1078.45  2022-06-23 11:39:59 492275   0        1        7.775    1152.98  2022-06-24 09:49:57 0.06464 
22       sell     100.0    1103.13  2022-06-23 15:09:59 220953   0        2        -4.519   1152.98  2022-06-24 09:49:57 0.04324 
23       buy      100.0    1097.58  2022-06-23 15:29:59 512371   0        1        5.047    1152.98  2022-06-24 09:49:57 0.04805 
24       sell     100.0    1111.91  2022-06-23 18:39:59 228357   0        2        -3.694   1152.98  2022-06-24 09:49:57 0.03562 
25       buy      100.0    1107.68  2022-06-23 19:09:59 548010   0        1        4.090    1152.98  2022-06-24 09:49:57 0.03929 
26       sell     100.0    1109.63  2022-06-23 19:29:58 238971   0        2        -3.907   1152.98  2022-06-24 09:49:57 0.03760 
27       buy      100.0    1107.55  2022-06-23 19:39:59 414124   0        1        4.102    1152.98  2022-06-24 09:49:57 0.03940 
28       buy      112.5    1096.04  2022-06-23 23:29:57 356328   0        1        5.844    1152.98  2022-06-24 09:49:57 0.04939 
29       buy      131.25   1088.60  2022-06-23 23:39:59 373948   0        1        7.762    1152.98  2022-06-24 09:49:57 0.05584 
30       sell     100.0    1090.51  2022-06-24 01:29:59 253742   0        2        -5.729   1152.98  2022-06-24 09:49:57 0.05418 
31       sell     112.5    1100.71  2022-06-24 02:49:59 226562   0        2        -5.342   1152.98  2022-06-24 09:49:57 0.04533 
32       buy      100.0    1132.13  2022-06-24 04:39:57 474019   0        1        1.842    1152.98  2022-06-24 09:49:57 0.01808 
33       sell     100.0    1137.91  2022-06-24 04:49:59 239046   0        2        -1.324   1152.98  2022-06-24 09:49:57 0.01307 
34       buy      100.0    1134.19  2022-06-24 05:09:59 536171   0        1        1.657    1152.98  2022-06-24 09:49:57 0.01630 
35       buy      112.5    1126.59  2022-06-24 05:49:52 440462   0        1        2.635    1152.98  2022-06-24 09:49:57 0.02289 
最大占用 1221.88
最小占用 0.00
转化率 6.87
总体盈利 83.97
总单数 36 , 多单 23, 空单 13
当前价格 1152.98
方向 做多:数量1.13，金额1221.88，成本价1078.83

code 382837 buy, expect for sell  opt: no , code: 382837

```


买入信号: 
```
opt: buy , code: 483977

.................................................................................................................................................................
................................................................................∧................................................................................
.............................................................................###.................................................................................
#........................................................................#######.................................................................................
#...........................................................................####.................................................................................
............................................................................####.................................................................................
.............................................................................###.∨...............................................................................
#.........................................................................######..∨..............................................................................
...............................................................................#.................................................................................
#............................................................................###.................................................................................
##........................................................######################...∨###.∧#.......................................................................
##......................................................................########.................................................................................
###.....................................................................########.......∨.........................................................................
#.........................................................................######..........∨......................................................................
########...........................................................#############...........∨#.∧#.................................................................
##...............................................................###############.............∨..........∧..................∧.∧#................................∧#
########..................................######################################................∨......∧.∨..................∨..∨####.............................
######....................................................######################.................∨###.∧.............∧.∧.∧##......................................
######...............................................###########################.....................∨....∨..........∨.∨............∨............................
#####...........................................################################...........................∨###....∧.................∨#....∧######............∧..
########................................########################################...............................∨.∧#....................∨.∧#.......∨##...∧###.∧...
###......................................................................#######................................∨....................................∨##....∨....
..........................................................................######........................................................∨.......................

```

卖出信号
```
  opt: sell , code: 243382

.................................................................................................................................................................
.............................................................................###.................................................................................
.............................................................................###.................................................................................
.............................................................................###..................................∧..............................................
###..............................................................###############.....................∧.............∨.............................................
###.............................................................################....................∧.......∧#............................∧......................
############..........................................##########################......................∨.......∨..∧..∨##...........∧...∧..∧............∧..........
###########.............................########################################.......................∨..∧#....∧......∨.........∧...∧.∨.........∧#.∧#...........
######...............................................###########################...............................∨.........∧......∧..∨#...∨......∧#..∨.....∧...∧...
###...................................................##########################........................∨#..............∨...∧###...........∨#..........∨#.∨#..∨##
##......................................................................########..........................................∨#.................∨#.............∨....
...............................................................................#.................................................................................
#.............................................................................##..................∧#.............................................................
...............................................................................#.................................................................................
............................................................................####...............∧##...............................................................
............................................................................####.............∧#..................................................................
..............................................................................##.................................................................................
#...........................................................................####...........∧.....................................................................
.............................................................................###.........∧..∨....................................................................
.............................................................................###........∧.∨......................................................................
#...........................................................................####..∧.∧.∧#.........................................................................
#......................................................................#########.∧.∨.∨...........................................................................
................................................................................#................................................................................
```

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
系统集成了binance , okex , gateio 
配置及密钥修改:conf.ini
```
; 开启实盘 no | yes
SHIPAN_ENABLE = yes

; 交易所 binance | okex | gateio 建议使用binance
TRADE_TYPE = binance

[gateio]
...
[okex]
...

[binance]
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

## 基于此文档的视频操作教程
## [1.KTrader简介](https://www.zhihu.com/zvideo/1525847400921378816)
## [2.如何回测](https://www.zhihu.com/zvideo/1526932656764186624)
## [3.自定义策略](https://www.zhihu.com/zvideo/1526935650145755136)
## [4.如何实盘](https://www.zhihu.com/zvideo/1526951247911673856)
## [5.代理激活码生成](https://www.zhihu.com/zvideo/1526952645588094976)
## [6.web版打包](https://www.zhihu.com/zvideo/1526954475802062848)
## [7.安卓版打包](https://www.zhihu.com/zvideo/1526956566222147585)
## [8.源码下载](https://www.zhihu.com/zvideo/1526959243780980736)

---
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

# 【更新日志】

## 2022/08/01 交易参数配置
conf.ini配置: 
```
[trade]
# 反向减仓unit倍数
SHIPAN_FXJC_INDEX = 2
# 最大交易unit倍数
SHIPAN_TRADE_MAX_UNIT_INDEX = 3

# 触发正向盈利平仓仓位
SHIPAN_PC_ZX_USDTAMOUNT_LINE = 30
# 触发反向盈利平仓仓位
SHIPAN_PC_FX_USDTAMOUNT_LINE = 200

# 每次加仓价格波动率
SHIPAN_CON_GRID_INC_LEVEL_POINT = 0.00618
# 每次减仓价格波动率
SHIPAN_CON_GRID_DEC_LEVEL_POINT = 0.00818
```

## 2022/07/29 交易日志
* 增加文件平仓日志 csv 格式
* 更新数据来源 LiveWebSocketGtNew.py
* 清除冗余代码

## 2022/07/21 增加币安交易
* 增加 binace margin trade

安装扩展: `pip install binance-connector`

conf.ini配置: 
```
; 交易所 binance | okex | gateio
TRADE_TYPE = binance

[binance]
apiKey = **************
secretKey = *******
httpProxies = ************

```


---
【MIT】
Copyright © 2022 dpbtrader, v: kozdpb

技术交流q群: `259956472`

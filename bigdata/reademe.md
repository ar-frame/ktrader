# 【Ktrader base核心交易程序使用】
本程序bigdata是ktrader核心交易程序，项目全部为Python编写，数据库采用mongodb 
无需客户端，web服务器等的安装，环境搭建容易，实盘支持linux及windows系统。

# 【1.安装】
## python3安装
推荐python3.9

### 【windows】

安装包下载地址： https://www.python.org/ftp/python/3.9.13/python-3.9.13-embed-amd64.zip


### 【Linux】
推荐 debian11 系统，安装参考命令 `apt install python`

## python支持库安装
扩展需要

binance-connector 
matplotlib        
numpy             
pandas             
pymongo            
PyMySQL           
python-dateutil    
requests           
websocket         
websocket-client   
            
### 参考一键安装命令
`python -m pip install -r requirements.txt`

## 数据库

### mongodb (必须)

#### windows
安装包下载地址https://fastdl.mongodb.org/windows/mongodb-windows-x86_64-4.4.15-signed.msi

#### linux

##### 1.官方安装文档
https://www.mongodb.com/docs/manual/tutorial/install-mongodb-on-debian/

##### 2.ktrader docker debian镜像包 (推荐)
里面有全部的运行环境
ktrader2.1.tar.gz 下载地址
链接：https://pan.baidu.com/s/1mxQ_seHE5caIk_1DgxLbmQ?pwd=3x2r 

导入命令
`gunzip -c ktrader2.1.tar.gz | docker import - ktrader2.1_debian_img`


### mysql （可选）
#### windows 不建议
使用mongodb即可

#### linux

##### 1.命令安装
```
wget https://dev.mysql.com/get/mysql-apt-config_0.8.22-1_all.deb
sudo apt install ./mysql-apt-config_0.8.22-1_all.deb
sudo apt update
sudo apt install mysql-server
```
##### 2.使用docker镜像包
参考上面mongodb


# 【2.配置】

配置文件 src/conf/conf.ini

```
[set]
; 开启实盘 no | yes
SHIPAN_ENABLE = no

; 交易所 binance | okex | gateio
TRADE_TYPE = binance

; DB_TYPE mongodb | mysql
SHIPAN_DB_TYPE = mongodb

mongo = default

[trade]
# 反向减仓unit倍数
SHIPAN_FXJC_INDEX = 2
# 最大交易unit倍数
SHIPAN_TRADE_MAX_UNIT_INDEX = 3
# 触发正向盈利平仓仓位
SHIPAN_PC_ZX_USDTAMOUNT_LINE = 30
# 触发反向盈利平仓仓位
SHIPAN_PC_FX_USDTAMOUNT_LINE = 200
# & 触发平仓盈利条件
SHIPAN_CON_PROFIT_USDT = 0.5
# 每次加仓价格波动率
SHIPAN_CON_GRID_INC_LEVEL_POINT = 0.00618
# 每次减仓价格波动率
SHIPAN_CON_GRID_DEC_LEVEL_POINT = 0.00818
```

# 【3.回测】

## 启动回测
python  | 脚本    | 网格单元金额 | 品种    | 开始日期             | now > 当前时间  | 10表示步进 为10分钟

` python  ./Paint.py 100           BTC-USDT '2022-06-16 21:00:00'  now               5   `


# 【4.实盘】
进入 src 目录

## 启动数据源
无论实盘，还是回测，首先需要运行数据源

python | 脚本 | 品种

如监控BTC-USDT

```python ./LiveWebSocketGtNew.py btc```

## 启动实盘
python | 脚本 | 网格单元金额 | 品种

`python ./Shipan.py 30 BTC-USDT`

策略和回测的地方保持一致即可


# 【5.内置策略说明】
不建议直接使用，造成的盈亏自负。

## 交易策略
KTrader 默认实现了一类似于RSI的能级因子code，code在 10W ~ 50W之间波动，当超买或者超卖code会有显著差异

## 下单策略
核心是马丁，网格金额随着振幅加大逐渐增大，模拟盘网格信号级别最大为8，实盘最大加仓为 3倍单元金额
## 平仓策略
模拟盘无，实盘反向做单为2倍 单元金额，当盈利并且持仓超过指定金额，在下次减仓交易信号出现时平仓，记录交易日志


## 自定义策略

Paint.py关键函数：
```
def getPoint(self, timeStart, timeEnd):
#核心只需要实现返回字典
# timeStart 步进开始时间
# timeEnd   步进结束时间
    #数据处理逻辑...
    return {"trade_opt": "buy|sell|no","trade_msg": "交易信息"}
```
---
【MIT】
* Copyright © 2022 dpbtrader, v: kozdpb
* ktrader学习交流q群: `259956472`


---
*申明：本项目仅为交流学习作用，切勿用作第三方商业使用，鉴于网络，参数，品种的各种不确定性，没有100%赚钱的量化软件，使用此软件造成的损失与我方无关，交易有风险，投资需谨慎。*



# 接口说明
## 1.验证用户
http://tchecker.coopcoder.com/Checker/authUser

### 参数
mac string mac地址 必须
lastRegisterCode string 最后一次使用的激活码 必须
uid string 客户端唯一码 必须
pm string 客户端型号 必须

返回 json {"err_msg":"","check_result":true,"can_use_dayoff":13,"service_call":"18502878090","service_info":"\u4eca\u665a\u68ad\u54c8\uff0c\u8ddf\u4e0a\u64cd\u4f5c","version_name":"\u6bcf\u5929\u90fd\u68ad\u4e00\u628aV5"}
err_msg ：错误信息
check_result : true 表示通过，false表示未通过
can_use_dayoff: 可使用天数
service_call: 服务商电话
service_info: 服务信息
version_name: 版本信息


## 2.第一次激活
http://tchecker.coopcoder.com/Checker/registerCodeUser

### 参数
mac string mac地址 必须
registerCode string 激活码 必须
uid string 客户端唯一码 必须
pm string 客户端型号 必须

返回 json

# 可供测试使用的激活码registerCode
OMVZGSEMRRXEAHWI
SIYAYMILSJDALYLV
JOBSPZEYKFHTNKON
AVIEWLALKTWEXGIL
KZKDSHFKJGJGXTLQ
#### 1.拉取代码
```shell
git clone https://gitee.com/zhangrui-git/swoole-im.git
cd swoole-im
```
#### 2.运行服务端
手动运行
```shell
composer install
php im server
```
docker运行
```dockerfile
FROM composer/composer as composer
FROM phpswoole/swoole:4.8-php7.4-alpine
LABEL authors="Zhang Rui"
COPY --from=composer /usr/bin/composer /usr/bin/composer
EXPOSE 8080/tcp
VOLUME /app
WORKDIR /app
ENTRYPOINT ["php", "im", "server"]
```
```shell
docker run -p 8080:8080 -v $project_dir:/app --name swoole-im swoole-im:0.0.1
```
#### 3.连接服务器
> 使用postman连接服务器 ws://127.0.0.1:8080

客户端A连接成功返回json
```json
{
  "serviceName": "system.UserLogin",
  "retStat": 0,
  "retMsg": "",
  "msg": {
    "ssid": "40713e48251bd9216a62ef655942107a"
  },
  "time": 1710420856
}
```
客户端B连接成功返回json
```json
{
  "msg": {
    "ssid": "c0f56feef9e72e39b840421f15708595"
  },
  "time": 1710420843,
  "serviceName": "system.UserLogin",
  "retStat": 0,
  "retMsg": ""
}
```
#### 4.发送消息
> 客户端A给客户端B发送文本消息

```json
{
  "ver": "0.0.1",
  "serviceName": "chat.SingleChatText",
  "msg": {
    "toSsid": "c0f56feef9e72e39b840421f15708595",
    "content": "hi"
  }
}
```
> 客户端A收到回复

```json
{
    "msg": {},
    "time": 1710421158,
    "serviceName": "chat.SingleChatText",
    "retStat": 0,
    "retMsg": "ok"
}
```
> 客户端B收到消息

```json
{
    "msg": {
        "formSsid": "40713e48251bd9216a62ef655942107a",
        "content": "hi"
    },
    "time": 1710420901,
    "serviceName": "chat.SingleChatText",
    "retStat": 0,
    "retMsg": ""
}
```
#### JMeter性能测试
|线程数|并发数|循环次数|初始内存占用|中间内存占用|
|:---:|:---:|:---:|:---:|:---:|
|2000|2000|100|26.16MB / 5.79GB|54.6MB / 5.79GB|

|Label|样本|平均值|中位数|90%|95%|99%|最小值|最大值|异常%|吞吐量|接收KB/sec|发送KB/sec|
|---|---|---|---|---|---|---|---|---|---|---|---|---|
|WebSocket Open Connection|2000|1|1|2|2|6|0|7|0.0|1001.00|179.86|149.56|
|WebSocket Single Read Sampler|202000|0|0|0|0|1|0|28|0.0|988.96|115.03|0.0|
|WebSocket Single Write Sampler|200000|0|0|0|0|1|0|15|0.0|988.96|0.0|124.58|
|WebSocket Close|2000|7|6|16|21|34|0|37|0.0|875.27|23.07|26.49|
|总体|406000|0|0|0|0|1|0|37|0.0|1987.63|117.04|125.10|
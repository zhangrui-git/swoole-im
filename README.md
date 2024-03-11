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
ONBUILD RUN install
FROM phpswoole/swoole:4.8-php7.4-alpine
LABEL authors="Zhang Rui"
COPY --from=composer /usr/bin/composer /usr/bin/composer
ADD . /app/
WORKDIR /app/
RUN composer install
EXPOSE 8080/tcp
ENTRYPOINT ["php", "im", "server"]
```
```shell
docker build . -t swoole-im
```
#### 3.连接服务器
> 使用postman连接服务器 ws://127.0.0.1:8080

客户端A连接成功返回json
```json
{
    "version": "0.0.1",
    "status": 200,
    "msg": "",
    "timestamp": 1638436708,
    "data": {
        "Server": {
            "Conn": {
                "ssid": "8367abf5ff6389cf4de8b0986aabe413"
            }
        }
    }
}
```
客户端B连接成功返回json
```json
{
    "version": "0.0.1",
    "status": 200,
    "msg": "",
    "timestamp": 1638436711,
    "data": {
        "Server": {
            "Conn": {
                "ssid": "15d93d4a2c1f37f6cee7cfcd65643b09"
            }
        }
    }
}
```
#### 4.发送消息
> 客户端A给客户端B发送文本消息

```json
{
    "type": "chat",
    "data": {
        "module": "text",
        "method": "sendTo",
        "params": {
            "ssid": "15d93d4a2c1f37f6cee7cfcd65643b09",
            "content": "hello world"
        }
    }
}
```
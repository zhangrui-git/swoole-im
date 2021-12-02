<?php

declare(strict_types=1);
/**
 * @author zhang rui<zhangruirui@zhangruirui.com>
 * @see https://github.com/zhangrui-git/im.git/
 */

namespace core;


use Psr\Log\LoggerInterface;
use response\server\ConnectSuccess;
use Swoole\Http\Request;
use Swoole\Table;
use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server;

class WebSocketServer
{
    public string $host;
    public int $port;
    public LoggerInterface $log;
    public Server $ws;
    public Table $fdTable;
    public Table $ssidTable;
    public Dispatch $dispatch;

    public function __construct(string $host, int $port)
    {
        $this->host = $host;
        $this->port = $port;
        // 初始化服务器
        $this->ws = new Server($host, $port);
        $this->ws->on('open', [$this, 'onOpen']);
        $this->ws->on('message', [$this, 'onMessage']);
        $this->ws->on('close', [$this, 'onClose']);
        // 初始化连接表
        $this->fdTable = new FdTable(1000);
        // 初始化会话表
        $this->ssidTable = new SsidTable(1000);
    }

    public function setLogger(LoggerInterface $logger): self
    {
        $this->log = $logger;
        return $this;
    }

    public function setDispatch(Dispatch $dispatch): self
    {
        $this->dispatch = $dispatch;
        return $this;
    }

    public function onOpen(Server $server, Request $request)
    {
        $fd = $request->fd;
        // 客户端连接时写入表
        $ssid = md5(microtime());
        $this->ssidTable->set($ssid, ['fd' => $fd]);
        $this->fdTable->set(strval($fd), ['ssid' => $ssid]);
        // 连接成功返回数据
        $r = new ConnectSuccess();
        $r->setSsid($ssid);
        $server->push($fd, strval($r));

        $this->log->debug('onOpen', ['request' => json_encode($request), 'fd' => $fd, 'ssid' => $ssid]);
    }

    public function onMessage(Server $server, Frame $frame)
    {
        $fd = $frame->fd;
        $msg = new Message();
        $msg->fd = $fd;
        $data = json_decode($frame->data, true);
        $msg->type = $data['type'];
        $msg->module = $data['data']['module'];
        $msg->method = $data['data']['method'];
        $msg->params = $data['data']['params'];
        $msg->ssid = $this->fdTable->get(strval($fd), 'ssid');

        $ret = $this->dispatch->exec($msg);
        if ($ret instanceof Response) {
            $server->push($frame->fd, strval($ret));
        }

        $this->log->debug('onMessage', ['frame' => json_encode($frame)]);
    }

    public function onClose(Server $server, int $fd)
    {
        $fdStr = strval($fd);
        // 连接断开从表中移除
        if ($this->fdTable->exists($fdStr)) {
            $ssid = $this->fdTable->get($fdStr, 'ssid');
            if ($ssid && $this->ssidTable->exists($ssid)) {
                $this->ssidTable->delete($ssid);
            }
            $this->fdTable->delete($fdStr);
        }

        $this->log->debug('onClose', ['fd' => $fd]);
    }

    public function start()
    {
        $this->log->info('server start', ['host' => $this->host, 'port' => $this->port]);
        $this->ws->start();
    }
}
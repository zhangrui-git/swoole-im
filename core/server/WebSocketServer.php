<?php

declare(strict_types=1);
/**
 * @author zhang rui<zhangruirui@zhangruirui.com>
 * @see https://github.com/zhangrui-git/im.git/
 */

namespace core\server;


use core\codec\DecoderInterface;
use core\codec\EncoderInterface;
use core\service\ServiceInterface;
use core\session\FdTable;
use core\session\Session;
use core\session\SsidTable;
use Exception;
use packages\ResponsePackageInterface;
use packages\WebSocketRequest;
use Psr\Log\LoggerInterface;
use response\server\ConnectSuccessMsg;
use Swoole\Http\Request;
use Swoole\Table;
use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server;

class WebSocketServer implements ServerInterface
{
    public string $host;
    public int $port;
    public LoggerInterface $log;
    public Server $ws;
    public Session $session;
    /** @var ServiceInterface[][] */
    protected array $services = [];
    protected EncoderInterface $encoder;
    protected DecoderInterface $decoder;

    public function __construct(string $host, int $port)
    {
        $this->host = $host;
        $this->port = $port;
    }

    protected function init()
    {
        // 初始化服务器
        $this->ws = new Server($this->host, $this->port);
        $this->ws->on('open', [$this, 'onOpen']);
        $this->ws->on('message', [$this, 'onMessage']);
        $this->ws->on('close', [$this, 'onClose']);
        // 初始化内存表
        $this->session = new Session();
    }

    public function setLogger(LoggerInterface $logger): self
    {
        $this->log = $logger;
        return $this;
    }

    /**
     * @throws Exception
     */
    public function addService(ServiceInterface $service): self
    {
        $s = $service->getService();
        $m = $service->getModule();
        if (empty($s) || empty($m)) {
            throw new Exception();
        }
        $this->services[$s][$m] = $service;
        return $this;
    }

    public function setDecoder(DecoderInterface $decoder): self
    {
        $this->decoder = $decoder;
        return $this;
    }

    public function getDecoder(): DecoderInterface
    {
        return $this->decoder;
    }

    public function setEncoder(EncoderInterface $encoder): self
    {
        $this->encoder = $encoder;
        return $this;
    }

    public function getEncoder(): EncoderInterface
    {
        return $this->encoder;
    }

    public function onOpen(Server $server, Request $request)
    {
        $fd = $request->fd;
        // 客户端连接时写入表
        $ssid = $this->session->newSession($fd);
        // 连接成功返回数据
        $rsp = new ConnectSuccessMsg();
        $rsp->setSsid($ssid);
        $server->push($fd, $this->encoder->encode($rsp->all()));

        $this->log->debug('onOpen', ['fd' => $fd, 'ssid' => $ssid]);
    }

    public function onMessage(Server $server, Frame $frame)
    {
        $fd = $frame->fd;
        if ($server->isEstablished($fd)) {
            $ssid = $this->session->getSsid($fd);
            if ($ssid) {
                try {
                    $data = $this->decoder->decode($frame->data);
                    $pkg = new WebSocketRequest($data);
                    $s = $pkg->getService();
                    $m = $pkg->getModule();
                    if (isset($this->services[$s][$m])) {
                        $service = $this->services[$s][$m];
                        $ret = $service->handle($fd, $pkg);
                        if ($ret instanceof ResponsePackageInterface) {
                            $server->push($frame->fd, $this->encoder->encode($ret->all()));
                        }
                    }
                } catch (Exception $e) {
                    $this->log->error($e->getMessage());
                }
            } else {
                $this->log->debug('ssid不存在', ['fd' => $fd]);
            }
        } else {
            $this->log->debug('websocket链接无效', ['fd' => $fd]);
        }

        $this->log->debug(
            'onMessage',
            [
                'fd' => $fd,
                'mtPid' => $server->getMasterPid(),
                'mnPid' => $server->getManagerPid(),
                'wId' => $server->getWorkerId(),
                'wPid' => $server->getWorkerPid(),
            ]
        );
    }

    public function onClose(Server $server, int $fd)
    {
        // 连接断开从表中移除
        $this->session->delSession($fd);
        $this->log->debug('onClose', ['fd' => $fd]);
    }

    public function start()
    {
        $this->init();
        $this->log->info('server start', ['host' => $this->host, 'port' => $this->port]);
        $this->ws->start();
    }
}
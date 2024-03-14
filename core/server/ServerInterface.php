<?php

namespace core\server;

use core\codec\DecoderInterface;
use core\codec\EncoderInterface;
use core\service\ServiceInterface;
use Psr\Log\LoggerInterface;
use Swoole\Http\Request;
use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server;

interface ServerInterface
{
    public function setLogger(LoggerInterface $logger);
    public function addService(ServiceInterface $service);
    public function setDecoder(DecoderInterface $decoder);
    public function setEncoder(EncoderInterface $encoder);
    public function onOpen(Server $server, Request $request);
    public function onMessage(Server $server, Frame $frame);
    public function onClose(Server $server, int $fd);
    public function start();
}
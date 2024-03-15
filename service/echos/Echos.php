<?php

namespace service\echos;

use core\service\Service;
use packages\RequestPackageInterface;
use packages\ResponsePackageInterface;
use response\echos\EchoMsg;

class Echos extends Service
{
    protected string $service = 'echo';
    protected string $module = 'EchoTest';
    public function handle(int $fd, RequestPackageInterface $package): ?ResponsePackageInterface
    {
        $msg = json_encode(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]);
        $this->server->ws->task(['taskName' => 'Broadcast', 'msg' => $msg]);
        $msg = $package->getMessage();
        $content = $msg['content'];
        return new EchoMsg(['content' => $content]);
    }
}
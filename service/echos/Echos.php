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
        $msg = $package->getMessage();
        $content = $msg['content'];
        return new EchoMsg(['content' => $content]);
    }
}
<?php

declare(strict_types=1);
/**
 * @author zhang rui<zhangruirui@zhangruirui.com>
 * @see
 */

namespace core;


use response\server\ServiceNotfound;

class Dispatch
{
    protected array $services = [];

    public function __construct()
    {

    }

    public function addService(Service $service): self
    {
        $msgType = $service->getMsgType();
        $module = $service->getModule();
        $this->services[$msgType][$module] = $service;
        return $this;
    }

    public function exec(Message $message): ?Response
    {
        if (isset($this->services[$message->type])) {
            if (isset($this->services[$message->type][$message->module])) {
                $service = $this->services[$message->type][$message->module];
                if (method_exists($service, $message->method)) {
                    $ret = call_user_func([$service, $message->method], $message, ...array_values($message->params));
                    if ($ret instanceof Response) {
                        return $ret;
                    }
                } else {
                    echo '方法不存在';
                }
            } else {
                return new ServiceNotfound();
            }
        } else {
            echo '消息类型无法处理';
        }
        return null;
    }
}
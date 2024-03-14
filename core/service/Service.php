<?php

declare(strict_types=1);
/**
 * @author zhang rui<zhangruirui@zhangruirui.com>
 * @see https://github.com/zhangrui-git/swoole-im.git
 */

namespace core\service;


use core\server\WebsocketServer;
use Exception;

abstract class Service implements ServiceInterface
{
    public WebSocketServer $server;
    protected string $service;
    protected string $module;

    /**
     * @throws Exception
     */
    public function __construct(WebsocketServer $server)
    {
        $this->server = $server;
        if (empty($this->service) || empty($this->module)) {
            throw new Exception();
        }
    }

    public function getService(): string
    {
        return $this->service;
    }

    public function getModule(): string
    {
        return $this->module;
    }
}
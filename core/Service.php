<?php

declare(strict_types=1);


namespace core;


use Psr\Container\ContainerInterface;

abstract class Service
{
    public string $msgType;
    public string $module;
    public WebsocketServer $server;

    public function __construct(WebsocketServer $server)
    {
        $this->server = $server;
    }

    abstract public function getMsgType(): string ;
    abstract public function getModule(): string ;
}
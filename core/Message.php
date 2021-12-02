<?php

declare(strict_types=1);


namespace core;


class Message
{
    public string $ssid;
    public int $fd;
    public string $type;
    public string $version;
    public string $module;
    public string $method;
    public array $params;
}
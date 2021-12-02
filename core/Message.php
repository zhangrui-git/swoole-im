<?php

declare(strict_types=1);
/**
 * @author zhang rui<zhangruirui@zhangruirui.com>
 * @see https://github.com/zhangrui-git/im.git/
 */

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
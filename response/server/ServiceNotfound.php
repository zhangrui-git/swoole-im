<?php

declare(strict_types=1);
/**
 * @author zhang rui<zhangruirui@zhangruirui.com>
 * @see https://github.com/zhangrui-git/im.git/
 */

namespace response\server;


use core\Response;

class ServiceNotfound extends Response
{
    protected int $status = 404;
    public string $msg = 'controller not fund';
}
<?php

declare(strict_types=1);
/**
 * @author zhang rui<zhangruirui@zhangruirui.com>
 * @see https://github.com/zhangrui-git/im.git/
 */

namespace response\server;


use core\Response;

class ServerError extends Response
{
    public int $status = 500;
    public string $msg = 'server error';
}
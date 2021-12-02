<?php

declare(strict_types=1);


namespace response\server;


use core\Response;

class ServiceNotfound extends Response
{
    protected int $status = 404;
    public string $msg = 'controller not fund';
}
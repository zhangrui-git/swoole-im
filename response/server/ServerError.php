<?php

declare(strict_types=1);


namespace response\server;


use core\Response;

class ServerError extends Response
{
    public int $status = 500;
    public string $msg = 'server error';
}
<?php

namespace response\echos;

use packages\WebSocketResponse;

class EchoMsg extends WebSocketResponse
{
    protected int $version = 1;

    protected string $service = 'echo';

    protected string $module = 'EchoTest';
}
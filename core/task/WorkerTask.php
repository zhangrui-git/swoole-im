<?php

namespace core\task;

use core\server\WebSocketServer;
use core\task\WorkerTaskInterface;
use Exception;
use Swoole\WebSocket\Server;

abstract class WorkerTask implements WorkerTaskInterface
{
    public WebSocketServer $server;
    protected string $taskName;

    /**
     * @throws Exception
     */
    public function __construct(WebsocketServer $server)
    {
        $this->server = $server;
        if (empty($this->taskName)) {
            throw new Exception();
        }
    }

    public function getTaskName(): string
    {
        return $this->taskName;
    }
}
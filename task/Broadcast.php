<?php

namespace task;

use core\task\WorkerTask;
use Swoole\WebSocket\Server;

class Broadcast extends WorkerTask
{
    protected string $taskName = 'Broadcast';
    public function handle(Server $server, $taskId, $reactorId, $msg): ?string
    {
        foreach ($server->connections as $fd) {
            if ($server->isEstablished($fd)) {
                $server->push($fd, $msg);
            }
        }
        return null;
    }
}
<?php

namespace core\task;

use Swoole\WebSocket\Server;

interface WorkerTaskInterface
{
    public function getTaskName(): string;
    public function handle(Server $server, $taskId, $reactorId, $msg): ?string;
}
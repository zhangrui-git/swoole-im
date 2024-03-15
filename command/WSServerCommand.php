<?php

declare(strict_types=1);
/**
 * @author zhang rui<zhangruirui@zhangruirui.com>
 * @see https://github.com/zhangrui-git/swoole-im.git
 */

namespace command;


use core\server\WebSocketServer;
use Exception;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use packages\JsonDecoder;
use packages\JsonEncoder;
use service\chat\SingleChatText;
use service\echos\Echos;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use task\Broadcast;

/**
 * websocket服务管理命令
 * Class ServerCommand
 * @package command
 */
class WSServerCommand extends Command
{
    protected function configure()
    {
        $this->setName('server');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->start($input, $output);
        return Command::SUCCESS;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @throws Exception
     */
    protected function start(InputInterface $input, OutputInterface $output)
    {
        $log = new Logger('socket_server');
        $log->pushHandler(new StreamHandler('php://stdout', Logger::DEBUG));
        $server = new WebSocketServer('0.0.0.0', 8080);
        $server->addService(new SingleChatText($server));
        $server->addService(new Echos($server));
        $server->addTask(new Broadcast($server));
        $server->setLogger($log);
        $server->setDecoder(new JsonDecoder());
        $server->setEncoder(new JsonEncoder());
        $server->start();
    }
}
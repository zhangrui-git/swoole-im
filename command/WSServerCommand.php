<?php

declare(strict_types=1);
/**
 * @author zhang rui<zhangruirui@zhangruirui.com>
 * @see https://github.com/zhangrui-git/im.git/
 */

namespace command;


use core\Dispatch;
use core\WebSocketServer;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use service\chat\TextMsg;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->start($input, $output);
        return Command::SUCCESS;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @throws \Exception
     */
    protected function start(InputInterface $input, OutputInterface $output)
    {
        $log = new Logger('socket_server');
        $log->pushHandler(new StreamHandler('php://stdout', Logger::DEBUG));
        $server = new WebSocketServer('0.0.0.0', 80);
        $server->setLogger($log);
        $dispatch = new Dispatch();
        $dispatch->addService(new TextMsg($server));
        $server->setDispatch($dispatch);
        $server->start();
    }
}
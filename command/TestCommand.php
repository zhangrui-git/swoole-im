<?php

declare(strict_types=1);


namespace command;


use response\chat\SendTo;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Command
{
    protected function configure()
    {
        $this->setName('test');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sendTo = new SendTo();
        $sendTo->setForm('zzz')->setContent('abc');
        echo strval($sendTo);
        return 0;
    }
}
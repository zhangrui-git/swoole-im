<?php

declare(strict_types=1);
/**
 * @author zhang rui<zhangruirui@zhangruirui.com>
 * @see https://github.com/zhangrui-git/im.git/
 */

namespace service\chat;


use core\service\Service;
use packages\ResponsePackageInterface;
use response\chat\SingleChatTextAckMsg;
use response\chat\SingleChatTextSendMsg;

class SingleChatText extends Service
{
    protected string $service = 'chat';
    protected string $module = 'SingleChatText';

    public function handle($fd, $package): ?ResponsePackageInterface
    {
        $log = $this->server->log;
        $msg = $package->getMessage();
        $toSsid = $msg['toSsid'];
        $toFd = $this->server->session->getFd($toSsid);
        if ($toFd !== false && $this->server->ws->isEstablished($toFd)) {
            $content = $msg['content'];
            $fromSsid = $this->server->session->getSsid($fd) ?? '';
            $sendRsp = new SingleChatTextSendMsg();
            $sendRsp->setFromSsid($fromSsid);
            $sendRsp->setContent($content);
            $this->server->ws->push($toFd, $this->server->getEncoder()->encode($sendRsp->all()));

            $ackRsp = new SingleChatTextAckMsg();
            $ackRsp->setReturnMessage('ok');
            return $ackRsp;
        } else {
            $log->debug('offline', ['toSsid' => $toSsid]);
        }
        return null;
    }
}
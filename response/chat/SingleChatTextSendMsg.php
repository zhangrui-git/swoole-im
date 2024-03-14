<?php

declare(strict_types=1);
/**
 * @author zhang rui<zhangruirui@zhangruirui.com>
 * @see https://github.com/zhangrui-git/swoole-im.git
 */

namespace response\chat;


use packages\WebSocketResponse;

class SingleChatTextSendMsg extends WebSocketResponse
{
    protected int $version = 1;

    protected string $service = 'chat';

    protected string $module = 'SingleChatText';

    public function setFromSsid(string $ssid): self
    {
        $this->data['formSsid'] = $ssid;
        return $this;
    }

    public function setContent(string $msg): self
    {
        $this->data['content'] = $msg;
        return $this;
    }
}
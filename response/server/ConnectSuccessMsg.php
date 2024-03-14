<?php

declare(strict_types=1);
/**
 * @author zhang rui<zhangruirui@zhangruirui.com>
 * @see https://github.com/zhangrui-git/swoole-im.git
 */

namespace response\server;


use packages\WebSocketResponse;

class ConnectSuccessMsg extends WebSocketResponse
{
    protected int $version = 1;

    protected string $service = 'system';

    protected string $module = 'UserLogin';

    public function setSsid(string $ssid): self
    {
        $this->data['ssid'] = $ssid;
        return $this;
    }
}
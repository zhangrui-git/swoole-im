<?php

declare(strict_types=1);
/**
 * @author zhang rui<zhangruirui@zhangruirui.com>
 * @see https://github.com/zhangrui-git/im.git/
 */

namespace response\server;


use core\Response;

class ConnectSuccess extends Response
{
    public string $major = 'Server';
    public string $minor = 'Conn';

    public function setSsid(string $ssid): self
    {
        $this->data['ssid'] = $ssid;
        return $this;
    }
}
<?php

declare(strict_types=1);


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
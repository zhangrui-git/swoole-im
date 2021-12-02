<?php

declare(strict_types=1);


namespace response\chat;


use core\Response;

class SendTo extends Response
{
    protected string $major = 'chat';
    protected string $minor = 'textMsg';

    public function setForm(string $ssid): self
    {
        $this->data['form'] = $ssid;
        return $this;
    }

    public function setContent(string $msg): self
    {
        $this->data['content'] = $msg;
        return $this;
    }
}
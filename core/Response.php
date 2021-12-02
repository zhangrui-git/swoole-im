<?php

declare(strict_types=1);


namespace core;


abstract class Response implements \JsonSerializable
{
    public string $version = '0.0.1';
    public int $status = 200;
    public string $msg = '';
    public int $timestamp = 0;

    protected array $data = [];
    protected string $major = '';
    protected string $minor = '';

    public function jsonSerialize()
    {
        $body = [
            'version' => $this->version,
            'status' => $this->status,
            'msg' => $this->msg,
            'timestamp' => time(),
        ];
        if (empty($this->data) == false && $this->major !== '' && $this->minor !== '') {
            $body['data'][$this->major][$this->minor] = $this->data;
        }
        return $body;
    }

    public function __toString()
    {
        return json_encode($this);
    }
}
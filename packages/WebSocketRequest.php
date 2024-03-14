<?php

namespace packages;

use core\util\Version;
use Exception;

class WebSocketRequest implements RequestPackageInterface
{
    protected int $version;
    protected string $service;
    protected string $module;
    protected array $message;

    /**
     * @throws Exception
     */
    public function __construct(array $data)
    {
        if (isset($data['ver'])) {
            $this->version = Version::toInt($data['ver']);
        } else {
            throw new Exception('数据格式错误');
        }
        if (isset($data['serviceName'])) {
            list($this->service, $this->module) = explode('.', $data['serviceName']);
        } else {
            throw new Exception('数据格式错误');
        }
        if (isset($data['msg'])) {
            $this->message = $data['msg'];
        } else {
            throw new Exception('数据格式错误');
        }
    }

    public function getVersion(): int
    {
        return $this->version;
    }

    public function getService(): string
    {
        return $this->service;
    }

    public function getModule(): string
    {
        return $this->module;
    }

    public function getMessage(): array
    {
        return $this->message;
    }
}
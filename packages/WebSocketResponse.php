<?php

namespace packages;

use Exception;

class WebSocketResponse implements ResponsePackageInterface
{
    protected int $version;
    protected string $service;
    protected string $module;
    protected int $returnStatus = 0;
    protected string $returnMessage = '';

    protected array $data = [];

    /**
     * @throws Exception
     */
    public function __construct(array $data = [], int $version = 0)
    {
        $this->data = $data;
        if (empty($this->version)) {
            $this->version = $version;
        }
        if (empty($this->service) || empty($this->module)) {
            throw new Exception();
        }
    }

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
        return $this;
    }

    protected function getService(): string
    {
        return $this->service;
    }

    protected function getModule(): string
    {
        return $this->module;
    }

    public function getServiceName(): string
    {
        return $this->getService() .'.'. $this->getModule();
    }

    public function getReturnStatus(): int
    {
        return $this->returnStatus;
    }

    public function setReturnStatus(int $status): self
    {
        $this->returnStatus = $status;
        return $this;
    }

    public function getReturnMessage(): string
    {
        return $this->returnMessage;
    }

    public function setReturnMessage(string $msg): self
    {
        $this->returnMessage = $msg;
        return $this;
    }

    public function getMessage(): array
    {
        return $this->data;
    }

    public function all(): array
    {
        return [
            'serviceName' => $this->getServiceName(),
            'retStat' => $this->getReturnStatus(),
            'retMsg' => $this->getReturnMessage(),
            'msg' => $this->getMessage(),
            'time' => time(),
        ];
    }
}
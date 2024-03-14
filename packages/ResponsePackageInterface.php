<?php

namespace packages;

interface ResponsePackageInterface
{
    public function getServiceName(): string;
    public function getReturnStatus(): int;
    public function getReturnMessage(): string;
    public function getMessage(): array;
    public function all(): array;
}
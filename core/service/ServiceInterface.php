<?php

namespace core\service;

use packages\RequestPackageInterface;
use packages\ResponsePackageInterface;

interface ServiceInterface
{
    public function getService(): string;
    public function getModule(): string;
    public function handle(int $fd, RequestPackageInterface $package): ?ResponsePackageInterface;
}
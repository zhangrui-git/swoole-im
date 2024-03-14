<?php

namespace packages;

interface RequestPackageInterface
{
    public function getVersion(): int;
    public function getService(): string;
    public function getModule(): string;
    public function getMessage(): array;
}
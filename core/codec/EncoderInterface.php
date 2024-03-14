<?php

namespace core\codec;

interface EncoderInterface
{
    public function encode($data): string;
}
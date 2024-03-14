<?php

namespace core\codec;

interface DecoderInterface
{
    public function decode(string $data);
}
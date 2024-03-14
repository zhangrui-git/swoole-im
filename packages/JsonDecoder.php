<?php

namespace packages;

use core\codec\DecoderInterface;
use Exception;

class JsonDecoder implements DecoderInterface
{
    /**
     * @throws Exception
     */
    public function decode(string $data): array
    {
        $d = json_decode($data, true);
        if ($d === false) {
            throw new Exception('数据格式错误');
        }
        return $d;
    }
}
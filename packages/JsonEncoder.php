<?php

namespace packages;

use core\codec\EncoderInterface;
use Exception;

class JsonEncoder implements EncoderInterface
{
    /**
     * @throws Exception
     */
    public function encode($data): string
    {
        $s = json_encode($data);
        if ($s === false) {
            throw new Exception('数据格式错误');
        }
        return $s;
    }
}
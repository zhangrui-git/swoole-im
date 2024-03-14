<?php

namespace core\util;

class Version
{
    public static function toInt(string $v): int
    {
        $v1 = $v2 = $v3 = 0;
        $s = explode('.', $v, 3);
        if (isset($s[0])) {
            $v1 = intval($s[0]) * 1000000;
        }
        if (isset($s[1])) {
            $v2 = intval($s[1]) * 10000;
        }
        if (isset($s[2])) {
            $v3 = intval($s[2]) * 1000;
        }
        return $v1 + $v2 + $v3;
    }
}
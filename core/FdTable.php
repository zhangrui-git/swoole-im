<?php

declare(strict_types=1);
/**
 * @author zhang rui<zhangruirui@zhangruirui.com>
 * @see https://github.com/zhangrui-git/im.git/
 */

namespace core;


use Swoole\Table;

/**
 * 连接句柄表
 * Class FdTable
 * @package server
 */
class FdTable extends Table
{
    public function __construct(int $table_size, float $conflict_proportion = 0.2)
    {
        parent::__construct($table_size, $conflict_proportion);
        $this->column('ssid', table::TYPE_STRING, 255);
        $this->create();
    }
}
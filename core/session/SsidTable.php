<?php

declare(strict_types=1);
/**
 * @author zhang rui<zhangruirui@zhangruirui.com>
 * @see https://github.com/zhangrui-git/im.git/
 */

namespace core\session;


use Swoole\Table;

/**
 * 会话映射表
 * Class FdTable
 * @package server
 */
class SsidTable extends Table
{
    public function __construct(int $table_size, float $conflict_proportion = 0.2)
    {
        parent::__construct($table_size, $conflict_proportion);
        $this->column('fd', Table::TYPE_INT);
        $this->create();
    }
}
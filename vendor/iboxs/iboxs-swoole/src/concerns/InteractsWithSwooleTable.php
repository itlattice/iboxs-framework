<?php
// +----------------------------------------------------------------------
// | iboxsPHP [ WE CAN DO IT JUST iboxs IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2018 http://iboxsphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: yunwuxin <448901948@qq.com>
// +----------------------------------------------------------------------

namespace iboxs\swoole\concerns;

use Swoole\Table as SwooleTable;
use iboxs\App;
use iboxs\swoole\Table;

/**
 * Trait InteractsWithSwooleTable
 *
 * @property App $container
 * @property App $app
 */
trait InteractsWithSwooleTable
{
    /**
     * @var Table
     */
    protected $currentTable;

    /**
     * Register customized swoole tables.
     */
    protected function prepareTables()
    {
        $this->currentTable = new Table();
        $this->registerTables();
        $this->onEvent('workerStart', function () {
            $this->app->instance(Table::class, $this->currentTable);
            foreach ($this->currentTable->getAll() as $name => $table) {
                $this->app->instance("swoole.table.{$name}", $table);
            }
        });
    }

    /**
     * Register user-defined swoole tables.
     */
    protected function registerTables()
    {
        $tables = $this->container->make('config')->get('swoole.tables', []);

        foreach ($tables as $key => $value) {
            $table   = new SwooleTable($value['size']);
            $columns = $value['columns'] ?? [];
            foreach ($columns as $column) {
                if (isset($column['size'])) {
                    $table->column($column['name'], $column['type'], $column['size']);
                } else {
                    $table->column($column['name'], $column['type']);
                }
            }
            $table->create();

            $this->currentTable->add($key, $table);
        }
    }
}

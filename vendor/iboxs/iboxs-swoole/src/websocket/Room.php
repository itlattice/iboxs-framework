<?php

namespace iboxs\swoole\websocket;

use iboxs\Manager;
use iboxs\swoole\websocket\room\Table;

/**
 * Class Room
 * @package iboxs\swoole\websocket
 * @mixin Table
 */
class Room extends Manager
{
    protected $namespace = "\\iboxs\\swoole\\websocket\\room\\";

    protected function resolveConfig(string $name)
    {
        return $this->app->config->get("swoole.websocket.room.{$name}", []);
    }

    /**
     * 默认驱动
     * @return string|null
     */
    public function getDefaultDriver()
    {
        return $this->app->config->get('swoole.websocket.room.type', 'table');
    }
}

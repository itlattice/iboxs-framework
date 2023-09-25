<?php

namespace iboxs\swoole\pool;

use iboxs\swoole\pool\proxy\Store;

class Cache extends \iboxs\Cache
{
    protected function createDriver(string $name)
    {
        return new Store(function () use ($name) {
            return parent::createDriver($name);
        }, $this->app->config->get('swoole.pool.cache', []));
    }

}

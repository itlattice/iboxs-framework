<?php

namespace iboxs\swoole\watcher;

interface Driver
{
    public function watch(callable $callback);
}

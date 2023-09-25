<?php

namespace iboxs\swoole;

/**
 *
 * @mixin \iboxs\swoole\ipc\driver\UnixSocket
 */
class Ipc extends \iboxs\Manager
{

    protected $namespace = "\\iboxs\\swoole\\ipc\\driver\\";

    protected function resolveConfig(string $name)
    {
        return $this->app->config->get("swoole.ipc.{$name}", []);
    }

    public function getDefaultDriver()
    {
        return $this->app->config->get('swoole.ipc.type', 'unix_socket');
    }
}

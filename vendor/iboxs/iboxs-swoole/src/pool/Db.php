<?php

namespace iboxs\swoole\pool;

use iboxs\Config;
use iboxs\db\ConnectionInterface;
use iboxs\swoole\pool\proxy\Connection;

/**
 * Class Db
 * @package iboxs\swoole\pool
 * @property Config $config
 */
class Db extends \iboxs\Db
{

    protected function createConnection(string $name): ConnectionInterface
    {
        return new Connection(new class(function () use ($name) {
            return parent::createConnection($name);
        }) extends Connector {
            public function disconnect($connection)
            {
                if ($connection instanceof ConnectionInterface) {
                    $connection->close();
                }
            }
        }, $this->config->get('swoole.pool.db', []));
    }

}

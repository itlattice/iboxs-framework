<?php

namespace iboxs\tests\swoole;

use PHPUnit\Framework\TestCase;
use iboxs\swoole\Server;

class ServerTest extends TestCase
{
    public function testStart()
    {
        $server = new Server();

        $server->start();
    }
}

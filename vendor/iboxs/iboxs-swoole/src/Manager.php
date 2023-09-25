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

namespace iboxs\swoole;

use iboxs\swoole\concerns\InteractsWithHttp;
use iboxs\swoole\concerns\InteractsWithPools;
use iboxs\swoole\concerns\InteractsWithQueue;
use iboxs\swoole\concerns\InteractsWithRpcClient;
use iboxs\swoole\concerns\InteractsWithRpcServer;
use iboxs\swoole\concerns\InteractsWithServer;
use iboxs\swoole\concerns\InteractsWithSwooleTable;
use iboxs\swoole\concerns\InteractsWithTracing;
use iboxs\swoole\concerns\WithApplication;
use iboxs\swoole\concerns\WithContainer;

/**
 * Class Manager
 */
class Manager
{
    use InteractsWithServer,
        InteractsWithSwooleTable,
        InteractsWithHttp,
        InteractsWithPools,
        InteractsWithRpcClient,
        InteractsWithRpcServer,
        InteractsWithQueue,
        InteractsWithTracing,
        WithContainer,
        WithApplication;

    /**
     * Initialize.
     */
    protected function initialize(): void
    {
        $this->prepareTables();
        $this->preparePools();
        $this->prepareHttp();
        $this->prepareRpcServer();
        $this->prepareQueue();
        $this->prepareRpcClient();
        $this->prepareTracing();
    }

}

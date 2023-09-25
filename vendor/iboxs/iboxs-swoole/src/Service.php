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

use iboxs\swoole\command\RpcInterface;
use iboxs\swoole\command\Server as ServerCommand;

class Service extends \iboxs\Service
{

    public function boot()
    {
        $this->commands(
            ServerCommand::class,
            RpcInterface::class
        );
    }

}

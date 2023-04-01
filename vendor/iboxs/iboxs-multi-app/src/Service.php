<?php
// +----------------------------------------------------------------------
// | iboxsPHP [ WE CAN DO IT JUST iboxs IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2018 http://iboxsphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
namespace iboxs\app;

use iboxs\Service as BaseService;

class Service extends BaseService
{
    public function boot()
    {
        $this->app->event->listen('HttpRun', function () {
            $this->app->middleware->add(MultiApp::class);
        });

        $this->commands([
            'build' => command\Build::class,
            'clear' => command\Clear::class,
        ]);

        $this->app->bind([
            'iboxs\route\Url' => Url::class,
        ]);
    }
}

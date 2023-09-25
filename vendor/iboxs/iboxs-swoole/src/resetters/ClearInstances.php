<?php

namespace iboxs\swoole\resetters;

use iboxs\App;
use iboxs\swoole\contract\ResetterInterface;
use iboxs\swoole\Sandbox;

class ClearInstances implements ResetterInterface
{
    public function handle(App $app, Sandbox $sandbox)
    {
        $instances = ['log', 'session', 'view', 'response', 'cookie'];

        $instances = array_merge($instances, $sandbox->getConfig()->get('swoole.instances', []));

        foreach ($instances as $instance) {
            $app->delete($instance);
        }

        return $app;
    }
}

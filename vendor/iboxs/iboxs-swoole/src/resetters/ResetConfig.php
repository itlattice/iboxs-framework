<?php

namespace iboxs\swoole\resetters;

use iboxs\App;
use iboxs\swoole\contract\ResetterInterface;
use iboxs\swoole\Sandbox;

class ResetConfig implements ResetterInterface
{

    public function handle(App $app, Sandbox $sandbox)
    {
        $app->instance('config', clone $sandbox->getConfig());

        return $app;
    }
}

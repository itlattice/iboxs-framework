<?php

namespace iboxs\swoole\resetters;

use iboxs\App;
use iboxs\swoole\concerns\ModifyProperty;
use iboxs\swoole\contract\ResetterInterface;
use iboxs\swoole\Sandbox;

/**
 * Class ResetEvent
 * @package iboxs\swoole\resetters
 */
class ResetEvent implements ResetterInterface
{
    use ModifyProperty;

    public function handle(App $app, Sandbox $sandbox)
    {
        $event = clone $sandbox->getEvent();
        $this->modifyProperty($event, $app);
        $app->instance('event', $event);

        return $app;
    }
}

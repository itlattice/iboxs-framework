<?php

namespace iboxs\swoole\resetters;

use iboxs\App;
use iboxs\Model;
use iboxs\swoole\contract\ResetterInterface;
use iboxs\swoole\Sandbox;

class ResetModel implements ResetterInterface
{

    public function handle(App $app, Sandbox $sandbox)
    {
        if (class_exists(Model::class)) {
            Model::setInvoker(function (...$args) use ($sandbox) {
                return $sandbox->getApplication()->invoke(...$args);
            });
        }
    }
}

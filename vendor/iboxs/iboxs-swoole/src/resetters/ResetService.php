<?php

namespace iboxs\swoole\resetters;

use iboxs\App;
use iboxs\swoole\concerns\ModifyProperty;
use iboxs\swoole\contract\ResetterInterface;
use iboxs\swoole\Sandbox;

/**
 * Class ResetService
 * @package iboxs\swoole\resetters
 */
class ResetService implements ResetterInterface
{
    use ModifyProperty;

    /**
     * "handle" function for resetting app.
     *
     * @param App $app
     * @param Sandbox $sandbox
     */
    public function handle(App $app, Sandbox $sandbox)
    {
        foreach ($sandbox->getServices() as $service) {
            $this->modifyProperty($service, $app);
            if (method_exists($service, 'register')) {
                $service->register();
            }
            if (method_exists($service, 'boot')) {
                $app->invoke([$service, 'boot']);
            }
        }
    }

}

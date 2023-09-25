<?php

namespace iboxs\swoole\contract;

use iboxs\App;
use iboxs\swoole\Sandbox;

interface ResetterInterface
{
    /**
     * "handle" function for resetting app.
     *
     * @param \iboxs\App $app
     * @param Sandbox $sandbox
     */
    public function handle(App $app, Sandbox $sandbox);
}

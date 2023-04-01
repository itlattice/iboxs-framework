<?php
// +----------------------------------------------------------------------
// | iboxsPHP [ WE CAN DO IT JUST iboxs IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2021 http://iboxsphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
namespace iboxs\console\command\make;

use iboxs\console\command\Make;

class Event extends Make
{
    protected $type = "Event";

    protected function configure()
    {
        parent::configure();
        $this->setName('make:event')
            ->setDescription('Create a new event class');
    }

    protected function getStub(): string
    {
        return __DIR__ . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR . 'event.stub';
    }

    protected function getNamespace(string $app): string
    {
        return parent::getNamespace($app) . '\\event';
    }
}

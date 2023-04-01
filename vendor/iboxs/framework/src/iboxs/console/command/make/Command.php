<?php
// +----------------------------------------------------------------------
// | iboxsPHP [ WE CAN DO IT JUST iboxs ]
// +----------------------------------------------------------------------
// | Copyright (c) 2023 http://lyweb.com.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: itlattice <notice@itgz8.com>
// +----------------------------------------------------------------------

namespace iboxs\console\command\make;

use iboxs\console\command\Make;
use iboxs\console\input\Argument;

class Command extends Make
{
    protected $type = "Command";

    protected function configure()
    {
        parent::configure();
        $this->setName('make:command')
            ->addArgument('commandName', Argument::OPTIONAL, "The name of the command")
            ->setDescription('Create a new command class');
    }

    protected function buildClass(string $name): string
    {
        $commandName = $this->input->getArgument('commandName') ?: strtolower(basename($name));
        $namespace   = trim(implode('\\', array_slice(explode('\\', $name), 0, -1)), '\\');

        $class = str_replace($namespace . '\\', '', $name);
        $stub  = file_get_contents($this->getStub());

        return str_replace(['{%commandName%}', '{%className%}', '{%namespace%}', '{%app_namespace%}'], [
            $commandName,
            $class,
            $namespace,
            $this->app->getNamespace(),
        ], $stub);
    }

    protected function getStub(): string
    {
        return __DIR__ . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR . 'command.stub';
    }

    protected function getNamespace(string $app): string
    {
        return parent::getNamespace($app) . '\\command';
    }

}

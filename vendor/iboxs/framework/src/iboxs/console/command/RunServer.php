<?php
// +----------------------------------------------------------------------
// | iboxsPHP [ WE CAN DO IT JUST iboxs ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2015 http://iboxsphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: Slince <taosikai@yeah.net>
// +----------------------------------------------------------------------
declare (strict_types = 1);

namespace iboxs\console\command;

use iboxs\console\Command;
use iboxs\console\Input;
use iboxs\console\input\Option;
use iboxs\console\Output;

class RunServer extends Command
{
    public function configure()
    {
        $this->setName('run')
            ->addOption(
                'host',
                'H',
                Option::VALUE_OPTIONAL,
                'The host to server the application on',
                '0.0.0.0'
            )
            ->addOption(
                'port',
                'p',
                Option::VALUE_OPTIONAL,
                'The port to server the application on',
                8000
            )
            ->addOption(
                'root',
                'r',
                Option::VALUE_OPTIONAL,
                'The document root of the application',
                ''
            )
            ->setDescription('PHP Built-in Server for iboxsPHP');
    }

    public function execute(Input $input, Output $output)
    {
        $host = $input->getOption('host');
        $port = $input->getOption('port');
        $root = $input->getOption('root');
        if (empty($root)) {
            $root = $this->app->getRootPath() . 'public';
        }

        $command = sprintf(
            'php -S %s:%d -t %s %s',
            $host,
            $port,
            escapeshellarg($root),
            escapeshellarg($root . DIRECTORY_SEPARATOR . 'router.php')
        );

        $output->writeln(sprintf('iboxsPHP Development server is started On <http://%s:%s/>', $host, $port));
        $output->writeln(sprintf('You can exit with <info>`CTRL-C`</info>'));
        $output->writeln(sprintf('Document root is: %s', $root));
        passthru($command);
    }

}

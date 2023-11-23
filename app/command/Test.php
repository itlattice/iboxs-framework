<?php
declare (strict_types = 1);

namespace app\command;

use iboxs\console\Command;
use iboxs\console\Input;
use iboxs\console\input\Argument;
use iboxs\console\input\Option;
use iboxs\console\Output;
use until\JWT;

class Test extends Command
{
    protected function configure()
    {
        // 指令配置
        $this->setName('test')
            ->setDescription('the test command');
    }

    protected function execute(Input $input, Output $output)
    {
        
    }
}

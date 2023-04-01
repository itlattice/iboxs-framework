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
declare (strict_types = 1);

namespace iboxs\event;

/**
 * LogWrite事件类
 */
class LogWrite
{
    /** @var string */
    public $channel;

    /** @var array */
    public $log;

    public function __construct($channel, $log)
    {
        $this->channel = $channel;
        $this->log     = $log;
    }
}

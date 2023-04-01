<?php
// +----------------------------------------------------------------------
// | iboxsPHP [ WE CAN DO IT JUST iboxs ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2021 http://iboxsphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: yunwuxin <448901948@qq.com>
// +----------------------------------------------------------------------
namespace iboxs\event;

/**
 * LogRecord事件类
 */
class LogRecord
{
    /** @var string */
    public $type;

    /** @var string */
    public $message;

    public function __construct($type, $message)
    {
        $this->type    = $type;
        $this->message = $message;
    }
}

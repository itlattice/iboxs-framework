<?php
// +----------------------------------------------------------------------
// | iboxsPHP [ WE CAN DO IT JUST iboxs ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2021 http://iboxsphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
declare (strict_types = 1);

namespace iboxs\facade;

use iboxs\Facade;

/**
 * @see \iboxs\Event
 * @package iboxs\facade
 * @mixin \iboxs\Event
 * @method static \iboxs\Event listenEvents(array $events) 批量注册事件监听
 * @method static \iboxs\Event listen(string $event, mixed $listener, bool $first = false) 注册事件监听
 * @method static bool hasListener(string $event) 是否存在事件监听
 * @method static void remove(string $event) 移除事件监听
 * @method static \iboxs\Event bind(array $events) 指定事件别名标识 便于调用
 * @method static \iboxs\Event subscribe(mixed $subscriber) 注册事件订阅者
 * @method static \iboxs\Event observe(string|object $observer, null|string $prefix = '') 自动注册事件观察者
 * @method static mixed trigger(string|object $event, mixed $params = null, bool $once = false) 触发事件
 * @method static mixed until($event, $params = null) 触发事件(只获取一个有效返回值)
 */
class Event extends Facade
{
    /**
     * 获取当前Facade对应类名（或者已经绑定的容器对象标识）
     * @access protected
     * @return string
     */
    protected static function getFacadeClass()
    {
        return 'event';
    }
}

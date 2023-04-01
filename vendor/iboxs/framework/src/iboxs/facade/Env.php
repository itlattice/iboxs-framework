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

namespace iboxs\facade;

use iboxs\Facade;

/**
 * @see \iboxs\Env
 * @package iboxs\facade
 * @mixin \iboxs\Env
 * @method static void load(string $file) 读取环境变量定义文件
 * @method static mixed get(string $name = null, mixed $default = null) 获取环境变量值
 * @method static void set(string|array $env, mixed $value = null) 设置环境变量值
 * @method static bool has(string $name) 检测是否存在环境变量
 * @method static void __set(string $name, mixed $value) 设置环境变量
 * @method static mixed __get(string $name) 获取环境变量
 * @method static bool __isset(string $name) 检测是否存在环境变量
 * @method static void offsetSet($name, $value)
 * @method static bool offsetExists($name)
 * @method static mixed offsetUnset($name)
 * @method static mixed offsetGet($name)
 */
class Env extends Facade
{
    /**
     * 获取当前Facade对应类名（或者已经绑定的容器对象标识）
     * @access protected
     * @return string
     */
    protected static function getFacadeClass()
    {
        return 'env';
    }
}

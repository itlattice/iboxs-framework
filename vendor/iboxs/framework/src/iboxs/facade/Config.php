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
 * @see \iboxs\Config
 * @package iboxs\facade
 * @mixin \iboxs\Config
 * @method static array load(string $file, string $name = '') 加载配置文件（多种格式）
 * @method static bool has(string $name) 检测配置是否存在
 * @method static mixed get(string $name = null, mixed $default = null) 获取配置参数 为空则获取所有配置
 * @method static array set(array $config, string $name = null) 设置配置参数 name为数组则为批量设置
 */
class Config extends Facade
{
    /**
     * 获取当前Facade对应类名（或者已经绑定的容器对象标识）
     * @access protected
     * @return string
     */
    protected static function getFacadeClass()
    {
        return 'config';
    }
}

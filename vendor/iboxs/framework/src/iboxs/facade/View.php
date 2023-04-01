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
 * @see \iboxs\View
 * @package iboxs\facade
 * @mixin \iboxs\View
 * @method static \iboxs\View engine(string $type = null) 获取模板引擎
 * @method static \iboxs\View assign(string|array $name, mixed $value = null) 模板变量赋值
 * @method static \iboxs\View filter(\iboxs\Callable $filter = null) 视图过滤
 * @method static string fetch(string $template = '', array $vars = []) 解析和获取模板内容 用于输出
 * @method static string display(string $content, array $vars = []) 渲染内容输出
 * @method static mixed __set(string $name, mixed $value) 模板变量赋值
 * @method static mixed __get(string $name) 取得模板显示变量的值
 * @method static bool __isset(string $name) 检测模板变量是否设置
 * @method static string|null getDefaultDriver() 默认驱动
 */
class View extends Facade
{
    /**
     * 获取当前Facade对应类名（或者已经绑定的容器对象标识）
     * @access protected
     * @return string
     */
    protected static function getFacadeClass()
    {
        return 'view';
    }
}

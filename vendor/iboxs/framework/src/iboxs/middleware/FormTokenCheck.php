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

namespace iboxs\middleware;

use Closure;
use iboxs\exception\ValidateException;
use iboxs\Request;
use iboxs\Response;

/**
 * 表单令牌支持
 */
class FormTokenCheck
{

    /**
     * 表单令牌检测
     * @access public
     * @param Request $request
     * @param Closure $next
     * @param string  $token 表单令牌Token名称
     * @return Response
     */
    public function handle(Request $request, Closure $next, string $token = null)
    {
        $check = $request->checkToken($token ?: '__token__');

        if (false === $check) {
            throw new ValidateException('invalid token');
        }

        return $next($request);
    }

}

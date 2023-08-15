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
use iboxs\redis\Redis;

class CheckToken
{
    public function handle($request, \Closure $next)
    {
        $extend=config('middleware.extend',[]);
        $appName=appName();
        if(in_array($appName,$extend['app']??[])
            ||in_array(request()->controller(),$extend['controller']??[])
            ||in_array(request()->action(),$extend['action']??[])
            ||in_array(request()->pathinfo(),$extend['path']??[])
        ){
            return $next($request);
        }
        $statusCode=config('middleware.extend.statusCode','403');
        $noCodeMsg=config('middleware.extend.noCodeMsg',
            [
                'code'=>-1,
                'msg'=>'非法请求'
            ]);
        if(request()->isPost()){
            $token=request()->post('token');
            if(!$token){
                return json($noCodeMsg,$statusCode);
            }
            $num=Redis::basic()->get("token:".$token,9999);
            if($num>300){
                return json($noCodeMsg,$statusCode);
            }
            Redis::basic()->inc("token:".$token);
        }
        return $next($request);
    }
}

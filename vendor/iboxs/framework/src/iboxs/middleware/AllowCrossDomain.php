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
use iboxs\basic\Basic;
use iboxs\Config;
use iboxs\Request;
use iboxs\Response;

/**
 * 跨域请求支持
 */
class AllowCrossDomain
{
    protected $cookieDomain;

    protected $header = [
        'Access-Control-Allow-Credentials' => 'true',
        'Access-Control-Max-Age'           => 1800,
        'Access-Control-Allow-Methods'     => 'GET, POST, PATCH, PUT, DELETE, OPTIONS',
        'Access-Control-Allow-Headers'     => 'Authorization, Content-Type, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-CSRF-TOKEN, X-Requested-With',
    ];

    public function __construct(Config $config)
    {
        $this->cookieDomain = $config->get('cookie.domain', '');
    }

    /**
     * 允许跨域请求
     * @access public
     * @param Request $request
     * @param Closure $next
     * @param array   $header
     * @return Response
     */
    public function handle($request, Closure $next, ? array $header = [])
    {
        $refer=request()->header('Referer');
        if(isDebug()||$this->referCheck($refer)){
            $origin=request()->header('Origin','*');
            $this->header['Access-Control-Allow-Origin']=$origin;
            $this->header['Access-Control-Allow-Headers']=implode(", ",array_keys(request()->header()));
            $this->header['Access-Control-Allow-Methods']='GET, POST, OPTIONS, PATCH, PUT, DELETE';
            $this->header['Access-Control-Allow-Credentials']='true';
        }
        return $next($request)->header($this->header);
    }

    private function referCheck($refer){
        if(Basic::isEmpty($refer)){
            return true;
        }
        $urlinfo=pathinfo($refer);
        $base=$urlinfo['basename'];
        if(Basic::isEmpty($base)){
            return true;
        }
        if(substr_count(env('host'),$base)<1){
            return false;
        }
        return true;
    }
}

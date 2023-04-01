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

namespace iboxs\response;

use iboxs\Cookie;
use iboxs\Response;

/**
 * Html Response
 */
class Html extends Response
{
    /**
     * 输出type
     * @var string
     */
    protected $contentType = 'text/html';

    public function __construct(Cookie $cookie, $data = '', int $code = 200)
    {
        $this->init($data, $code);
        $this->cookie = $cookie;
    }
}

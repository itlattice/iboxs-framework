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
declare (strict_types = 1);

namespace iboxs\service;

use iboxs\Service;
use iboxs\Validate;

/**
 * 验证服务类
 */
class ValidateService extends Service
{
    public function boot()
    {
        Validate::maker(function (Validate $validate) {
            $validate->setLang($this->app->lang);
            $validate->setDb($this->app->db);
            $validate->setRequest($this->app->request);
        });
    }
}

<?php

namespace iboxs\captcha;

use iboxs\Route;
use iboxs\Service;
use iboxs\Validate;

class CaptchaService extends Service
{
    public function boot()
    {
        Validate::maker(function ($validate) {
            $validate->extend('captcha', function ($value) {
                return captcha_check($value);
            }, ':attribute错误!');
        });

        $this->registerRoutes(function (Route $route) {
            $route->get('captcha/[:config]', "\\iboxs\\captcha\\CaptchaController@index");
        });
    }
}

<?php

namespace iboxs\captcha\facade;

use iboxs\Facade;

/**
 * Class Captcha
 * @package iboxs\captcha\facade
 * @mixin \iboxs\captcha\Captcha
 */
class Captcha extends Facade
{
    protected static function getFacadeClass()
    {
        return \iboxs\captcha\Captcha::class;
    }
}

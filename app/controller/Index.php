<?php
namespace app\controller;

use app\BaseController;

class Index extends BaseController
{
    public function index()
    {
        return '<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:) </h1><p> IBoxsPHPFramework V' . \iboxs\facade\App::version() . '<br/><span style="font-size:30px;">初始测试版本发布</span></p><span style="font-size:25px;"></iboxs>';
    }

    public function hello($name = 'iboxsPHP6')
    {
        return 'hello,' . $name;
    }
}

# iboxs-view

iboxsPHP6.0 IBoxs-Template模板引擎驱动


## 安装

~~~php
composer require iboxs/iboxs-view
~~~

## 用法示例

本扩展不能单独使用，依赖iboxsPHP6.0+

首先配置config目录下的template.php配置文件，然后可以按照下面的用法使用。

~~~php

use iboxs\facade\View;

// 模板变量赋值和渲染输出
View::assign(['name' => 'iboxs'])
	// 输出过滤
	->filter(function($content){
		return str_replace('search', 'replace', $content);
	})
	// 读取模板文件渲染输出
	->fetch('index');


// 或者使用助手函数
view('index', ['name' => 'iboxs']);
~~~

具体的模板引擎配置请参考iboxs-template库。
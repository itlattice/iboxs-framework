<?php
use app\ExceptionHandle;
use app\Request;

// 容器Provider定义文件
return [
    'iboxs\Request'          => Request::class,
    'iboxs\exception\Handle' => ExceptionHandle::class,
];

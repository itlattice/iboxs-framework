<?php
declare (strict_types = 1);

namespace iboxs;

use ArrayAccess;

/**
 * 请求数据类
 * @package iboxs
 */
class PostData implements ArrayAccess
{
    protected $postdata;

    public function __get($name)
    {
        return $this->postdata[$name]??null;
    }

    public function __construct()
    {
        $this->postdata=request()->param();
    }

    public function offsetExists($key):bool
    {
        return isset($this->postdata[$key]);
    }
    
    public function offsetSet($key, $value):void
    {
        $this->postdata[$key] = $value;
    }
    
    public function offsetGet($key)
    {
        return $this->postdata[$key]??null;
    }
    
    public function offsetUnset($key):void
    {
        if(!isset($this->postdata[$key])) return;
        unset($this->postdata[$key]);
    }
}
<?php
namespace iboxs\convert;

trait ControllerAction{
    public function isGet(){
        return request()->isGet();
    }

    public function isPost(){
        return request()->isPost();
    }
}
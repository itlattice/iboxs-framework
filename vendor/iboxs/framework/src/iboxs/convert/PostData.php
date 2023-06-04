<?php

namespace iboxs\convert;

class PostData
{
    protected $postdata;

    public function __construct($postData){
        $this->postdata=$postData;
    }

    public function __get($name){
        if(isset($this->postdata[$name])){
            return $this->postdata[$name];
        } else{
            return null;
        }
    }
}

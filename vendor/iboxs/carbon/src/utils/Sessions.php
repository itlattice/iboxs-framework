<?php

namespace iboxs\carbon\utils;

trait Sessions
{
    public function AddSession($number=1){
        $time=strtotime($this->time);
        $this->time=date('Y-m-d H:i:s',$time+$number);
        return $this;
    }
}
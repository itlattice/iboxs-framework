<?php

namespace iboxs\carbon\utils;

trait Minutes
{
    public function AddMinuts($minuts=1){
        $time=strtotime($this->time);
        $str='';
        if($minuts>0){
            $str="+ {$minuts} minutes";
        } else{
            $str="- {$minuts} minutes";
        }
        $time=strtotime($str,$time);
        $this->time=date('Y-m-d H:i:s',$time);
        return $this;
    }
}
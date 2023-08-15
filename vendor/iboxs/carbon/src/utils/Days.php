<?php

namespace iboxs\carbon\utils;

trait Days
{
    public function AddDays($days=1){
        $time=strtotime($this->time);
        $str='';
        if($days>0){
            $str="+ {$days} days";
        } else{
            $str="- {$days} days";
        }
        $time=strtotime($str,$time);
        $this->time=date('Y-m-d H:i:s',$time);
        return $this;
    }
}
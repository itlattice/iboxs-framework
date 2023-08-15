<?php

namespace iboxs\carbon\utils;

trait Years
{
    public function AddYears($years=1){
        $time=strtotime($this->time);
        $str='';
        if($years>0){
            $str="+ {$years} years";
        } else{
            $str="- {$years} years";
        }
        $time=strtotime($str,$time);
        $this->time=date('Y-m-d H:i:s',$time);
        return $this;
    }
}
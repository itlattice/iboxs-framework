<?php

namespace iboxs\carbon\utils;

trait Month
{
    public function AddMonths($months=1){
        $time=strtotime($this->time);
        $str='';
        if($months>0){
            $str="+ {$months} months";
        } else{
            $str="- {$months} months";
        }
        $time=strtotime($str,$time);
        $this->time=date('Y-m-d H:i:s',$time);
        return $this;
    }
}
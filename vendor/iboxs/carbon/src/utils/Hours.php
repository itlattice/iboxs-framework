<?php

namespace iboxs\carbon\utils;

trait Hours
{
    public function AddHours($hours=1){
        $time=strtotime($this->time);
        $str='';
        if($hours>0){
            $str="+ {$hours} hours";
        } else{
            $str="- {$hours} hours";
        }
        $time=strtotime($str,$time);
        $this->time=date('Y-m-d H:i:s',$time);
        return $this;
    }
}
<?php
// +----------------------------------------------------------------------
// | iboxsPHP [ WE CAN DO IT JUST iboxs ]
// +----------------------------------------------------------------------
// | Copyright (c) 2023 http://lyweb.com.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: itlattice <notice@itgz8.com>
// +----------------------------------------------------------------------
declare (strict_types = 1);

namespace iboxs;
use iboxs\Model;
use iboxs\model\Collection;

class Transformer
{
    public function listHandle($list){
        $data=[];
        $active=false;
        if(is_array($list)){
            return $list;
        } else if(is_object($list)){
            $class=$list::class;
            if($class==Collection::class){
                foreach($list as $k=>$v){
                    $data[]=$this->transformer($v);
                }
                return $data;
            } else if(Model::class){
                $data=$this->transformer($list);
                return $data;
            }
        }
        foreach($list as $k=>$v){
            if(is_int($k)){
                $data[]=$this->transformer($v);
                $active=true;
                continue;
            }
            break;
        }
        if($active==false){
            $data=$this->transformer($list);
        }
        return $data;
    }

    public function transformer(Model $data){
        return $data->toArray();
    }
}
<?php
namespace iboxs\redis\operation;

class ListHandle extends BaseOperation
{
    /**
     * 将value值插入列表表头
     * @param string $key 键
     * @param mixed $value 插入的值
     * @param bool $is_new 是否在不存在时创建
     * @return false|int
     */
    public function lPush(string $key, $value, bool $is_new=true){
        $key=$this->operationKey($key);
        if(is_array($key)||is_object($value)){
            $value=serialize($value);
        }
        if($is_new) {
            return $this->handler->lPush($key, $value);
        } else{
            return $this->handler->lPushx($key,$value);
        }
    }

    /**
     * 只能将一个值value插入到列表key的表尾
     * @param string $key 键
     * @param mixed $value 值
     * @param bool $is_new 是否在不存在时创建
     * @return false|int
     */
    public function rPush(string $key, $value, bool $is_new=true){
        $key=$this->operationKey($key);
        if(is_array($value)||is_object($value)){
            $value=serialize($value);
        }
        if($is_new) {
            return $this->handler->rPush($key, $value);
        } else{
            return $this->handler->rPushx($key,$value);
        }
    }

    /**
     * 将值2插入到值1的后面（前面）
     * @param string $key 键
     * @param $value 值1
     * @param $new_value 值2
     * @param string $type 插入类型（after为后）
     * @return int
     */
    public function lInsert(string $key,$value,$new_value,$type=\Redis::AFTER){
        $key=$this->operationKey($key);
        return $this->handler->lInsert($key,$type,$value,$new_value);
    }

    /**
     * 取出列表的头元素，取出后该元素被删除
     * @param string $key 键
     * @return mixed 取出的元素
     */
    public function lPop(string $key){
        $key=$this->operationKey($key);
        $value=$this->handler->lPop($key);
        if($this->is_serialized($value)){
            return unserialize($value);
        }
        return $value;
    }

    /**
     * 取出列表的尾部元素，取出后该元素被删除
     * @param string $key 键
     * @return mixed 取出的元素
     */
    public function rPop(string $key){
        $key=$this->operationKey($key);
        $value=$this->rPop($key);
        if($this->is_serialized($value)){
            return unserialize($value);
        }
        return $value;
    }

    /**
     * 删，根据参数count的值，移除列表中与参数value相等的元素count=(0|-n表头向尾|+n表尾向头移除n个value)
     * @param string $key 键
     * @param $value 参数
     * @param int count 数量
     * @return bool|int 被移除的数量或false
     */
    public function rem(string $key,$value,int $count){
        $key=$this->operationKey($key);
        return $this->handler->lRem($key,$value,$count);
    }

    /**
     * 列表修剪，保留(start,end)之间的值
     * @param string $key
     * @param $start
     * @param $end
     * @return array|false
     */
    public function trim(string $key,$start,$end){
        $key=$this->operationKey($key);
        return $this->handler->lTrim($key,$start,$end);
    }

    /**
     * 表头数，将列表key下标为第index的元素的值为new_value
     * @param string $key 键
     * @param int $index 下标
     * @param mixed $new_value 新值
     * @return bool
     */
    public function lSet(string $key,int $index,$new_value){
        $key=$this->operationKey($key);
        if(is_array($new_value)||is_object($new_value)){
            $new_value=serialize($new_value);
        }
        return $this->handler->lSet($key,$index,$new_value);
    }

    /**
     * 返回列表key中，下标为index的元素
     * @param string $key
     * @param int $index
     * @return bool|mixed
     */
    public function index(string $key,int $index){
        $key=$this->operationKey($key);
        $value=$this->handler->lIndex($key,$index);
        if($this->is_serialized($value)){
            return unserialize($value);
        }
        return $value;
    }

    /**
     * 返回列表key中指定区间内的元素，区间以偏移量start和end指定
     * @param $key
     * @param $start
     * @param $end
     * @return array|mixed
     */
    public function range($key,$start,$end){
        $key=$this->operationKey($key);
        $list=$this->handler->lRange($key,$start,$end);
        $result=[];
        foreach ($list as $item) {
            if($this->is_serialized($item)){
                $result[]=unserialize($item);
            } else{
                $result=$item;
            }
        }
        return $result;
    }

    /**
     * 返回列表key的长度（不存在时返回0）
     * @param $key
     * @return bool|int
     */
    public function len($key)
    {
        $key = $this->operationKey($key);
        return $this->handler->lLen($key);
    }
}
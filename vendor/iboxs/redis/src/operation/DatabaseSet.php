<?php
namespace iboxs\redis\operation;

class DatabaseSet extends BaseOperation
{
    /**
     * 将多个元素(以数组形式)加入集合中
     * @param string $key
     * @param mixed $value
     * @return bool|int
     */
    public function add(string $key,...$value){
        $key=$this->operationKey($key);
        return $this->handler->sAddArray($key,$value);
    }

    /**
     * 将多个元素(以数组形式)加入集合中
     * @param string $key
     * @param array $value
     * @return bool|int
     */
    public function addArray(string $key,array $value){
        $key=$this->operationKey($key);
        return $this->handler->sAddArray($key,$value);
    }

    /**
     * 删除集合中的一个或多个元素
     * @param string $key 集合键
     * @param mixed $value 要删除的元素
     * @return false|int 被删除个数
     */
    public function rem(string $key,...$value){
        $key=$this->operationKey($key);
        $num=0;
        foreach ($value as $val) {
            $num+=$this->handler->sRem($key,$val);
        }
        return $num<1?false:$num;
    }

    /**
     * 返回集合中全部成员
     * @param string $key 集合键
     * @return array 所有成员
     */
    public function members(string $key): array
    {
        $key=$this->operationKey($key);
        return $this->handler->sMembers($key);
    }

    /**
     * 判断集合中是否含有value元素
     * @param string $key 集合键
     * @param mixed $value 值
     * @return bool 是否存在
     */
    public function in_set(string $key,$value): bool
    {
        $key=$this->operationKey($key);
        return $this->handler->sIsMember($key,$value);
    }

    /**
     * 从集合中随机取出几个元素(取出后即删除该元素)
     * @param string $key
     * @param int $count 取出个数
     * @return bool|mixed 取出的元素
     */
    public function Pop(string $key, int $count=1){
        $key=$this->operationKey($key);
        return $this->handler->sPop($key,$count);
    }

    /**
     * 从集合中随机取出一个元素（取出后不删除）
     * @param string $key
     * @param int $count 取出的个数
     * @return array|bool|mixed|string
     */
    public function randMember(string $key,int $count=1){
        $key=$this->operationKey($key);
        return $this->handler->sRandMember($key,$count);
    }

    /**
     * 返回所有给定集合的交集
     * @param string ...$key
     * @return array|false
     */
    public function inter(string ...$key){
        $new_key=[];
        foreach ($key as $k){
            $new_key[]=$this->operationKey($k);
        }
        return $this->handler->sInter(...$new_key);
    }

    /**
     * 返回所有给定集合的并集
     * @param string ...$key
     * @return array
     */
    public function union(string ...$key){
        $new_key=[];
        foreach ($key as $k){
            $new_key[]=$this->operationKey($k);
        }
        return $this->handler->sUnion(...$new_key);
    }

    /**
     * 返回所有给定集合的差集
     * @param string ...$key
     * @return array
     */
    public function diff(string ...$key){
        $new_key=[];
        foreach ($key as $k){
            $new_key[]=$this->operationKey($k);
        }
        return $this->handler->sDiff(...$new_key);
    }

    /**
     * 返回集合中元素的数量
     * @param string $key
     * @return int
     */
    public function count(string $key){
        $key=$this->operationKey($key);
        return $this->handler->sCard($key);
    }

    /**
     * 将$value元素从key集合中移入new_key集合中
     * @param $key
     * @param $new_key
     * @param $value
     * @return bool
     */
    public function move($key,$new_key,$value){
        $key=$this->operationKey($key);
        $new_key=$this->operationKey($new_key);
        return $this->handler->sMove($key,$new_key,$value);
    }
}
<?php
namespace iboxs\redis\operation;

class Basic extends BaseOperation
{
    /**
     * 查询生存时间
     * @param mixed $key 键
     * @return int 生存时间(单位秒),持久化的会返回-1，key不存在时返回-2
     */
    public function ttl($key){
        $key=$this->operationKey($key);
        return $this->handler->ttl($key);
    }

    /**
     * 写入键值对
     * @param mixed $key 键
     * @param mixed $value 值
     * @param int $time_out 过期时间(秒)
     */
    public function set($key,$value,$time_out=0){
        $key=$this->operationKey($key);
        if(is_array($value)||is_object($value)){
            $value=serialize($value);
        }
        return $this->handler->set($key,$value,$time_out==0?null:$time_out);
    }

    /**
     * 设置键的过期时间
     * @param mixed $key 键
     * @param int $time_out 过期时间(秒)
     */
    public function expire($key,$time_out){
        $key=$this->operationKey($key);
        return $this->handler->expire($key,$time_out);
    }

    /**
     * 写入键值对（具体过期时间）
     * @param mixed $key 键
     * @param mixed $value 值
     * @param int $expire 过期时间(Unix时间戳)
     */
    public function time_set($key,$value,$expire){
        $key=$this->operationKey($key);
        if(is_array($value)||is_object($value)){
            $value=serialize($value);
        }
        if($expire<time()){
            return false;
        }
        $this->handler->set($key,$value,20);
        return $this->handler->expireAt($key,$expire);
    }

    /**
     * 批量写入Redis
     * @param array $array 写入的数据字典
     * @return bool 成功返回true
     */
    public function mset(array $array){
        $arr=[];
        foreach ($array as $key=>$value) {
            $key=$this->operationKey($key);
            if(is_array($value)||is_object($value)){
                $arr[$key]=serialize($value);
            } else{
                $arr[$key]=$value;
            }
        }
        return $this->handler->mset($arr);
    }

    /**
     * 若不存在时写入
     */
    public function setnx($key,$value){
        $key=$this->operationKey($key);
        return $this->handler->setnx($key,$value);
    }

    /**
     * 读取Redis
     * @param string $key 键
     * @param mixed|null $default 默认值（无此键值返回的值）
     * @return mixed|null 获取到的值
     */
    public function get(string $key,mixed $default=null){
        $key=$this->operationKey($key);
        $value=$this->handler->get($key);
        if($value===false){  //不存在
            return $default;
        }
        if($this->is_serialized($value)){
            $value=unserialize($value);
        }
        return $value;
    }

    /**
     * 批量获取Redis存储的值
     * @param string|array $key_arr 键或键的数组
     * @return array 所有被查询的值数组
     */
    public function mget($key_arr){
        $key=[];
        foreach ($key_arr as $item) {
            $key[]=$this->operationKey($item);
        }
        return $this->handler->mGet($key);
    }

    /**
     * 删除键值
     * @param array|string $key 键值（多个时以数组传入）
     */
    public function del($key){
        if(is_array($key)){
            foreach ($key as $item) {
                $this->handler->del($item);
            }
            return true;
        }
        $key=$this->operationKey($key);
        return $this->handler->del($key);
    }

    /**
     * 先获取值，再写入新值
     */
    public function getset($key,$value,$default=null){
        $key=$this->operationKey($key);
        $result=$this->handler->getset($key,$value);
        if($result==false){
            $this->handler->set($key,$value);
            return $default;
        }
        return $result;
    }

    /**
     * 获取键的长度
     * @param string $key 键
     * @return int 键的长度
     */
    public function strlen(string $key){
        $key=$this->operationKey($key);
        return $this->handler->strlen($key);
    }

    /**
     * 把string追加到key现有的value中
     * @param string $key 键
     * @param string $string 追加的字符串
     * @return int 追加后的个数
     */
    public function append(string $key,string $string){
        $key=$this->operationKey($key);
        return $this->handler->append($key,$string);
    }

    /**
     * 自增,不存在为赋值,值需为整数
     * @param string $key 键
     * @param int $step 步长，不存在时赋值该值
     * @return int 结果
     */
    public function inc(string $key,int $step=1){
        $key=$this->operationKey($key);
        return $this->handler->incrBy($key,$step);
    }


    /**
     * 获取所有键名
     * @param string $key 键
     * @return array|Redis
     */
    public function keys(string $key){
        $key=$this->operationKey($key);
        return $this->handler->keys($key);
    }

    /**
     * 自减
     * @param string $key 键
     * @param int $step 步长
     * @return int
     */
    public function dec(string $key,int $step=1){
        $key=$this->operationKey($key);
        return $this->handler->decrBy($key,$step);
    }

    /**
     * 检索键名（*为遍历所有键名）
     * @param string $key 查询的键(本操作前缀无效)
     * @return array 遍历结果
     */
    public function key(string $key='*'){
        return $this->handler->keys($key);
    }

    /**
     * 移除键的失效时间
     * @param string $key
     * @return bool|int
     */
    public function persist(string $key){
        $key=$this->operationKey($key);
        return $this->handler->persist($key);
    }

    public function exists($key){
        $key=$this->operationKey($key);
        return $this->handler->exists($key);
    }
}
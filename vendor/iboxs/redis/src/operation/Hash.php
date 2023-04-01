<?php
namespace iboxs\redis\operation;

class Hash extends BaseOperation
{
    /**
     * 将哈希表key中的域field的值设为value,不存在创建，存在时覆盖
     * @param string $key
     * @param string $field
     * @param $value
     * @return bool|int
     */
    public function set(string $key,string $field,$value){
        $key=$this->operationKey($key);
        return $this->handler->hSet($key,$field,$value);
    }

    /**
     * 取值
     * @param string $key
     * @param string $field
     * @param mixed $default 默认值（无值时返回）
     * @return mixed
     */
    public function get(string $key,string $field,$default=null){
        $key=$this->operationKey($key);
        $value=$this->handler->hGet($key,$field);
        if($value===false){
            return $default;
        }
        return $value;
    }

    /**
     * 批量写入Hash表值
     * @param string $key
     * @param array $arr
     * @return bool
     */
    public function mSet(string $key,array $arr){
        $key=$this->operationKey($key);
        return $this->handler->hMSet($key,$arr);
    }

    /**
     * 批量取值(多个hashkey)
     * @param string $key
     * @param array $fields
     * @return array
     */
    public function mGet(string $key,array $fields){
        $key=$this->operationKey($key);
        return $this->handler->hMGet($key,$fields);
    }

    /**
     * 返回hash表key中的所有域所有值
     * @param string $key
     * @return array
     */
    public function getAll(string $key){
        $key=$this->operationKey($key);
        return $this->handler->hGetAll($key);
    }

    /**
     * 返回哈希表key中的所有域
     * @param string $key
     * @return array
     */
    public function keys(string $key){
        $key=$this->operationKey($key);
        return $this->handler->hKeys($key);
    }

    /**
     * 返回哈希表key中的所有值
     * @param string $key
     * @return array
     */
    public function vals(string $key){
        $key=$this->operationKey($key);
        return $this->handler->hVals($key);
    }

    /**
     * 删除指定下标的field,不存在的域将被忽略
     * @param string $key
     * @param $fields
     * @return bool|int
     */
    public function del(string $key,$fields){
        $key=$this->operationKey($key);
        return $this->handler->hDel($key,$fields);
    }

    /**
     * 查看hash中是否存在field
     * @param string $key
     * @param string $field
     * @return bool
     */
    public function exists(string $key,string $field){
        $key=$this->operationKey($key);
        return $this->handler->hExists($key,$field);
    }

    /**
     * 哈希表key中的域field的值加上量
     * @param string $key
     * @param string $field
     * @param $num
     * @return int
     */
    public function incrby(string $key,string $field,$num){
        $key=$this->operationKey($key);
        return $this->handler->hIncrBy($key,$field,$num);
    }

    /**
     * 返回哈希表key中域的数量
     * @param string $key
     * @return false|int
     */
    public function len(string $key){
        $key=$this->operationKey($key);
        return $this->handler->hLen($key);
    }
}
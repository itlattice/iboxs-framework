<?php
namespace iboxs\redis\operation;

class sysMatic extends BaseOperation
{
    /**
     * 返回当前库中的key的个数
     * @return int
     */
    public function size(){
        return $this->handler->dbSize();
    }

    /**
     * 清空整个Redis
     * @return bool
     */
    public function flushAll(){
        return $this->handler->flushAll();
    }

    /**
     * 清空redis库（默认为当前库）
     * @param int $select 要清空的库
     * @return bool
     */
    public function flushDb(int $select=-1){
        if($select>15){
            $select=$select%16;
        }
        if($select==-1) {
            $select = $this->config['select'] ?? 0;
        } else{
            $this->handler->select($select);
        }
        return $this->handler->flushDb();
    }

    /**
     * 同步把数据存储到磁盘
     * @return bool
     */
    public function save(){
        return $this->handler->save();
    }

    /**
     * 异步把数据存储到磁盘
     * @return bool
     */
    public function bgSave(){
        return $this->handler->bgsave();
    }

    /**
     * 查询当前redis的状态
     * @param $option
     * @return array
     */
    public function info($option=null){
        return $this->handler->info($option);
    }

    /**
     * 上次存储时间key的时间(Unix)
     * @return int
     */
    public function lastSave(){
        return $this->handler->lastSave();
    }

    /**
     * 监视一个(或多个) key ，如果在事务执行之前这个(或这些) key 被其他命令所改动，那么事务将被打断
     * @param ...$key
     * @return void
     */
    public function watch(...$key){
        $this->handler->watch(...$key);
    }

    /**
     * 取消监视一个(或多个) key
     * @param ...$key
     * @return void
     */
    public function unwatch(...$key)
    {
        $this->handler->unwatch(...$key);
    }

    /**
     * 开启事务，事务块内的多条命令会按照先后顺序被放进一个队列当中，最后由 EXEC 命令在一个原子时间内执行
     * @param $int
     * @return \Redis
     */
    public function multi($int=\Redis::MULTI){
        return $this->handler->multi($int);
    }

    /**
     * 开启管道，事务块内的多条命令会按照先后顺序被放进一个队列当中，最后由 EXEC 命令在一个原子时间内执行。
     * @param $int
     * @return \Redis
     */
    public function pipeline($int=\Redis::PIPELINE){
        return $this->handler->multi($int);
    }

    /**
     * 执行所有事务块内的命令
     * @return array|void
     */
    public function exec(){
        return $this->handler->exec();
    }
}
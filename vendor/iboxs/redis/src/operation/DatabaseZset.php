<?php
namespace iboxs\redis\operation;

class DatabaseZset extends BaseOperation
{
    /**
     * 将一个或多个member元素及其score值加入到有序集key当中
     * @param string $key
     * @param $options
     * @param $score1
     * @param $value1
     * @param $score2
     * @param $value2
     * @param $scoreN
     * @param $valueN
     * @return int
     */
    public function add(string $key, $options, $score1, $value1 = null, $score2 = null, $value2 = null, $scoreN = null, $valueN = null)
    {
        $key = $this->operationKey($key);
        return $this->handler->zAdd($key, $options, $score1, $value1, $score2, $value2, $scoreN, $valueN);
    }

    /**
     * 删除有序集合中的一个或多个成员
     * @param string $key
     * @param ...$member
     * @return int 被删个数
     */
    public function rem(string $key, ...$member)
    {
        $key = $this->operationKey($key);
        $i = 0;
        $members = [];
        foreach ($member as $item) {
            if ($i == 0) continue;
            $members[] = $item;
            $i++;
        }
        return $this->handler->zRem($key, $member[0], ...$members);
    }

    /**
     * 通过值反拿权
     * @param string $key 集合键
     * @param mixed $member 元素
     * @return bool|float
     */
    public function score(string $key, $member)
    {
        $key = $this->operationKey($key);
        return $this->handler->zScore($key, $member);
    }

    /**
     * 返回有序集key中，【指定区间内】的成员
     * @param string $key
     * @param int $start
     * @param int $end
     * @param $withscores
     * @return array|null
     */
    public function range(string $key, int $start, int $end, $withscores = null)
    {
        $key = $this->operationKey($key);
        return $this->handler->zRange($key, $start, $end, $withscores);
    }

    /**
     * 拿member值，返回有序集key中，【指定区间内】的成员
     * @param string $key
     * @param int $start
     * @param int $end
     * @return array
     */
    public function revRange(string $key, int $start, int $end,$withScore=true)
    {
        $key = $this->operationKey($key);
        return $this->handler->zRevRange($key, $start, $end,$withScore);
    }

    /**
     * 返回有序集key中，指定区间内的(从大到小排)成员
     * @param $key
     * @param int $start
     * @param int $end
     * @return array
     */
    public function rangByScore($key, int $start, int $end)
    {
        $key = $this->operationKey($key);
        return $this->handler->zRangeByScore($key, $start, $end);
    }

    /**
     * 返回有序集key中，指定区间内的(从大到小排)成员
     * @param $key
     * @param int $start
     * @param int $end
     * @return false|int|Redis
     */
    public function ZUnionStore($key,array $keys)
    {
        $key = $this->operationKey($key);
        $resultKeys=[];
        foreach($keys as $k){
            $resultKeys[]=$this->operationKey($k);
        }
        return $this->handler->zUnionStore($key, $resultKeys);
    }

    /**
     * 查(score从小到大)排名结果中member排序名次
     * @param string $key
     * @param mixed $member
     * @return false|int
     */
    public function rank(string $key, $member)
    {
        $key = $this->operationKey($key);
        return $this->handler->zRank($key, $member);
    }

    /**
     * 查(score从大到小)排名结果中的【member排序名次】
     * @param string $key
     * @param $member
     * @return false|int
     */
    public function revRank(string $key, $member)
    {
        $key = $this->operationKey($key);
        return $this->handler->zRevRank($key, $member);
    }

    /**
     * 交集（前缀无效）
     * @param $output
     * @param $zSetKeys
     * @param array|null $weights
     * @param $aggregateFunction
     * @return int
     */
    public function inter($output, $zSetKeys, array $weights = null, $aggregateFunction = 'SUM')
    {
        return $this->handler->zInterStore($output, $zSetKeys, $weights, $aggregateFunction);
    }

    /**
     * 差集（前缀无效）
     * @return int
     */
    public function diff($output, $zSetKeys, array $weights = null, $aggregateFunction = 'SUM')
    {
        return $this->handler->zUnionStore($output, $zSetKeys, $weights, $aggregateFunction);
    }

    /**
     * 返回集合的元素数量
     * @param string $key 集合key
     * @return int
     */
    public function card(string $key)
    {
        $key = $this->operationKey($key);
        return $this->handler->zCard($key);
    }

    /**
     * score值在min和max之间(默认包括score值等于min或max)的成员
     * @param string $key
     * @param float $min
     * @param float $max
     * @return int
     */
    public function count(string $key, float $min, float $max)
    {
        $key = $this->operationKey($key);
        return $this->handler->zCount($key, $min, $max);
    }

    /**
     * 返回或保存给定列表、集合、有序集合key中经过排序的元素
     * @param $key
     * @param $array
     * @return array
     */
    public function sort($key, $array=null)
    {
        $key = $this->operationKey($key);
        return $this->handler->sort($key, [
            'limit' => array(0, 10),
            'sort' => 'desc'
        ]);
    }

    /**
     * 有序列表score自增
     */
    public function inc(string $key, $value,$member){
        $key = $this->operationKey($key);
        $this->handler->zIncrBy($key, $value,$member);
    }
}
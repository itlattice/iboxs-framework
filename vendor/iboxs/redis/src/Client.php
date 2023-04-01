<?php
/**
 * Redis operation starts from here
 * @author  zqu zqu1016@qq.com
 */
namespace iboxs\redis;

use iboxs\redis\operation\{Basic,ListHandle,sysMatic,DatabaseSet,DatabaseZset,Hash};
use iboxs\redis\common\BaseCommon;

class Client extends BaseCommon
{
    /**
     * 基础操作
     */
    public function basic(): Basic
    {
        return (new Basic());
    }

    /**
     * redis软件系统操作
     */
    public function sysmatic(): sysMatic
    {
        return (new sysMatic());
    }

    /**
     * 列表操作
     */
    public function list(): ListHandle
    {
        return (new ListHandle());
    }

    /**
     * 数据集合操作
     */
    public function Set(): DatabaseSet
    {
        return (new DatabaseSet());
    }

    /**
     * 有序集合操作
     */
    public function Zset(): DatabaseZset
    {
        return (new DatabaseZset());
    }

    /**
     * Hash表操作
     */
    public function hash(): Hash
    {
        return (new Hash());
    }
}
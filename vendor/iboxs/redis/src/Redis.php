<?php

namespace iboxs\redis;

use iboxs\redis\common\Base;
use iboxs\redis\operation\{Basic,ListHandle,sysMatic,Hash,DatabaseZset,DatabaseSet};

class Redis extends Base
{
    public static function basic(): Basic
    {
        $config=self::getConfig();
        $client=new Client($config);
        return $client->basic();
    }

    /**
     * redis软件系统操作
     */
    public static function sysmatic()
    {
        $config=self::getConfig();
        $client=new Client($config);
        return $client->sysmatic();
    }

    /**
     * 列表操作
     */
    public static function list(): ListHandle
    {
        $config=self::getConfig();
        $client=new Client($config);
        return $client->list();
    }

    /**
     * 数据集合操作
     */
    public static function Set(): DatabaseSet
    {
        $config=self::getConfig();
        $client=new Client($config);
        return $client->Set();
    }

    /**
     * 有序集合操作
     */
    public static function Zset(): DatabaseZset
    {
        $config=self::getConfig();
        $client=new Client($config);
        return $client->Zset();
    }

    /**
     * Hash表操作
     */
    public static function hash(): Hash
    {
        $config=self::getConfig();
        $client=new Client($config);
        return $client->hash();
    }

    /**
     * 快速获取键值
     * @param $key
     * @param $default
     */
    public static function get($key,$default=null)
    {
        return self::basic()->get($key,$default);
    }

    /**
     * 快速写入键值
     * @param $key
     * @param $value
     * @param $extire
     */
    public static function write($key,$value,$time_out=0)
    {
        return self::basic()->set($key,$value,$time_out);
    }

    private static function getConfig(){
        if(function_exists('config')){
            $config=config('redis');
        } else{
            $config=(new self())->config;
        }
        return $config;
    }
}

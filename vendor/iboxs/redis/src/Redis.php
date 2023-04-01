<?php

namespace iboxs\redis;

use iboxs\redis\common\Base;
use iboxs\redis\operation\{Basic,ListHandle,sysMatic,Hash,DatabaseZset,DatabaseSet};

class Redis extends Base
{
    public static function basic(): Basic
    {
        if(function_exists('config')){
            $config=config('redis');
        } else{
            $config=(new self())->config;
        }
        $client=new Client($config);
        return $client->basic();
    }

    /**
     * redis软件系统操作
     */
    public static function sysmatic()
    {
        if(function_exists('config')){
            $config=config('redis');
        } else{
            $config=(new self())->config;
        }
        $client=new Client($config);
        return $client->sysmatic();
    }

    /**
     * 列表操作
     */
    public static function list(): ListHandle
    {
        if(function_exists('config')){
            $config=config('redis');
        } else{
            $config=(new self())->config;
        }
        $client=new Client($config);
        return $client->list();
    }

    /**
     * 数据集合操作
     */
    public static function Set(): DatabaseSet
    {
        if(function_exists('config')){
            $config=config('redis');
        } else{
            $config=(new self())->config;
        }
        $client=new Client($config);
        return $client->Set();
    }

    /**
     * 有序集合操作
     */
    public static function Zset(): DatabaseZset
    {
        if(function_exists('config')){
            $config=config('redis');
        } else{
            $config=(new self())->config;
        }
        $client=new Client($config);
        return $client->Zset();
    }

    /**
     * Hash表操作
     */
    public static function hash(): Hash
    {
        if(function_exists('config')){
            $config=config('redis');
        } else{
            $config=(new self())->config;
        }
        $client=new Client($config);
        return $client->hash();
    }
}
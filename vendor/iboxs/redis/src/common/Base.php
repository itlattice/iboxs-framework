<?php

namespace iboxs\redis\common;

use Redis;

class Base
{
    use Helper;

    protected $config=[
        'host'=>'127.0.0.1', //IP Address
        'port'=>6379, //Port
        'password'=>'',
        'expire'=>0,  //Expiration time
        'time_out'=>0,
        'prefix'=>'', //前缀
        'select'=>0  //选择的库(一般有16个库)
    ];

    /**
     * 键的处理
     * @param string $key 键
     * @param string $prefix 前缀
     * @return string 新键
     */
    public function operationKey($key,$prefix=''){
        if($prefix==''){
            $prefix=$this->config['prefix']??'';
        }
        return $prefix.$key;
    }

    /**
     * @var \Redis
     */
    public $handler;

    /**
     * @param $select
     * @param $config
     */
    public function __construct($config=[])
    {
        $this->config['host']=$config['host']??$this->config['host'];
        $this->config['port']=$config['port']??$this->config['port'];
        $this->config['prefix']=$config['prefix']??$this->config['prefix'];
        $this->config['expire']=$config['expire']??$this->config['expire'];
        if(!class_exists('Redis')){
            exit('No Redis EXT');
        }
        $this->handler=new \Redis();
        $this->handler->connect('127.0.0.1', 6379,$this->config['time_out']);
        if($this->config['password']!=''){
            $this->handler->auth($this->config['password']);
        }
        $this->handler->select($this->config['select']);
    }
}
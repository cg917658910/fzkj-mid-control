<?php

namespace app\common\service;

use think\Env;

class Redis
{
    protected $redis;
    /**
     * Redis constructor.
     */
    public function __construct()
    {
        //if( !$this->redis ) {
        $redis = new \Redis();
        $redis->connect(Env::get('redis.host'), Env::get('redis.port'), 20);
        if (!empty(Env::get('redis.password'))) {
            $redis->auth(Env::get('redis.password')); //密码验证
        }
        $redis->select(Env::get('redis.select'));//选择数据库
        //$redis->save();
        $this->redis = $redis;
        // }
        return $redis;
    }

    /**
     * @param $key
     * @param $hashKey
     * @return string
     */
    public function get($key,$hashKey){
        return $this->redis->hGet($key,$hashKey);
    }

    /**
     * @param $key
     * @param $hashKey
     * @param $value
     */
    public function set($key,$hashKey,$value){
        return $this->redis->hSet($key,$hashKey,$value);
    }

    /**
     * @param $key
     * @param $hashKey
     */
    public function del($key,$hashKey){
        $this->redis->hDel($key,$hashKey);
    }

    public function get_redis_obj(){
        return $this->redis;
    }
}
<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

namespace think;

class Env
{
    /**
     * 获取环境变量值
     * @access public
     * @param  string $name    环境变量名（支持二级 . 号分割）
     * @param  string $default 默认值
     * @return mixed
     */
    public static function get($name, $default = null)
    {
        $keyArr = explode('.',$name);
        if( empty( $keyArr[0] ) || empty( $keyArr[1] ) ){
            return $default;
        }
        require APP_PATH.'/env.php';
        if( isset( $env_config[$keyArr[0]][$keyArr[1]] ) ){
            return $env_config[$keyArr[0]][$keyArr[1]];
        }else{
            return $default;
        }
    }
}

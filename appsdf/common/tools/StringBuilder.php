<?php

namespace app\common\tools;

use app\common\content\RedisText;
use app\common\service\Redis;
use think\Env;
use think\Session;

class StringBuilder
{

    protected $aes_str='';

    public function __construct()
    {
        $this->aes_str = Env::get('app.aes_key');
    }

    /**
     * aes解密，服务器存储数据用
     * @param $secretData
     * @return string
     */
    protected function aes_decode($secretData) {
        $secretData = hex2bin($secretData);
        $secretData=str_replace(' ','+',$secretData);
        $api_key=substr($this->aes_str,0,16);
        $api_iv=substr($this->aes_str,16);
        return openssl_decrypt($secretData, 'aes-128-cbc', $api_key, false, substr($api_iv, 0 , 16));
    }

    /**解密
     * @param $str
     * @return mixed|string
     */
    public function decode($str){
        $str = $this->aes_decode($str);
        $arr = explode('_',$str);
        if( empty( $arr[0] ) || empty( $arr[1] ) ){
            $admin = session::get('admin');
            $Redis = new Redis();
            session(null);
            $Redis->del('admin_login_time', $admin['pkusa']);
            $Redis->del('admin_info', $admin['pkusa']);
            return 0;
        }
        return $arr[1];
    }

    /**
     * aes加密字符串，服务器存储数据用
     * @param $data
     * @return string
     */
    public function aes_encode($data) {
        $api_key=substr($this->aes_str,0,16);
        $api_iv=substr($this->aes_str,16);
        $encrypt = openssl_encrypt($data, 'aes-128-cbc', $api_key, false, substr($api_iv, 0 , 16));
        return bin2hex($encrypt);
    }
}
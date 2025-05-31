<?php

namespace app\common\model\log;

use think\Model;

class LoginLogModel extends Model
{
    protected $name = 'usr_login_log';

    /**添加登录日志
     * @param $data
     */
    public function add_log($data){
        $this->insert($data);
    }
}
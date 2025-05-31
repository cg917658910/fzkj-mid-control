<?php

namespace app\common\model\system;

use app\common\model\BaseModel;
use app\common\service\Redis;
use app\common\tools\StringBuilder;
use think\Model;

/**
 * Class SystemAdminModel
 * @package app\common\model\system
 */
class SystemAdminModel extends BaseModel
{
    protected $name = 'usr_system_admin';


    public function searchTypeAttr($query, $value, $data)
    {
        $value && $query->where('type', intval($value));
    }

    //获取管理员的基本信息
    public function adminInfo($where)
    {
        $data = $this->where($where)->find();
        if (!empty($data['pkusa'])) {
            $data = $data->toArray();
        }
        return $data;
    }

    /**获取列表
     * @param $where
     * @param $field
     * @return bool|false|\PDOStatement|string|\think\Collection
     */
    public function get_list($where, $field)
    {
        $StringBuilder = new StringBuilder();
        $data =  $this->where($where)->field($field)->select();
        foreach ($data as &$item) {
            $item['uid'] = $StringBuilder->aes_encode('admin_' . $item['pkusa']);
        }
        return $data;
    }

    /**修改登录密码
     * @param $uid
     * @param $pass
     * @return bool
     */
    public function update_login_pass($uid, $pass)
    {
        $up = $this->where('pkusa', $uid)->update(['admin_pass' => $pass]);
        if ($up) {
            $this->del_redis($uid);
            return true;
        } else {
            return false;
        }
    }

    /**删除redis存储的信息
     * @param $uid
     */
    public function del_redis($uid)
    {
        (new Redis())->del('admin_info', $uid);
    }
}

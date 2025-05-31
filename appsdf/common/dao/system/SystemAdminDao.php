<?php

namespace app\common\dao\system;

use app\common\dao\BaseDao;
use app\common\model\BaseModel;
use app\common\model\system\SystemAdminModel;
use think\Model;

class SystemAdminDao extends BaseDao
{
    protected $model;
    protected $search = ['type'];
    public function __construct()
    {
        $this->setModel();
    }

    protected function setModel()
    {
        $this->model = new SystemAdminModel();
    }
    protected function getModel(): BaseModel
    {
        return $this->model;
    }
    public function findByUserName(string $username)
    {
        return $this->model->adminInfo(['md_admin_user' => bin2hex($username), 'isDelete' => 1]);
    }
    public function findByID(int $uid)
    {
        return $this->model->where('pkusa', $uid)->find();
    }
    public function updateGoogleKey(int $uid, string $googleKey)
    {
        // TODO: 考虑是否覆盖key的问题
        return $this->model->where('pkusa', '=', $uid)->update([
            'googlekey' => $googleKey,
        ]);
    }
}

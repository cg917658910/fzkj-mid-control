<?php

namespace app\common\dao\system;

use app\common\dao\BaseDao;
use app\common\model\BaseModel;
use app\common\model\system\SystemConfigModel;
use think\Model;

class SystemConfigDao
{
    protected $model;
    public function __construct()
    {
        $this->setModel();
    }

    protected function setModel()
    {
        $this->model = new SystemConfigModel();
    }

    public function getById($id)
    {
        $data = $this->model->where('pkbsc', $id)->find();
        return $data['value'] ?? null;
    }
    public function getByConfigKey(string $key)
    {
        if (!$key) {
            return null;
        }
        $data = $this->model->where('en_title', $key)->find();
        return $data['value'] ?? null;
    }
}

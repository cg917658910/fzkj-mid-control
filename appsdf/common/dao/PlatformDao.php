<?php

namespace app\common\dao;

use app\common\dao\BaseDao;
use app\common\model\BaseModel;
use app\common\model\PlatformModel;
use think\Model;

class PlatformDao extends BaseDao
{
    protected $model;
    protected $search = [];
    public function __construct()
    {
        $this->setModel();
    }

    protected function setModel()
    {
        $this->model = new PlatformModel();
    }
    protected function getModel(): BaseModel
    {
        return $this->model;
    }
}

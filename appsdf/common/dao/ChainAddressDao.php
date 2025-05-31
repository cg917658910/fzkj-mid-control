<?php

namespace app\common\dao;

use app\common\dao\BaseDao;
use app\common\model\BaseModel;
use app\common\model\ChainAddressModel;
use think\Model;

class ChainAddressDao extends BaseDao
{
    protected $model;
    protected $search = [];
    public function __construct()
    {
        $this->setModel();
    }

    protected function setModel()
    {
        $this->model = new ChainAddressModel();
    }
    protected function getModel(): BaseModel
    {
        return $this->model;
    }
}

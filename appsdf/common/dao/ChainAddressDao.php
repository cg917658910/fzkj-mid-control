<?php

namespace app\common\dao;

use app\common\dao\BaseDao;
use app\common\model\BaseModel;
use app\common\model\ChainAddressModel;
use think\Model;

class ChainAddressDao extends BaseDao
{
    protected $model;
    protected $search = ['network_id', 'address'];
    public function __construct()
    {
        $this->setModel();
    }

    protected function setModel()
    {
        $this->model = ChainAddressModel::class;
    }
    protected function getModel(): BaseModel
    {
        return new $this->model;
    }
}

<?php

namespace app\common\dao;

use app\common\dao\BaseDao;
use app\common\model\BaseModel;
use app\common\model\ChainNetworkModel;
use think\Model;

class ChainNetworkDao extends BaseDao
{
    protected $model;
    protected $search = [];
    public function __construct()
    {
        $this->setModel();
    }

    protected function setModel()
    {
        $this->model = new ChainNetworkModel();
    }
    protected function getModel(): BaseModel
    {
        return $this->model;
    }
}

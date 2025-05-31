<?php

namespace app\common\dao{namespace};

use app\common\dao\BaseDao;
use app\common\model\BaseModel;
use app\common\model\{name}Model;
use think\Model;

class {name}Dao extends BaseDao
{
    protected $model;
    protected $search = [];
    public function __construct()
    {
        $this->setModel();
    }

    protected function setModel()
    {
        $this->model = new {name}Model();
    }
    protected function getModel(): BaseModel
    {
        return $this->model;
    }
}

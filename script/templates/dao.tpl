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
        $this->model = {name}Model::class;
    }
    protected function getModel(): BaseModel
    {
        return new $this->model;
    }
}

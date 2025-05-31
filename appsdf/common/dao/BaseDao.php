<?php

namespace app\common\dao;

use app\common\model\BaseModel;
use app\common\types\QueryParams;

abstract class BaseDao
{
    protected $model;
    protected $search = [];
    abstract protected function setModel();
    abstract protected function getModel(): BaseModel;
    public function __construct() {}

    public function getList(QueryParams $queryParams)
    {
        $page = $queryParams->getPage();
        $limit = $queryParams->getLimit();
        $field = $queryParams->getField();
        $model = $this->getModel()->withSearch($this->search, $queryParams->getParams())->field($field);
        if ($page > 0) return $model->paginate(['page' => $page, 'list_rows' => $limit])->toArray();
        return $model->select();
    }
}

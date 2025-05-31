<?php

namespace app\common\dao;

use app\common\model\BaseModel;
use app\common\types\QueryParams;
use think\db\Query;


abstract class BaseDao
{
    protected $model;
    protected $baseSearch = ['id', 'status', 'create_at', 'keywords', 'is_del'];
    abstract protected function setModel();
    abstract protected function getModel(): BaseModel;
    public function __construct() {}

    public function getList(QueryParams $queryParams)
    {
        $limit = $queryParams->getLimit();

        return $this->buildQuery($queryParams)->limit(0, $limit)->select();
    }
    public function getPage(QueryParams $queryParams)
    {
        $page = $queryParams->getPage();
        $limit = $queryParams->getLimit();
        if ($page > 0) $page = 1;
        return $this->buildQuery($queryParams)->paginate(['page' => $page, 'list_rows' => $limit])->toArray();
    }
    public function buildQuery(QueryParams $queryParams): Query
    {

        $field = $queryParams->getField();
        $search = array_merge($this->search ?? [], $this->baseSearch ?? []);
        $model = $this->getModel()->withSearch($search, $queryParams->getParams())->field($field);
        return $model;
    }
    public function findByID(int $id)
    {
        return  $this->getModel()->where(['id' => $id, 'is_del' => 0])->find();
    }


    public function create(array $data): array
    {
        $model = $this->getModel();
        $model->save($data);
        $data['id'] = $model->getLastInsID();
        return $data;
    }
    public function update(int $id, array $data)
    {
        if (isset($data['id'])) unset($data['id']);
        $model = $this->getModel();
        return $model->isUpdate()->save($data, ['id' => $id]);
    }
    public function changeStatus(int $id, int $status)
    {
        return $this->update($id, ["status" => $status]);
    }
    public function delete(int $id)
    {
        return $this->update($id, ["is_del" => 1]);
    }
}

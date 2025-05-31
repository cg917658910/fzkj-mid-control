<?php

namespace app\common\traits;

use app\common\enum\CodeEnum;
use app\common\exception\ApiException;
use app\common\types\QueryParams;

trait RequestTraits
{
    protected function initialize()
    {
        if (property_exists($this, 'exceptPath') && \in_array(request()->action(), (array) $this->exceptPath)) {
            throw new ApiException(CodeEnum::FORBIDDEN, "不允许的操作");
        }
    }
    public function list()
    {
        $this->validateRequest();
        $params = request()->param();
        $queryParams = new QueryParams($params);
        $data  = $this->service->getList($queryParams);
        return jsonSuccess($data);
    }
    public function page()
    {
        $this->validateRequest();
        $params = request()->param();
        $queryParams = new QueryParams($params);
        $data  = $this->service->getPage($queryParams);
        return jsonSuccess($data);
    }
    public function find(int $id)
    {
        $this->validateRequest();
        $data = $this->service->find($id);
        return jsonSuccess($data);
    }
    public function delete(int $id)
    {
        $this->validateRequest();
        $result = $this->service->delete($id);
        return jsonSuccess($result);
    }
    public function create()
    {
        $this->validateRequest();
        $data = request()->post();
        $result = $this->service->create($data);
        return jsonSuccess($result);
    }
    public function update()
    {
        $this->validateRequest();
        $data = request()->post();
        $id = $data['id'];
        $result = $this->service->update($id, $data);
        return jsonSuccess($result);
    }
    public function changeStatus()
    {
        $this->validateRequest('changeStatus');
        $data = request()->post();
        $id = $data['id'];
        $status = $data['status'];
        $result = $this->service->changeStatus($id, $status);
        return jsonSuccess($result);
    }
}

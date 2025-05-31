<?php

namespace app\common\traits;

use app\common\types\QueryParams;

trait RequestTraits
{
    public function list()
    {
        $params = request()->param();
        $queryParams = new QueryParams($params);
        $data  = $this->service->getList($queryParams);
        return jsonSuccess($data);
    }
    public function page()
    {
        $params = request()->param();
        $queryParams = new QueryParams($params);
        $data  = $this->service->getList($queryParams);
        return jsonSuccess($data);
    }
}

<?php

namespace app\common\traits;

use app\common\types\QueryParams;

trait ServiceTraits
{
    public function getList(QueryParams $queryParams)
    {
        if (property_exists($this, 'dao')) {
            return $this->dao->getList($queryParams);
        }
    }
}

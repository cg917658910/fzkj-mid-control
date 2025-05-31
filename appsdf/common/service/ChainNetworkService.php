<?php

namespace app\common\service;

use app\common\dao\ChainNetworkDao;

class ChainNetworkService extends BaseService
{
    protected $dao;

    public function __construct()
    {
        $this->dao = new ChainNetworkDao();
    }
}

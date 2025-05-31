<?php

namespace app\common\service;

use app\common\dao\ChainAddressDao;

class ChainAddressService extends BaseService
{
    protected $dao;

    public function __construct()
    {
        $this->dao = new ChainAddressDao();
    }
}

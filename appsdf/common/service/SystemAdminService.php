<?php

namespace app\common\service;

use app\common\dao\system\SystemAdminDao;
use app\common\traits\ServiceTraits;

class SystemAdminService extends BaseService
{
    use ServiceTraits;
    protected $dao;

    public function __construct()
    {
        $this->dao = new SystemAdminDao();
    }
}

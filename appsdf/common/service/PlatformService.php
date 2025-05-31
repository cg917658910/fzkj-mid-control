<?php

namespace app\common\service;

use app\common\dao\PlatformDao;

class PlatformService extends BaseService
{
    protected $dao;

    public function __construct()
    {
        $this->dao = new PlatformDao();
    }
}

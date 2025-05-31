<?php

namespace app\admin\controller;

use app\common\controller\BaseController;
use app\common\service\SystemAdminService;
use app\common\traits\RequestTraits;

class SystemAdmin extends BaseController
{

    use RequestTraits;
    protected $service;
    public function __construct(SystemAdminService $service)
    {
        $this->service = $service;
    }
}

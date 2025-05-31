<?php

namespace app\admin\controller;

use app\common\controller\BaseController;
use app\common\service\PlatformService;
use app\common\traits\RequestTraits;

class Platform extends BaseController
{

    use RequestTraits;
    protected $service;
    public function __construct(PlatformService $service)
    {
        $this->service = $service;
    }
}

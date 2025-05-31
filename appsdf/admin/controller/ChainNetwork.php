<?php

namespace app\admin\controller;

use app\common\controller\BaseController;
use app\common\service\ChainNetworkService;
use app\common\traits\RequestTraits;

class ChainNetwork extends BaseController
{

    use RequestTraits;
    protected $service;
    public function __construct(ChainNetworkService $service)
    {
        $this->service = $service;
    }
}

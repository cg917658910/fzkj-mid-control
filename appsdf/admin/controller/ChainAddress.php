<?php

namespace app\admin\controller;

use app\common\controller\BaseController;
use app\common\service\ChainAddressService;
use app\common\traits\RequestTraits;

class ChainAddress extends BaseController
{

    use RequestTraits;
    protected $service;
    protected $exceptPath = [''];
    public function __construct(ChainAddressService $service)
    {
        $this->initialize();
        $this->service = $service;
    }
}

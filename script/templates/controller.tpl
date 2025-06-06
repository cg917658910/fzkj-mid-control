<?php

namespace app\admin\controller{namespace};

use app\common\controller\BaseController;
use app\common\service\{name}Service;
use app\common\traits\RequestTraits;

class {name} extends BaseController
{

    use RequestTraits;
    protected $service;
    protected $exceptPath = [''];
    public function __construct({name}Service $service)
    {
        $this->initialize();
        $this->service = $service;
    }
}

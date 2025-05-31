<?php

namespace app\common\service;

use app\common\dao\{name}Dao;

class {name}Service extends BaseService
{
    protected $dao;

    public function __construct()
    {
        $this->dao = new {name}Dao();
    }
}

<?php

namespace app\admin\controller;

use app\common\controller\BaseController;

class Agent extends BaseController
{


    public function find(int $id)
    {
        var_dump($this->admin_login);
        echo "id=" . $id;
    }
}

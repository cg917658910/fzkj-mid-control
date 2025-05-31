<?php

namespace app\admin\validate;

use think\Validate;

class {name}Validate extends Validate
{
    protected $rule =   [
        'id'  => 'require|gt:0',
        'page' => 'require|min:1',
        'limit' => 'require|min:1|max:1000',
        'status' => 'require|in:0,1',
    ];

    protected $message  =   [
        
    ];

    protected $scene = [
        "create" => [],
        "update" => ['id'],
        "page" => ['page', 'limit'],
        "list" => [''],
        "changeStatus" => ['id', 'status'],
    ];
}

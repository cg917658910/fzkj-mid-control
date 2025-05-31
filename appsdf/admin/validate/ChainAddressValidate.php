<?php

namespace app\admin\validate;

use think\Validate;

class ChainAddressValidate extends Validate
{
    protected $rule =   [
        'id'  => 'require|gt:0',
        'page' => 'require|min:1',
        'limit' => 'require|min:1|max:1000',
        'status' => 'require|in:0,1',
        'network_id'  => 'require|gt:0',
        'address'   => 'require|length:2,100|unique:zt_chain_address',
    ];

    protected $message  =   [];

    protected $scene = [
        "create" => ['network_id', 'address'],
        "update" => ['id', 'network_id', 'address'],
        "page" => ['page', 'limit'],
        "list" => [''],
        "changeStatus" => ['id', 'status'],
    ];
}

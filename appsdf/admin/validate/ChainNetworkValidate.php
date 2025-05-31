<?php

namespace app\admin\validate;

use think\Validate;

class ChainNetworkValidate extends Validate
{
    protected $rule =   [
        'id'  => 'require|gt:0',
        'page' => 'require|min:1',
        'limit' => 'require|min:1|max:1000',
        'status' => 'require|in:0,1',
        'scan_api' => 'url',
        'network_name'   => 'require|length:4,25|unique:zt_chain_network',
    ];

    protected $message  =   [];

    protected $scene = [
        "create" => ['network_name', 'scan_api'],
        "update" => ['id', 'network_name', 'scan_api'],
        "page" => ['page', 'limit'],
        "list" => [''],
        "changeStatus" => ['id', 'status'],
    ];
}

<?php

namespace app\admin\validate;

use think\Validate;

class LoginValidate extends Validate
{
    protected $rule =   [
        'username'  => 'require|chsAlphaNum',
        'password'   => 'require',
        'vercode' => 'require',
        'uid' => 'require',
        'code' => 'require',
    ];

    protected $message  =   [
        'username.require' => 'name_empty',
        'username.chsAlphaNum' => 'name_format',
        'password.require'     => 'pass_empty',
    ];

    protected $scene = [
        'login'  =>  ['username', 'password'],
        'check_google_code'  =>  ['uid', 'code'],
    ];
}

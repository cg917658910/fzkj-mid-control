<?php

namespace app\admin\controller;

use app\common\controller\NoLoginBaseController;
use app\common\service\LoginService;
use app\common\traits\ApiBaseTraits;
use think\Request;

class Login extends NoLoginBaseController
{
    use ApiBaseTraits;
    protected $service;
    public function __construct(LoginService $service)
    {
        $this->validateRequestMask();
        $this->service = $service;
    }
    public function login()
    {
        $this->validateRequest();
        $datapost = Request::instance()->post(); // 获取经过过滤的全部post变量
        $username = $datapost['username'];
        $password = $datapost['password'];
        $data = $this->service->login($username, $password);
        return jsonSuccess($data);
    }

    public function check_google_code()
    {
        $this->validateRequest();
        $uid = request()->post('uid');
        $code = request()->post('code');
        $data = $this->service->verifyGoogleCode($uid, $code);
        return jsonSuccess($data);
    }
}

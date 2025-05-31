<?php

namespace app\common\controller;

use app\common\service\Redis;
use app\common\traits\ApiBaseTraits;
use think\Controller;
use think\Session;
use think\Request;

class BaseController extends Controller
{
    use ApiBaseTraits;
    public $admin_login;
    public $datapost = [];
    public $dataget = [];
    public $ip = '127.0.0.1';

    //构造函数
    public function _initialize()
    {
        $this->validateRequestMask();
        //$this->requestAuth();
        if (Request::instance()->isPost()) {
            $datapost = Request::instance()->post();
            foreach ($datapost as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $vk => $vj) {
                        if ($this->check_param($vj)) {
                            $this->check_request('参数不包含特殊字符', 'Login/index?dow=2', 999);
                            exit;
                        }
                        $datapost[$k][$vk] = htmlentities($vj);
                    }
                } else {
                    if ($this->check_param($v)) {
                        $this->check_request('参数不包含特殊字符', 'Login/index?dow=2', 999);
                        exit;
                    }
                    $datapost[$k] = htmlentities($v);
                }
            }
            $this->datapost = $datapost;
        }
        if (Request::instance()->get()) {
            $dataget = Request::instance()->get(); // 获取经过过滤的全部post变量
            foreach ($dataget as $k => $v) {
                if ($this->check_param($v)) {
                    $this->check_request('参数不包含特殊字符', 'Login/index?dow=2', 999);
                    exit;
                }
                $dataget[$k] = htmlentities($v);
            }
            $this->dataget = $dataget; // 获取经过过滤的全部post变量
        }
    }

    /**检测页面跳转
     * @param $msg
     * @param $url
     * @param $code
     * @param bool $is_login
     */
    public function check_request($msg, $url, $code, $is_login = true)
    {
        if ($is_login) {
            $admin = session::get('admin');
            session(null);
        }
        if (Request::instance()->isAjax()) {
            echo json_encode(['code' => $code, 'login' => $url, 'msg' => $msg], JSON_UNESCAPED_UNICODE);
            exit;
        } else {
            $this->redirect($url);
            exit;
        }
    }

    /**检测提交的参数
     * @param $str
     * @return bool
     */
    public function check_param($str)
    {
        $keyword = [
            'UPDATE SET',
            'DELETE FROM',
            'INSERT INTO',
            '<script',
        ];;
        foreach ($keyword as $item) {
            if (stristr($str, $item)) {
                return true;
                break;
            }
        }
        return false;
    }
}

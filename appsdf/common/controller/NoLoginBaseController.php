<?php

namespace app\common\controller;

use app\common\model\system\SystemConfigModel;
use app\common\tools\Str;
use think\Controller;
use think\Request;

class NoLoginBaseController extends Controller
{
    protected $datapost;

    protected $ipstr = '0.0.0.0';

    protected $ip_info = [];

    protected $language = [
        'CN' => 'Zhcn',
        'EN' => 'Enus',
    ];

    protected $lang_info = [];

    //构造函数
    public function _initialize()
    {
        header('Content-Type: text/html;charset=utf-8');
        header('Access-Control-Allow-Origin:*'); // *代表允许任何网址请求
        header('Access-Control-Allow-Methods:POST,GET,OPTIONS,DELETE'); // 允许请求的类型 //,OPTIONS,DELETE
        header('Access-Control-Allow-Credentials: true'); // 设置是否允许发送 cookies
        header("Access-Control-Allow-Headers:DNT,X-Mx-ReqToken,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type, Accept-Language, Origin, Accept-Encoding,Authorization,TxtInfo");
        $datapost = Request::instance()->post();
        foreach ($datapost as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $vk => $vj) {
                    if ($this->check_param($vj)) {
                        $this->return_err('the parameter does not contain special characters!');
                        exit;
                    }
                    $datapost[$k][$vk] = htmlspecialchars($vj);
                }
            } else {
                if ($this->check_param($v)) {
                    $this->return_err('the parameter does not contain special characters!');
                    exit;
                }
                $datapost[$k] = htmlspecialchars($v);
            }
        }
        $this->datapost = $datapost;
        $this->ipstr = htmlentities(request()->ip());
    }

    /**错误信息返回
     * @param $msg
     * @param int $code
     */
    public function return_err($msg, $code = 2)
    {
        $data = [
            'code' => $code,
            'msg' => $msg
        ];
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**渲染错误页面
     * @param $text
     * @return mixed
     */
    public function err_tpl($text)
    {
        $this->assign("error_text", $text);
        return $this->fetch('aipay/error'); //加载银行卡的页面
    }

    /**检测提交的参数
     * @param $str
     * @return bool
     */
    public function check_param($str)
    {
        $keyword = Str::get_error_keyword();
        foreach ($keyword as $item) {
            if (stristr($str, $item)) {
                return true;
            }
        }
        return false;
    }
}

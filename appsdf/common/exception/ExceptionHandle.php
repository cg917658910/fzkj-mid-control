<?php

namespace app\common\exception;

use app\common\enum\CodeEnum;
use Exception;
use think\exception\Handle;
use think\exception\HttpException;
use think\exception\ValidateException;

class ExceptionHandle extends Handle
{

    public function render(Exception $e)
    {
        // 参数验证错误
        if ($e instanceof ValidateException) {
            return jsonFail(CodeEnum::INVALID_PARAMS, $e->getMessage());
        }

        // api exception
        if ($e instanceof ApiException) {
            return $e->render();
        }

        // 请求异常
        if ($e instanceof HttpException && request()->isAjax()) {
            return response($e->getMessage(), $e->getStatusCode());
        }

        //TODO::开发者对异常的操作
        //可以在此交由系统处理
        return parent::render($e);
    }
}

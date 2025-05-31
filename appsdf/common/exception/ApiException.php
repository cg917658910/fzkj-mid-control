<?php

namespace app\common\exception;

use app\common\enum\CodeEnum;
use think\Exception;

class ApiException extends Exception
{
    protected $code;
    protected $message;
    protected $httpStatus;
    protected $data;

    public function __construct($code = CodeEnum::SERVER_ERROR, $message = null, $httpStatus = 200, $data = null)
    {
        $this->code = $code;
        $this->message = $message;
        $this->httpStatus = $httpStatus;
        $this->data = $data;
    }

    public function render()
    {
        return jsonFail($this->code, $this->message, $this->httpStatus, $this->data);
    }
}

<?php

namespace app\common\enum;

class CodeEnum
{
    public const SUCCESS = 0;
    public const INVALID_PARAMS = 10001;
    public const UNAUTHORIZED = 10002;
    public const FORBIDDEN = 10003;
    public const FORBIDDEN_INVALID_MASK = 10004;
    public const NOT_FOUND = 10005;
    public const SERVER_ERROR = 50001;

    public static function msg($code): string
    {
        switch ($code) {
            case self::SUCCESS:
                return "success";
            case self::INVALID_PARAMS:
                return "invalid params";
            case self::UNAUTHORIZED:
                return "unauthorized";
            case self::FORBIDDEN:
                return "forbidden";
            case self::FORBIDDEN_INVALID_MASK:
                return "fbim nothing";
            case self::NOT_FOUND:
                return "not found";
            case self::SERVER_ERROR:
                return "server error";
            default:
                return "unknown error";
        }
    }
}

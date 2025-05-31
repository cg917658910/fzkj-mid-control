<?php

use app\common\enum\CodeEnum;

function jsonSuccess($data = null, $msg = null, $code = CodeEnum::SUCCESS)
{
    return json([
        'code' => $code,
        'data' => $data,
        'msg'  => $msg ?? CodeEnum::msg($code),
    ]);
}
function jsonFail($code = null, $msg = null, $httpStatus = 200, $data = null)
{
    $response = [
        'code' => $code,
        'msg'  => $msg ?? CodeEnum::msg($code),
    ];
    if ($data) {
        $response['data'] = $data;
    }
    return json($response, $httpStatus);
}

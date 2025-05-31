<?php

/**发送json数据流
 * @param $url
 * @param $post_data
 * @param bool $isStr
 * @return bool|string
 */
function flow_json_post($url,$post_data,$isStr = false){
    $data_string = $isStr ? $post_data : json_encode($post_data);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //将curl_exec()获取的信息以文件流的形式返回，而不是直接输出。
    curl_setopt($ch, CURLOPT_TIMEOUT, 120);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json;charset=utf-8',
            'Content-Length: ' . strlen($data_string))
    );
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

//发送get请求
function to_get($url, $header = [])
{
    $con = curl_init($url);
    curl_setopt($con, CURLOPT_HEADER, false);
    curl_setopt($con, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($con, CURLOPT_TIMEOUT, 60);
    curl_setopt($con, CURLOPT_HTTPGET, true);
    curl_setopt($con, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($con, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($con, CURLOPT_SSL_VERIFYHOST, FALSE);// POST数据
    $output = curl_exec($con);
    curl_close($con);
    return $output;
}

//金额分割
function coin_split($str,$n=3){
    $str_arr = explode('.',$str);
    $str = strrev($str_arr[0]);
    $data = str_split($str, $n);
    $str = implode(',', $data);
    return strrev($str).(isset( $str_arr[1] )?'.'.$str_arr[1] : '');
}

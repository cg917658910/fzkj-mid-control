<?php

namespace app\common\tools;

class Str
{
    protected static $studlyCache = [];
    /**获取过滤的关键字
     * @return array
     */
    public static function get_error_keyword()
    {
        return [
            'UPDATE SET',
            'DELETE FROM',
            'INSERT INTO',
            '<script',
        ];
    }

    /**生成随机字符串
     * @param int $len 随机长度
     * @param int $type 1 表示全部  2表示数字 3表示字母 4大写字母加数字  5小写字母加数字
     * @return string
     */
    public static function get_random_str($len, $type = 1)
    {
        $num_str = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
        $min_str = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x'];
        $max_str = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K', 'L', 'M', 'N', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
        $new_str = '';
        switch ($type) {
            case 2:
                $str_arr = $num_str;
                break;
            case 3:
                $str_arr = array_merge($min_str, $max_str);;
                break;
            case 4:
                $str_arr = array_merge($num_str, $max_str);;
                break;
            case 5:
                $str_arr = array_merge($num_str, $min_str);;
                break;
            case 1:
            default:
                $str_arr = array_merge($num_str, $min_str, $max_str);
                break;
        }
        $count = count($str_arr);
        for ($i = 1; $i <= $len; $i++) {
            shuffle($str_arr);
            shuffle($str_arr);
            shuffle($str_arr);
            $key = mt_rand(0, $count - 1);
            $new_str .= $str_arr[$key];
        }
        return $new_str;
    }

    /**
     * @return string
     */
    public static function create_sign_key()
    {
        $str = time() . date('Y-m-d') . '54981654w9ef' . mt_rand(100, 200) . mt_rand(200, 300) . mt_rand(300, 909);
        return md5(md5($str));
    }

    /**检测特殊字符串
     * @param $parameter
     * @param array $ok
     * @return false|int
     */
    public static function check_str($parameter, $ok = [])
    {
        foreach ($ok as $k => $v) {
            $parameter = str_replace($v, '', $parameter);
        }
        return preg_match("/[\',:;*?~`!#$%^&+=<>{}]|bai\]|\[|\/|\\\|\"|\|/", $parameter);
    }

    /**生成uuid
     * @return string
     */
    public static function create_uuid()
    {
        $chars = md5(uniqid(mt_rand(), true));
        return substr($chars, 0, 8) . '-'
            . substr($chars, 8, 4) . '-'
            . substr($chars, 12, 4) . '-'
            . substr($chars, 16, 4) . '-'
            . substr($chars, 20, 12);
    }
    /**
     * 下划线转驼峰(首字母大写)
     *
     * @param  string $value
     * @return string
     */
    public static function studly(string $value): string
    {
        $key = $value;

        if (isset(static::$studlyCache[$key])) {
            return static::$studlyCache[$key];
        }

        $value = ucwords(str_replace(['-', '_'], ' ', $value));

        return static::$studlyCache[$key] = str_replace(' ', '', $value);
    }
}

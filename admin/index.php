<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]

//设置头部信息
header("X-Powered-By:Yii2.0");
$index = 'admin';
define('BIND_MODULE', $index);//绑定默认模块
define('DEBUG_A', true);//开关调试
// [ 应用入口文件 ]
require __DIR__ . '/../systemdf/Grid.php';
// 定义应用目录
define('APP_PATH', __DIR__ . '/../appsdf/');
// 加载框架引导文件
require __DIR__ . '/../systemdf/start.php';

<?php
$env_config =  [
    'database' => [
        //'host' => '192.168.0.89',
        'host' => '127.0.0.1',
        'database' => 'newcontrol',
        'name' => 'root',
        'pass' => 'cg123456',
        'port' => 3306,
        'prefix' => '',
    ],
    'redis' => [
        'host' => '127.0.0.1',
        'port' => 6379,
        'select' => 3,
        'password' => 'root',
    ],
    'app' => [
        'debug' => true,
        'static' => '/static',
        'aes_key' => '14e1b600b1fd579f47433b88e8d85291',
        'coin_pass_prefix' => 'coin',
    ],
    'adminConf' => [
        "apiSafeMask" => 'fzkjqs'
    ],
];

<?php
// 开启AR支持workerman的web服务器
$webserverConfig = [
    // 绑定服务端口
    'bind' => 'http://0.0.0.0:8080',
    // host
    'host' => 'www.web.com.lk',
    // 网站根目录
    'root' => dirname(__FILE__),
    // 设置开启多少进程
    'count' => 1,
    // 入口文件
    'entry' => '/index.php'
];
$loader = require dirname(dirname(__FILE__)) .  '/vendor/autoload.php';
ar\core\Ar::init($loader, $webserverConfig);
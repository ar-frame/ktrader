#!/usr/bin/php
<?php
// 开启AR支持runner模式
$startConfig = [
    // 入口文件
    'entry' => __FILE__,
    'type' => 'runner',

];
$loader = require dirname(dirname(__FILE__)) .  '/vendor/autoload.php';
\ar\core\Ar::init($loader, $startConfig);
// 执行service

echo "start job \n";



// 更新代理信息
$updateService = \ar\core\service('Auth')->updateService('ktrader', '18888888888', 'ktrader 2.1', 'SOUHA ...');
// 添加 ktrader 代理账号, 并生产5激活码 ，有效期30天
$genResult = \ar\core\service('Auth')->genCode(5, 'ktrader', 30);


var_dump($genResult, $updateService);

echo "end job \n";

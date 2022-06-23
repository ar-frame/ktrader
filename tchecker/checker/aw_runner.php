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


$updateService = \ar\core\service('Auth')->updateService('dpb', '18502878090', '今晚梭哈，跟上操作', '每天都梭一把V5');
$updateService = \ar\core\service('Auth')->updateService('mrl', '18502878090', '今晚梭哈，跟上操作', '每天都梭一把V5');
var_dump($updateService);


$genResult = \ar\core\service('Auth')->genCode(50, 'mrl', 30);
var_dump($genResult);

echo "end job \n";

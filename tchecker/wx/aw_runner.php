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


// $updateService = \ar\core\service('Auth')->updateService('dpb', '18502878090', '今晚梭哈，跟上操作', '每天都梭一把V5');
// var_dump($updateService);

\ar\core\comp('cache.file')->set('isupload', true, 1800);
// $genResult = \ar\core\service('Auth')->genCode(10, 'dpb', 30);
// var_dump($genResult);
ignore_user_abort();
echo "end job \n";

for ($i = 0; $i<5 ;$i++) {
sleep(1);
echo $i;
}


\ar\core\comp('cache.file')->set('isupload', null);
<?php
// 开启AR支持workerman的web服务器
$startConfig = [
    // 设置开启多少进程
    'count' => 1,
    // 入口文件
    'entry' => __FILE__,
    'type' => 'timer',
    'func' => function($worker)
    {
        if($worker->id === 0)
        {
            var_dump('doPushJob timer start');
            \Workerman\Lib\Timer::add(1, function()use($worker){
                $isupload = \ar\core\comp('cache.file')->get('isupload');
                
                if ($isupload) {
                    echo 'find job' . "\n";
                } else {
                    echo 'waitting a job...' . "\n";
                }

                if (\ar\core\comp('cache.file')->get('isupload')) {
                    $command = "bytecli -u 4.2.48@d:/hjwx_tt --upload-desc 'HJ-PUB'";
                    exec($command, $return_val);
                }

                \ar\core\comp('cache.file')->set('isupload', null);

                
                // $command = "php aw_runner.php";
                // system($command);
                // exec($command, $return_val);

            });
        }
    }
];
$loader = require dirname(dirname(__FILE__)) .  '/vendor/autoload.php';
ar\core\Ar::init($loader, $startConfig);

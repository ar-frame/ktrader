<?php
// 开启AR支持workerman的web服务器
$startConfig = [
    // 设置开启多少进程
    'count' => 2,
    // 入口文件
    'entry' => __FILE__,
    'type' => 'timer',
    'func' => function($worker)
    {
        if($worker->id === 0)
        {
            var_dump('doPushJob timer start');
            \Workerman\Lib\Timer::add(5, function()use($worker){
                var_dump('doPushJob start');
                \ar\core\service('PushLogs')->doPushJob();
                var_dump('doPushJob end');
            });
        } else if($worker->id === 1) {
            var_dump('sendPushWechatMsg timer start');
            \Workerman\Lib\Timer::add(3, function() use($worker) {
                \ar\core\service('PushLogs')->sendPushWechatMsg();
            });
        }
    }
];
$loader = require dirname(dirname(__FILE__)) .  '/vendor/autoload.php';
ar\core\Ar::init($loader, $startConfig);

<?php
$port = '12317';

$pairMap = [
    '12315' => 'ETH-USDT',
    '12316' => 'EOS-USDT',
    '12317' => 'BTC-USDT',
];
$pair = $pairMap[$port];
// 开启AR支持workerman的websocket服务器
$startConfig = [
    // bind server port
    'bind' => 'websocket://0.0.0.0:' . $port,
    // 设置开启多少进程
    'count' => 5,
    // 入口文件
    'entry' => __FILE__,
    'type' => 'websocket',
    // 启动执行函数
    'func' => function($worker) use ($pair) {
        if ($worker->id == 0) {
            // 清理所有缓存
            \ar\core\service('Trader')->clearAllCache();
        }
    },
    'onMessage' => function($connection, $data) use ($pairMap, $port, $pair)
    {
        \ar\core\service('Connection')->dispatcherRequest($connection, $data, $pair);
    },
    'onClose' => function($connection) {
        var_dump('closed', $connection->id);
    },
    'onConnect' => function($connection) {
        var_dump('new connection', $connection->id);
    }
];
$loader = require dirname(dirname(__FILE__)) .  '/vendor/autoload.php';
ar\core\Ar::init($loader, $startConfig);

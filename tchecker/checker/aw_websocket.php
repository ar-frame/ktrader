<?php
if (count($argv) == 4) {
    $pair = strtoupper($argv[3]) . '-USDT';
} else {
    $pair = strtoupper('eth') . '-USDT';
}

// var_dump($argv);

$pairMap = [
    '12315' => 'ETH-USDT',
    '12316' => 'EOS-USDT',
    '12317' => 'BTC-USDT',
    '12318' => 'LTC-USDT',
    '12319' => 'GT-USDT',
    '12320' => 'ETC-USDT',
    '12322' => 'BCH-USDT',
    '12323' => 'ONT-USDT',
    '12324' => 'XRP-USDT',
    '12325' => 'HT-USDT',
];

$c = 0;
foreach ($pairMap as $p => $cpair) {
        $c++;
	if ($cpair == $pair) {
             $port = $p;
             break;
	}
        if ($c == count($pairMap)) {
            exit('not suport pair: ' . $pair);
        }
}

//$pair = $pairMap[$port];

// 开启AR支持workerman的websocket服务器
$startConfig = [
    // bind server port
    'bind' => 'websocket://0.0.0.0:' . $port,
    // 设置开启多少进程
    'count' => 2,
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

<?php
set_time_limit(0);

// 开启调试模式 默认开启 开启将显示DEBUG信息
defined('AR_DEBUG') or define('AR_DEBUG', true);

// 默认的项目目录
// define('AR_DEFAULT_APP_NAME', 'core');
// 管理目录
// define('AR_MAN_NAME', 'core');

// 以http方式服务开启webservice 后续会出基于socket的php多进程服务service
defined('AR_RUN_AS_SERVICE_HTTP') or define('AR_RUN_AS_SERVICE_HTTP', true);

$loader = require dirname(dirname(__FILE__)) .  '/vendor/autoload.php';
# 注册arphp加载器到composer 
ar\core\Ar::init($loader);
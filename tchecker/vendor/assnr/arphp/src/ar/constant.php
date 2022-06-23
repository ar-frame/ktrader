<?php
// version
defined('AR_VERSION') or define('AR_VERSION', '10.0.15'); // 20210313
// 启动时间
defined('AR_START_TIME') or define('AR_START_TIME', microtime(true));
// // 开启调试 是
// defined('AR_DEBUG') or define('AR_DEBUG', true);
// // 外部启动 否 默认管理目录ArMan
// defined('AR_OUTER_START') or define('AR_OUTER_START', false);
// // 自启动session
// defined('AR_AUTO_START_SESSION') or define('AR_AUTO_START_SESSION', true);
// // 作为外部框架加载 可嵌入其他框架
// defined('AR_AS_OUTER_FRAME') or define('AR_AS_OUTER_FRAME', false);
// // 内部实现http webservice 多套 arphp程序互调接口
// defined('AR_RUN_AS_SERVICE_HTTP') or define('AR_RUN_AS_SERVICE_HTTP', false);
// // 实现 cmd socket 编程
// defined('AR_AS_CMD') or define('AR_AS_CMD', false);
// // web application 默认方式
// defined('AR_AS_WEB') or define('AR_AS_WEB', true);
// // web cli 模式
// defined('AR_AS_WEB_CLI') or define('AR_AS_WEB_CLI', false);
// // app名 main
// defined('AR_DEFAULT_APP_NAME') or define('AR_DEFAULT_APP_NAME', 'main');
// // 默认的控制器名
// defined('AR_DEFAULT_CONTROLLER') or define('AR_DEFAULT_CONTROLLER', 'Index');
// // 默认的Action
// defined('AR_DEFAULT_ACTION') or define('AR_DEFAULT_ACTION', 'index');

// 集成workerman
defined('AR_IN_WORKERMAN') or define('AR_IN_WORKERMAN', false);
// runner模式
defined('AR_AS_RUNNER') or define('AR_AS_RUNNER', false);
//　定时器模式
defined('AR_AS_TIMER') or define('AR_AS_TIMER', false);

// ar框架目录
defined('AR_FRAME_PATH') or define('AR_FRAME_PATH', dirname(__FILE__) . DS);
// 项目根目录
defined('AR_ROOT_PATH') or define('AR_ROOT_PATH', realpath(dirname(dirname($_SERVER['SCRIPT_FILENAME']))) . DS);
// 实际ORI项目名字
defined('AR_ORI_ACTUAL_NAME') or define('AR_ORI_ACTUAL_NAME', basename(dirname($_SERVER['SCRIPT_FILENAME'])));
// 核心目录
defined('AR_CORE_PATH') or define('AR_CORE_PATH', AR_FRAME_PATH . 'core' . DS);
// 配置目录
defined('AR_CONFIG_PATH') or define('AR_CONFIG_PATH', AR_FRAME_PATH . 'cfg' . DS);
// 服务地址
defined('AR_SERVER_PATH') or define('AR_SERVER_PATH', ($dir = dirname($_SERVER['SCRIPT_NAME'])) == DS ? '/' : str_replace(DS, '/', $dir) . '/');

defined('HDOM_TYPE_ELEMENT') or define('HDOM_TYPE_ELEMENT', 1);
defined('HDOM_TYPE_COMMENT') or define('HDOM_TYPE_COMMENT', 2);
defined('HDOM_TYPE_TEXT') or define('HDOM_TYPE_TEXT',    3);
defined('HDOM_TYPE_ENDTAG') or define('HDOM_TYPE_ENDTAG',  4);
defined('HDOM_TYPE_ROOT') or define('HDOM_TYPE_ROOT',    5);
defined('HDOM_TYPE_UNKNOWN') or define('HDOM_TYPE_UNKNOWN', 6);
defined('HDOM_QUOTE_DOUBLE') or define('HDOM_QUOTE_DOUBLE', 0);
defined('HDOM_QUOTE_SINGLE') or define('HDOM_QUOTE_SINGLE', 1);
defined('HDOM_QUOTE_NO') or define('HDOM_QUOTE_NO',     3);
defined('HDOM_INFO_BEGIN') or define('HDOM_INFO_BEGIN',   0);
defined('HDOM_INFO_END') or define('HDOM_INFO_END',     1);
defined('HDOM_INFO_QUOTE') or define('HDOM_INFO_QUOTE',   2);
defined('HDOM_INFO_SPACE') or define('HDOM_INFO_SPACE',   3);
defined('HDOM_INFO_TEXT') or define('HDOM_INFO_TEXT',    4);
defined('HDOM_INFO_INNER') or define('HDOM_INFO_INNER',   5);
defined('HDOM_INFO_OUTER') or define('HDOM_INFO_OUTER',   6);
defined('HDOM_INFO_ENDSPACE') or define('HDOM_INFO_ENDSPACE',7);
defined('DEFAULT_TARGET_CHARSET') or define('DEFAULT_TARGET_CHARSET', 'UTF-8');
defined('DEFAULT_BR_TEXT') or define('DEFAULT_BR_TEXT', "\r\n");
defined('DEFAULT_SPAN_TEXT') or define('DEFAULT_SPAN_TEXT', " ");

if (!defined('MAX_FILE_SIZE'))
{
    define('MAX_FILE_SIZE', 600000);
}

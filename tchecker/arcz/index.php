<?php
$baseDir = dirname(dirname(__FILE__));
$loader = require $baseDir . '/vendor/autoload.php';
define('AR_DEFAULT_CONTROLLER', 'Index');
define('AR_DEFAULT_ACTION', 'index');
/*
if (isset($_GET['ar_tpl_name'])) {
    $tplName = $_GET['ar_tpl_name'];
    setcookie("ar_tpl_name",$tplName, time() + 3600*24*90);
    define("AR_PUBLIC_CONFIG_FILE", dirname(dirname(__FILE__)) . '/cfg/tpl/' . $tplName . '.php');
} else {
    if (isset($_COOKIE['ar_tpl_name'])) {
        $tplName = $_COOKIE['ar_tpl_name'];
        define("AR_PUBLIC_CONFIG_FILE", dirname(dirname(__FILE__)) . '/cfg/tpl/' . $tplName . '.php');
    }
}

*/
ar\core\Ar::init($loader);

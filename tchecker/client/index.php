<?php
$loader = require dirname(dirname(__FILE__)) .  '/vendor/autoload.php';
# 注册arphp加载器到composer 
ar\core\Ar::init($loader);
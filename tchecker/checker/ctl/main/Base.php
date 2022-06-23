<?php
/**
 * @Author: Marte
 * @Date:   2018-09-16 20:50:05
 * @Last Modified by:   Marte
 * @Last Modified time: 2019-05-30 11:05:55
 */
namespace checker\ctl\main;
use \ar\core\ApiController as Controller;

/**
 * Default Controller of webapp.
 */
class Base extends Controller
{
    public function init()
    {
        header("content-type:text/html; charset=utf-8");
        header('Access-Control-Allow-Origin:*');
        date_default_timezone_set('PRC'); //设置中国时区 
    }

    public function handleError($errMsg)
    {
        $this->showJsonError($errMsg);
    }
}
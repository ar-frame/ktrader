<?php

namespace arcz\ctl\main\service;
define("ARCZ_RATH_QR", dirname(dirname(dirname(dirname(__FILE__)))).DS);
require_once(ARCZ_RATH_QR."lib/ext/phpqrcode.php");
class Qrcode{
    public function png($data, $size = 6, $filename = false, $savePath)
    {
        \QRcode::png($data, $filename, 'H', $size, 2);
      
        if (file_exists($filename)) {
            return true;
        } else {
            return false;
        }
        
    }
}
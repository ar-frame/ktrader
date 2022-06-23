<?php
/**
 * 字符串加解密
 *
 * @author 阿。sir@coopcoder.com
*/
namespace server\lib\ext;
class Cipher
{
    static function base64url_encode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    static function base64url_decode($data)
    {
        return base64_decode(strtr($data, '-_', '+/') . str_repeat('=', 3 - (3 + strlen($data)) % 4));
    }

    static function encode($str)
    {
        $len = strlen($str);
        $enStr = '';
        for ($i = 0; $i < $len; $i++) {
            $enStr .= str_pad(((int)ord($str[$i])) << 2 ^ 36, 4, '_', STR_PAD_LEFT);
        }
        return static::base64url_encode($enStr);
    }

    static function decode($str)
    {
        $str = static::base64url_decode($str);
        $len = strlen($str);
        $deStr = '';
        for ($i = 0; $i < $len / 4; $i++) {
            $slice = substr($str, $i * 4, 4);
            $deStr .= chr((((int)str_replace('_', '', $slice)) ^ 36) >> 2);
        }
        return $deStr;
    }
}

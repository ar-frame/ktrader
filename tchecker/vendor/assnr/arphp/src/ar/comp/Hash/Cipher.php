<?php
namespace ar\comp\Hash;
use ar\core\Ar as Ar;
use ar\comp\Component as Component;
/**
 * ArPHP A Strong Performence PHP FrameWork ! You Should Have.
 *
 * PHP version 5
 *
 * @category PHP
 * @package  Core.Component.Cipher
 * @author   yc <ycassnr@gmail.com>
 * @license  http://www.arphp.org/licence MIT Licence
 * @version  GIT: 1: coding-standard-tutorial.xml,v 1.0 2014-5-01 18:16:25 cweiske Exp $
 * @link     http://www.arphp.org
 */

/**
 * Cipher
 *
 * Cipher hash comment :
 *
 * <code>
 *  #This is a hash comment, which is prohibited.
 *  $hello = 'hello';
 * </code>
 *
 * @category ArPHP
 * @package  Core.Component.Hash
 * @author   yc <ycassnr@gmail.com>
 * @license  http://www.arphp.org/licence MIT Licence
 * @version  Release: @package_version@
 * @link     http://www.arphp.org
 */
class Cipher extends Component
{
    // key
    private $_key;
    // ivSize
    private $_ivSize;

    /**
     * init.
     *
     * @param mixed  $config config.
     * @param string $class  class holder.
     *
     * @return Object
     */
    static public function init($config = array(), $class = __CLASS__)
    {
        $hashObject = parent::init($config, $class);
        $key = empty($hashObject->config['key']) ? 'ArPHP_GO_GO_GO' : $hashObject->config['key'];
        $hashObject->_key = $key;
        return $hashObject;

    }

    // 改变key
    public function setKey($key = '')
    {
        if ($key) :
            $this->_key = $key;
        endif;
        return true;

    }

    /**
     * encrypt.
     *
     * @param string $plaintext plain.
     *
     * @return string
     */
    public function encrypt($plaintext)
    {
   
        $res = $this->authcode($plaintext, 'ENCODE', $this->_key);

        return $res;

    }

    /**
     * decrypt.
     *
     * @param string $ciphertext ciphertext.
     *
     * @return string
     */
    public function decrypt($ciphertext)
    {
        
        $res = $this->authcode($ciphertext, 'DECODE', $this->_key);

        return $res;
    }

    /**
     * decrypt & encrypt.
     *
     * @param string $string    ciphertext.
     * @param string $operation default DECODE.
     * @param string $key       key.
     *
     * @return string|bool
     */
    public function authcode($string, $operation = 'DECODE', $key = '') 
    {
        if ($operation == 'DECODE') {
            $string = @hex2bin($string);
            if ($string && strpos($string, '%') !== false) {
                $string = urldecode($string);
            }
            return $string;
        } else {
            return strtoupper(bin2hex($string));
        }
    }

    /**
     * decrypt & encrypt.
     *
     * @param string $string    ciphertext.
     * @param string $operation default DECODE.
     * @param string $key       key.
     *
     * @return string|bool
     */
    public function authcodeBak($string, $operation = 'DECODE', $key = '') 
    {
        $key = md5($key);
        $kLen = strlen($key);
        if ($operation == 'DECODE') {
            $string = hex2bin($string);
            $sLength = strlen($string);
            $deStr = '';
            for ($i = 0; $i < $sLength / 4; $i++) {
                $slice = substr($string, $i * 4, 4);
                $cindex = $i % $kLen;
                $cord = ord($key[$cindex]);
                $deStr .= chr((((int)str_replace('_', '', $slice)) ^ $cord));
            }
            return @hex2bin($deStr);
        } else {
            $hexString = strtoupper(bin2hex($string));
            $sLength = strlen($hexString);
            $cstr = '';
            for ($i = 0; $i < $sLength; $i++) {
                $cindex = $i % $kLen;
                $cord = ord($key[$cindex]);
                $char = ord($hexString[$i]) ^ $cord;
                $cstr .= str_pad($char, 4, '_', STR_PAD_LEFT);
            }
            return strtoupper(bin2hex($cstr));
        }
    }
}

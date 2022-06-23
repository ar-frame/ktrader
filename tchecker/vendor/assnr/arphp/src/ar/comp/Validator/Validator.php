<?php
namespace ar\comp\Validator;
use ar\core\Ar as Ar;
use ar\comp\Component as Component;
/**
 * ArPHP A Strong Performence PHP FrameWork ! You Should Have.
 *
 * PHP version 5
 *
 * @category PHP
 * @package  Core.Component.Validator
 * @author   yc <ycassnr@gmail.com>
 * @license  http://www.arphp.org/licence MIT Licence
 * @version  GIT: 1: coding-standard-tutorial.xml,v 1.0 2014-5-01 18:16:25 cweiske Exp $
 * @link     http://www.arphp.org
 */

/**
 * ArValidator
 *
 * default hash comment :
 *
 * <code>
 *  # This is a hash comment, which is prohibited.
 *  $hello = 'hello';
 * </code>
 *
 * @category ArPHP
 * @package  Core.Component.Validator
 * @author   yc <ycassnr@gmail.com>
 * @license  http://www.arphp.org/licence MIT Licence
 * @version  Release: @package_version@
 * @link     http://www.arphp.org
 */
class Validator extends Component
{
    /**
     * check if number.
     *
     * @param mixed $obj obj.
     *
     * @return boolean
     */
    public function checkNumber($obj)
    {
        return is_numeric($obj);

    }

    /**
     * check if simple array.
     *
     * @param mixed $obj obj.
     *
     * @return boolean
     */

    public function checkSimpleArray($obj)
    {
        $rt = true;
       
        $i = 0;
        if (is_array($obj)) {

            $keys = array_keys($obj);
            $ilength = 0;
            foreach ($keys as $k) {
                if (is_integer($k) && !is_array($obj[$k])) {
                    $ilength++;
                }
            }
            if ($ilength == count($obj)) {
                // 一维数组
                $rt = true;
            } else {
                $rt = false;
            }
        } else {
            $rt = false;
        }
        return $rt;
    }

    /**
     * check if muti array.
     *
     * @param mixed $obj obj.
     *
     * @return boolean
     */
    public function checkMutiArray($obj)
    {
        $rt = true;
        $keyLen = 0;
        $fkname = "";
        $i = 0;
        if (is_array($obj)) :

            foreach ($obj as $kname => $arr) :
                
                if (!is_array($arr)) :
                    $rt = false;
                    break;
                else:

                    if ($i == 0) {
                        $fkname = $kname;
                        $keyLen = count(array_keys($arr));
                    }

                    if (!is_numeric($kname)) {
                        if ($fkname != $kname) {
                            $rt = false;
                            break;
                        }
                    }

                    $ckeyLen = count(array_keys($arr));
                    if ($ckeyLen != $keyLen) {
                        $rt = false;
                        break;
                    }

                endif;
                $i++;
            endforeach;
        else :
            $rt = false;
        endif;

        return $rt;

    }

    /**
     * check if url.
     *
     * @param stirng $url url.
     *
     * @return boolean
     */
    public function checkUrl($url)
    {
        return preg_match("#^(http)#", $url);

    }

    /**
     * check key equal.
     *
     * @param array $arri array.
     * @param array $arro compare array.
     *
     * @return boolean
     */
    public function checkArrayKeyEqual(array $arri, array $arro)
    {
        $lengthi = count($arri);
        $lengtho = count($arro);

        $rt = true;

        if ($lengthi !== $lengtho) :
            $rt = false;
        else :
            foreach ($arri as $ikey => $ivalue) :

                if (!array_key_exists($ikey, $arro)) :
                    $rt = false;
                    break;
                endif;

            endforeach;
        endif;

        return $rt;

    }

    /**
     * checkAjax.
     *
     * @return boolean
     */
    public function checkAjax()
    {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') :
            return true;
        else :
            return false;
        endif;

    }

    /**
     * checkEmpty.
     *
     * @param mixed $obj obj.
     *
     * @return boolean
     */
    public function checkEmpty($obj)
    {
        return empty($obj);

    }

    /**
     * checkDataByRules.
     *
     * @param array $data  input data.
     * @param array $rules check rules.
     *
     * @return array
     */
    public function checkDataByRules(array $data, array $rules)
    {
        foreach ($rules as $k => $rule) :

            if (array_key_exists($k, $data)) :
                switch ($rule[0]) {
                case 'number' :
                    if ($this->checkNumber($data[$k])) :
                        unset($rules[$k]);
                    endif;
                    break;
                case 'required' :
                    if (!$this->checkEmpty($data[$k])) :
                        unset($rules[$k]);
                    endif;
                    break;
                default :
                    if (!$this->checkEmpty($data[$k])) :
                        unset($rules[$k]);
                    endif;
                    break;
                }
            endif;

        endforeach;

        return $rules;

    }

}

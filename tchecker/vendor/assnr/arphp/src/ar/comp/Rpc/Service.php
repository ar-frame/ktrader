<?php
namespace ar\comp\Rpc;
use ar\core\Ar as Ar;
use ar\comp\Component as Component;
/**
 * ArPHP A Strong Performence PHP FrameWork ! You Should Have.
 *
 * PHP version 5
 *
 * @category PHP
 * @package  Core.Component
 * @author   yc <ycassnr@gmail.com>
 * @license  http://www.arphp.org/licence MIT Licence
 * @version  GIT: 1: coding-standard-tutorial.xml,v 1.0 2014-5-01 18:16:25 cweiske Exp $
 * @link     http://www.arphp.org
 */

/**
 * Service
 *
 * default hash comment :
 *
 * <code>
 *  # This is a hash comment, which is prohibited.
 *  $hello = 'hello';
 * </code>
 *
 * @category ArPHP
 * @package  Core.Component
 * @author   yc <ycassnr@gmail.com>
 * @license  http://www.arphp.org/licence MIT Licence
 * @version  Release: @package_version@
 * @link     http://www.arphp.org
 */
class Service extends Api
{
    protected $TAG_MSG_SEP = '___SERVICE_STD_OUT_SEP___';
    protected $remoteWsFile = '';
    protected $remoteQueryUrlSign = '';

    /**
     * initialization for component.
     *
     * @param mixed  $config config.
     * @param string $class  instanse class.
     *
     * @return Object
     */
    static public function init($config = array(), $class = __CLASS__)
    {
        $obj = parent::init($config, $class);
        isset($config['authSign']) ? ($obj->remoteQueryUrlSign = $config['authSign']) : '';
        $obj->setRemoteWsFile();
        return $obj;

    }

    /**
     * generate ws file name.
     *
     * @param string $wsFile wsFile.
     *
     * @return mixed
     */
    public function setRemoteWsFile($wsFile = '')
    {
        if (empty($wsFile)) :
            $this->remoteWsFile = empty($this->config['wsFile']) ? \ar\core\comp('url.route')->host() . '/arws.php' : $this->config['wsFile'];
        else :
            $this->remoteWsFile = $wsFile;
        endif;

    }

    /**
     * use sign auth param.
     *
     * @param array $sign sign auth param.
     *
     * @return mixed
     */
    public function setAuthUserSignature($sign = array())
    {
        $this->remoteQueryUrlSign = $sign;

    }

    /**
     * generate remote ws url.
     *
     * @return mixed
     */
    public function gRemoteWsUrl()
    {
        // return $this->remoteWsFile . '?' . http_build_query($this->remoteQueryUrlSign);
        return $this->remoteWsFile;

    }

    /**
     * magic call.
     *
     * @param string $name ws name.
     * @param array  $args args.
     *
     * @return mixed
     */
    public function __call($name, $args = array())
    {
        $remoteQueryData = array();
        if (substr($name, 0, 2) === 'Ws') :
            if (substr($name, 0, 3) === 'Ws.') {
                $remoteQueryData['class'] = substr($name, 3);
            } else {
                $remoteQueryData['class'] = substr($name, 2);
            }
            $remoteQueryData['method'] = $args[0];
            $remoteQueryData['param'] = empty($args[1]) ? array() : $args[1];
            $remoteQueryData['authSign'] = $this->remoteQueryUrlSign;
            $remoteQueryData['CLIENT_SERVER'] = $_SERVER;
        else :
            throw new \ar\core\Exception("Service do not have a method " . $name);
        endif;
        $postServiceData = array('ws' => $this->encrypt($remoteQueryData));
        return $this->callApi($this->gRemoteWsUrl(), $postServiceData);

    }

    /**
     * call api.
     *
     * @param string $name ws name.
     * @param array  $args args.
     *
     * @return mixed
     */
    public function call($className, $methodName, $args = array())
    {
        $remoteQueryData = array();
        if (substr($className, 0, 2) === 'Ws') :
            if (substr($className, 0, 3) === 'Ws.') {
                $remoteQueryData['class'] = substr($className, 3);
            } else {
                $remoteQueryData['class'] = substr($className, 2);
            }
            $remoteQueryData['method'] = $methodName;
            $remoteQueryData['param'] = $args;
            $remoteQueryData['authSign'] = $this->remoteQueryUrlSign;
            $remoteQueryData['CLIENT_SERVER'] = $_SERVER;
        else :
            throw new \ar\core\Exception("Service do not have a method " . $name);
        endif;

        $postServiceData = array('ws' => $this->encrypt($remoteQueryData));

        return $this->callApi($this->gRemoteWsUrl(), $postServiceData);

    }

    /**
     * exec remote process.
     *
     * @param string $url  url.
     * @param array  $args args.
     *
     * @return mixed
     */
    public function callApi($url, $args = array())
    {
        $method = 'get';
        $pstr = serialize($args);
        if (strlen($pstr) > 7900) {
            $method = 'post';
        }
        $response = $this->remoteCall($url, $args, $method);
        return $this->processResponse($response);
    }

   /**
     * response to client.
     *
     * @param mixed $data response data.
     *
     * @return void
     */
    public function response($data = '', $type = '')
    {
        $responseStr = $this->TAG_MSG_SEP . $this->encrypt($data, $type);
        echo $responseStr;
    }

    /**
     * process remote server response.
     *
     * @param mixed $response back data.
     *
     * @return mixed
     */
    protected function processResponse($response = '')
    {
        if (empty($response)) :
            throw new \ar\core\Exception('Remote Service Error ( Service Response Empty )', '1012');
        endif;
        // error hanlder
        if (preg_match('#.*thrown in.*on line.*#', $response)) :
            $response = strip_tags($response);
            throw new \ar\core\Exception("Remote Service Error \n(" . $response . ')', '1101');
        endif;
        // std debug info
        $stdOutMsg = '';
        $remoteBackResult = Null;

        if (($pos = strpos($response, $this->TAG_MSG_SEP)) !== false) :
            if ($pos === 0) :
                $response = substr($response, strlen($this->TAG_MSG_SEP));
            else :
                list($stdOutMsg, $response) = explode($this->TAG_MSG_SEP, $response);
            endif;
            $remoteBackResult = $this->decrypt($response);
            if (is_array($remoteBackResult) && !empty($remoteBackResult['error_msg'])) :
                throw new \ar\core\Exception($remoteBackResult['error_msg'], $remoteBackResult['error_code']);
            endif;
        else :
            $stdOutMsg = $response;
        endif;
        if (AR_DEBUG && $stdOutMsg) {
            echo 'Remote stdout: ' . $stdOutMsg;
        }
        return $remoteBackResult;
    }

    /**
     * encrypt cache data.
     *
     * @param mixed $data cache date.
     *
     * @return string
     */
    public function encrypt($data = null, $type = '')
    {
        $dataMap = [
            'type' => '',
            'data' => $data,
        ];

        if ($type) {
            $dataMap['type'] = $type;
        } else {
            if (is_null($data)) {
                $dataMap['type'] = 'null';
            } elseif (is_float($data)) {
                $dataMap['type'] = 'float';
            } elseif (is_integer($data)) {
                $dataMap['type'] = 'int';
            } elseif (is_array($data)) {
                if (empty($data)) {
                    $dataMap['type'] = 'array';
                } else {
                    if (\ar\core\comp('validator.validator')->checkSimpleArray($data)) {
                        $dataMap['type'] = 'array';
                    } else {
                        if (\ar\core\comp('validator.validator')->checkMutiArray($data)) {
                            $dataMap['type'] = 'array';
                        } else {
                            $dataMap['type'] = 'object';
                        }
                    }
                }
                
            } elseif (is_string($data)) {
                $dataMap['type'] = 'string';
            } elseif (is_bool($data)) {
                $dataMap['type'] = 'bool';
            }
        }

        $jsonStr = json_encode($dataMap);

        return \ar\core\comp('hash.cipher')->encrypt($jsonStr);

    }

    /**
     * decrypt cache data.
     *
     * @param mixed $data description.
     *
     * @return mixed
     */
    public function decrypt($data)
    {    
        $dataMap = json_decode(\ar\core\comp('hash.cipher')->decrypt($data), true);
        return $dataMap['data'];

    }
}

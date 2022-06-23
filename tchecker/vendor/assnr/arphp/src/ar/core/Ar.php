<?php
namespace ar\core;
/**
 * ArPHP A Strong Performence PHP FrameWork ! You Should Have.
 *
 * PHP version 5
 *
 * @category PHP
 * @package  Core.base
 * @author   yc <ycassnr@gmail.com>
 * @license  http://www.arphp.org/licence MIT Licence
 * @version  GIT: 1: coding-standard-tutorial.xml,v 1.0 2014-5-01 18:16:25 cweiske Exp $
 * @link     http://www.arphp.org
 */

/**
 * class class
 *
 * default hash comment :
 *
 * <code>
 *  # This is a hash comment, which is prohibited.
 *  $hello = 'hello';
 * </code>
 *
 * @category ArPHP
 * @package  Core.base
 * @author   yc <ycassnr@gmail.com>
 * @license  http://www.arphp.org/licence MIT Licence
 * @version  Release: @package_version@
 * @link     http://www.arphp.org
 */
class Ar
{
    // applications collections
    static private $_a = array();
    // components collections
    static private $_c = array();
    // config
    static private $_config = array();
    // autoload path
    static public $autoLoadPath;

    /**
     * init application.
     *
     * @return mixed
     */
    static public function init($loader, $startServerConfig = [])
    {
        // 目录分割符号
        defined('DS') or define('DS', DIRECTORY_SEPARATOR);

        if ($startServerConfig) {
            if (empty($startServerConfig['type']) || $startServerConfig['type'] == 'web') {
                Ar::startWorkermanWebServer($startServerConfig);
                return;
            } else {

                // 其他支持的config
                if ($startServerConfig['type'] == 'timer') {
                    define('AR_AS_TIMER', true);
                    define('AR_ROOT_PATH', dirname(dirname($startServerConfig['entry'])) . '/');
                    define('AR_ORI_ACTUAL_NAME', basename(dirname($startServerConfig['entry'])));

                    // 扩展配置
                    defined('AR_PUBLIC_CONFIG_PATH') or define('AR_PUBLIC_CONFIG_PATH', AR_ROOT_PATH . 'cfg' . DS . AR_ORI_ACTUAL_NAME . DS);
                    defined('AR_PUBLIC_CONFIG_FILE') or define('AR_PUBLIC_CONFIG_FILE', AR_PUBLIC_CONFIG_PATH . $startServerConfig['type'] . '.php');

                } else if ($startServerConfig['type'] == 'runner') {
                    define('AR_AS_RUNNER', true);
                    define('AR_ROOT_PATH', dirname(dirname($startServerConfig['entry'])) . '/');
                    define('AR_ORI_ACTUAL_NAME', basename(dirname($startServerConfig['entry'])));
                    // 扩展配置
                    defined('AR_PUBLIC_CONFIG_PATH') or define('AR_PUBLIC_CONFIG_PATH', AR_ROOT_PATH . 'cfg' . DS . AR_ORI_ACTUAL_NAME . DS);
                    defined('AR_PUBLIC_CONFIG_FILE') or define('AR_PUBLIC_CONFIG_FILE', AR_PUBLIC_CONFIG_PATH . $startServerConfig['type'] . '.php');
                } else if ($startServerConfig['type'] == 'websocket') {
                    define('AR_AS_WEBSOCKET', true);
                    define('AR_ROOT_PATH', dirname(dirname($startServerConfig['entry'])) . '/');
                    define('AR_ORI_ACTUAL_NAME', basename(dirname($startServerConfig['entry'])));

                    // 扩展配置
                    defined('AR_PUBLIC_CONFIG_PATH') or define('AR_PUBLIC_CONFIG_PATH', AR_ROOT_PATH . 'cfg' . DS . AR_ORI_ACTUAL_NAME . DS);
                    defined('AR_PUBLIC_CONFIG_FILE') or define('AR_PUBLIC_CONFIG_FILE', AR_PUBLIC_CONFIG_PATH . $startServerConfig['type'] . '.php');

                } 
            }
        }
       
        require dirname(dirname(__FILE__)) . '/constant.php';
       
        Ar::import(AR_CORE_PATH . 'alias.func.php');

        if (AR_ORI_ACTUAL_NAME == '.') {
            exit('start mode is not found');
        }
        comp('url.skeleton')->parseGlobalAson();

        $loader->add(AR_ORI_ACTUAL_NAME, dirname(AR_ORI_PATH));

        // if (AR_AS_WEB) :
        set_exception_handler('\\ar\\core\\Ar::exceptionHandler');
        set_error_handler('\\ar\\core\\Ar::errorHandler');
        register_shutdown_function('\\ar\\core\\Ar::shutDown');
        // endif;

        if (!AR_DEBUG) :
            error_reporting(0);
        else:
            \ar\core\comp('ext.out')->deBug('[START]');
        endif;
        
        // 子项目目录
        defined('AR_PUBLIC_CONFIG_PATH') or define('AR_PUBLIC_CONFIG_PATH', AR_ROOT_PATH . 'cfg' . DS . AR_ORI_ACTUAL_NAME . DS);
        // if (AR_AS_WEB || AR_AS_WEB_CLI) :

        if (!self::is_cli_mode()) {
            // 目录生成
            Ar::c('url.skeleton')->generate();
        } else {
            // 其他模块加载启动配置
        }

        // 公共配置
        if (!is_file(AR_PUBLIC_CONFIG_PATH . 'base.php')) :
            echo 'config file not found : ' . AR_PUBLIC_CONFIG_PATH . 'base.php';
            exit;
        endif;

        $globalConfig = \ar\core\comp('format.format')->arrayMergeRecursiveDistinct(
            self::getConfig(),
            Ar::import(AR_PUBLIC_CONFIG_PATH . 'base.php')
        );
        self::setConfig('', $globalConfig);

        // 引入新配置文件
        if (AR_PUBLIC_CONFIG_FILE && is_file(AR_PUBLIC_CONFIG_FILE)) :
            $otherConfig = include_once AR_PUBLIC_CONFIG_FILE;
            if (is_array($otherConfig)) :
                Ar::setConfig('', \ar\core\comp('format.format')->arrayMergeRecursiveDistinct(Ar::getConfig(), $otherConfig));
            endif;
        endif;

        // 扩展的模式
        if (AR_OUTER_START || AR_AS_TIMER || AR_AS_RUNNER || $startServerConfig) :
            self::$_config = \ar\core\comp('format.format')->arrayMergeRecursiveDistinct(
                Ar::import(AR_CONFIG_PATH . 'default.php', true),
                self::$_config
            );
            // 定时器
            if (AR_AS_TIMER) {
                $worker = new \Workerman\Worker();
                $worker->count = $startServerConfig['count'];
                $worker->onWorkerStart = $startServerConfig['func'];
                // 运行worker
                \Workerman\Worker::runAll();
            }

            if ($startServerConfig) {
                if ($startServerConfig['type'] == 'websocket') {
                    $ws_worker = new \Workerman\Worker($startServerConfig['bind']);
                    $ws_worker->count = $startServerConfig['count'];
                    $ws_worker->onMessage = $startServerConfig['onMessage'];
                    $ws_worker->onConnect = $startServerConfig['onConnect'];
                    $ws_worker->onClose = $startServerConfig['onClose'];
                    $ws_worker->onWorkerStart = $startServerConfig['func'];
                    // 运行worker
                    \Workerman\Worker::runAll();
                }
            }
            return;
        else :
            // 命令行模式
            if (!AR_RUN_AS_SERVICE_HTTP && self::is_cli_mode()) {
                // exit('cli mode is not allowd here');
            }
            // 路由解析
            Ar::c('url.route')->parse();
        endif;
        self::$_config = \ar\core\comp('format.format')->arrayMergeRecursiveDistinct(
            Ar::import(AR_CONFIG_PATH . 'default.php', true),
            self::$_config
        );

        if (!AR_AS_OUTER_FRAME) :
            spl_autoload_register('self::autoLoader');
        endif;
            
        \ar\core\App::run();
        \ar\core\App::close();
    }

    // is cli mode
    static public function is_cli_mode() 
    {
        $sapi_type = php_sapi_name();
        if (isset($sapi_type) && substr($sapi_type, 0, 3) == "cli") {
            return true;
        } else {
            return false;
        }
    }

    // 开启ar workerman支持
    static public function startWorkermanWebServer($config)
    {
        define('AR_IN_WORKERMAN', true);
        // 0.0.0.0 代表监听本机所有网卡，不需要把0.0.0.0替换成其它IP或者域名
        // 这里监听8080端口，如果要监听80端口，需要root权限，并且端口没有被其它程序占用
        $webserver = new \Workerman\WebServer($config['bind']);
        // 类似nginx配置中的root选项，添加域名与网站根目录的关联，可设置多个域名多个目录
        $webserver->addRoot($config['host'], ['root' => $config['root'], 'entry' => $config['entry']]);
        // 设置开启多少进程
        $webserver->count = $config['count'];
        \Workerman\Worker::runAll();
    }

    /**
     * set application.
     *
     * @param string $key key.
     * @param string $val key value.
     *
     * @return void
     */
    static public function setA($key, $val)
    {
        $classkey = strtolower($key);
        self::$_a[$classkey] = $val;

    }

    /**
     * get global config.
     *
     * @param string $ckey          key.
     * @param mixed  $defaultReturn default return value.
     *
     * @return mixed
     */
    static public function getConfig($ckey = '', $defaultReturn = array())
    {
        $rt = array();

        if (empty($ckey)) :
            $rt = self::$_config;
        else :
            if (strpos($ckey, '.') === false) :
                if (isset(self::$_config[$ckey])) :
                    $rt = self::$_config[$ckey];
                else :
                    if (func_num_args() > 1) :
                        $rt = $defaultReturn;
                    else :
                        $rt = null;
                    endif;
                endif;
            else :
                $cE = explode('.', $ckey);
                $rt = self::$_config;
                // 0 判断
                while (($k = array_shift($cE)) || is_numeric($k)) :
                    if (!isset($rt[$k])) :
                        if (func_num_args() > 1) :
                            $rt = $defaultReturn;
                        else :
                            $rt = null;
                        endif;
                        break;
                    else :
                        $rt = $rt[$k];
                    endif;
                endwhile;
            endif;

        endif;

        return $rt;

    }

    /**
     * set config.
     *
     * @param string $ckey  key.
     * @param mixed  $value value.
     *
     * @return void
     */
    static public function setConfig($ckey = '', $value = array())
    {
        if (!empty($ckey)) :
            if (strpos($ckey, '.') === false) :
                self::$_config[$ckey] = $value;
            else :
                $cE = explode('.', $ckey);
                $rt = self::$_config;
                $nowArr = array();
                $length = count($cE);
                for ($i = $length - 1; $i >= 0; $i--) :
                    if ($i == $length - 1) :
                        $nowArr = array($cE[$i] => $value);
                    else :
                        $tem = $nowArr;
                        $nowArr = array();
                        $nowArr[$cE[$i]] = $tem;
                    endif;
                endfor;
                self::$_config = \ar\core\comp('format.format')->arrayMergeRecursiveDistinct(
                    self::$_config,
                    $nowArr
                );
            endif;
        else :
            self::$_config = $value;
        endif;

    }

    /**
     * get application.
     *
     * @param string $akey key.
     *
     * @return mixed
     */
    static public function a($akey)
    {
        $akey = strtolower($akey);
        return isset(self::$_a[$akey]) ? self::$_a[$akey] : null;

    }

    /**
     * get component.
     *
     * @param string $cname component.
     *
     * @return mixed
     */
    static public function c($cname)
    {
        $cKey = strtolower($cname);

        if (!isset(self::$_c[$cKey])) :
            $config = self::getConfig('components.' . $cKey . '.config', array());
            self::setC($cKey, $config);
        endif;

        return self::$_c[$cKey];

    }

    /**
     * set component.
     *
     * @param string $component component name.
     * @param array  $config    component config.
     *
     * @return void
     */
    static public function setC($component, array $config = array())
    {
        $cKey = strtolower($component);
        if (isset(self::$_c[$cKey])) :
            return false;
        endif;

        $cArr = explode('.', $component);

        $cArr = array_map('ucfirst', $cArr);

        $className = 'ar\\comp\\' . implode('\\', $cArr);

        self::$_c[$cKey] = call_user_func_array("$className::init", array($config, $className));

    }

    /**
     * autoload register.
     *
     * @param string $class class.
     *
     * @return mixed
     */
    static public function autoLoader($class)
    {
        // $class = str_replace('\\', DS, $class);
        $posNameSpace = strrpos($class, '\\');
        if ($posNameSpace !== false) :
            // $class = substr($class, $posNameSpace + 1);
            return self::loadByNameSpace($class);
        endif;
    }

    // loadByNameSpace
    static function loadByNameSpace($class)
    {
        if (strpos($class, 'ar\\') === 0) :
            $class = str_replace('ar\\', '', $class);
            $classFile = AR_FRAME_PATH . str_replace('\\', DS, $class) . '.php';
        else :
            if (\ar\core\cfg('AR_DS_NAME')) {
                $ds_name = \ar\core\cfg('AR_DS_NAME');
                $ds_cfg = \ar\core\cfg('AR_DS_CFG.' . $ds_name);
                $classFile = $ds_cfg['ROOT_PATH'] . str_replace('\\', DS, $class) . '.php';
            } else {
                $classFile = AR_ORI_PATH . str_replace('\\', DS, $class) . '.php';
            }
        endif;

        if (is_file($classFile)) :
            include_once $classFile;
        else :
            if (strpos($class, '\Redirect') === false) {
                
                if (AR_IN_WORKERMAN) {
                    $msg = 'class : ' . $class . ' does not exist !';
                    // \Workerman\Protocols\Http::end($msg);
                    echo $msg;
                    return;
                } else {
                    trigger_error('class : ' . $class . ' does not exist !', E_USER_ERROR);
                    exit;
                }
               
            } else {
                throw new \ar\core\Exception('class : ' . $class . ' does not exist !', 1002);
            }
           
        endif;

    }

    /**
     * set autoLoad path.
     *
     * @param string $path path.
     *
     * @return void
     */
    static public function importPath($path)
    {
        // array_push(self::$autoLoadPath, rtrim($path, DS) . DS);
        $inkey = rtrim($path, DS) . DS;
        if (in_array($inkey, self::$autoLoadPath)) :
            foreach (self::$autoLoadPath as $ink => $path) :
                if ($path == $inkey) :
                    unset(self::$autoLoadPath[$ink]);
                    break;
                endif;
            endforeach;
        endif;
        array_unshift(self::$autoLoadPath, $inkey);

    }

    /**
     * import file or path.
     *
     * @param string  $path     import path.
     * @param boolean $allowTry allow test exist.
     *
     * @return mixed
     */
    static public function import($path, $allowTry = false)
    {
        static $holdFile = array();

        if (strpos($path, DS) === false) :
            $fileName = str_replace(array('c.', 'ext.', 'app.', '.'), array('Controller.', 'Extensions.', rtrim(AR_ROOT_PATH, DS) . '.', DS), $path) . '.class.php';
        else :
            $fileName = $path;
        endif;

        if (is_file($fileName)) :
            if (substr($fileName, (strrpos($fileName, '.') + 1)) == 'ini') :
                $config = parse_ini_file($fileName, true);
                if (empty($config)) :
                    $config = array();
                endif;
                return $config;
            else :
                $file = include_once $fileName;
                if ($file === true) :
                    return $holdFile[$fileName];
                else :
                    $holdFile[$fileName] = $file;
                    return $file;
                endif;
            endif;
        else :
            if ($allowTry) :
                return array();
            else :
                throw new \ar\core\Exception('import not found file :' . $fileName);
            endif;
        endif;

    }

    // import class
    public static function importClass($className, $frompath = AR_ROOT_PATH)
    {
        $classFile = $frompath . str_replace('\\', DS, $className) . '.php';
        if (is_file($classFile)) :
            include_once $classFile;
        else :
            return false;
        endif;

    }

    /**
     * exception handler.
     *
     * @param object $e Exception.
     *
     * @return void
     */
    static public function exceptionHandler($exception)
    {
        if (get_class($exception) === '\ar\core\ServiceException') :
            \ar\core\comp('rpc.service')->response(array('SYSTEM_ERROR' => 1, 'errMsg' => $exception->getMessage()));
            exit;
        endif;

        if (AR_DEBUG && !AR_AS_CMD) :
            echo '<div style="color: #8a6d3b;background-color: #fcf8e3;border-color: #faebcc;padding: 15px;margin-bottom: 20px;border: 1px solid transparent;border-radius: 4px">';
            echo '<b style="color:#ec8186;">' . get_class($exception) . ',code:'. $exception->getCode() .'</b> : ' . $exception->getMessage();
            echo $exception->getMessage() . '<br>';
            echo 'Stack trace:<pre>' . $exception->getTraceAsString() . '</pre>';
            echo 'thrown in <b>' . $exception->getFile() . '</b> on line <b>' . $exception->getLine() . '</b><br>';
            echo '</div>';
        endif;

    }

    /**
     * error handler.
     *
     * @param string $errno   errno.
     * @param string $errstr  error msg.
     * @param string $errfile error file.
     * @param string $errline error line.
     *
     * @return mixed
     */
    static public function errorHandler($errno, $errstr, $errfile, $errline)
    {
        if (AR_DEBUG) {
            var_dump('err handler:', [$errno, $errstr, $errfile, $errline]);
        }
        \ar\core\comp('tools.log')->record([$errno, $errstr, $errfile, $errline], 'server.error');
        return false;
        if (AR_RUN_AS_SERVICE_HTTP) :
            \ar\core\comp('rpc.service')->response(array('error_code' => '1011', 'error_msg' => $errstr));
            exit;
        else:
            return false;
        endif;

        if (!AR_DEBUG || !(error_reporting() & $errno)) :
            return;
        endif;

        $errMsg = '';
        // 服务器级别错误
        $serverError = false;
        switch ($errno) {
        case E_USER_ERROR:
            $errMsg .= "<b style='color:red;'>ERROR</b> [$errno] $errstr<br />\n";
            $errMsg .= "  Fatal error on line $errline in file $errfile";
            $errMsg .= ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
            // header("http/1.1 404 Not Found:" . $errMsg);
            $serverError = true;
            break;

        case E_USER_WARNING:
            $errMsg .= "<b style='color:#ec8186;'>WARNING</b> [$errno] $errstr<br />\n";
            $errMsg .= " on line $errline in file $errfile <br />\n";
            break;

        case E_USER_NOTICE:
        case E_NOTICE:
            $errMsg .= "<b style='color:#ec8186;'>NOTICE</b> [$errno] $errstr<br />\n";
            $errMsg .= " on line $errline in file $errfile <br />\n";
            break;

        default:
            $errMsg .= "<b style='color:#ec8186;'>Undefined error</b> : [$errno] $errstr";
            $errMsg .= " on line $errline in file $errfile <br />\n";
            break;
        }
        if ($errMsg) :
            if (\ar\core\cfg('DEBUG_SHOW_TRACE')) :
                \ar\core\comp('ext.out')->deBug($errMsg, 'TRACE');
            else :
                if (\ar\core\cfg('DEBUG_SHOW_ERROR')) :
                    if ($serverError === true) :
                        \ar\core\comp('ext.out')->deBug($errMsg, 'SERVER_ERROR');
                    else :
                        \ar\core\comp('ext.out')->deBug($errMsg, 'ERROR');
                    endif;
                else :
                   
                    exit($errMsg);
                endif;
            endif;
        endif;

        return true;

    }

    /**
     * shutDown function.
     *
     * @return void
     */
    public static function shutDown()
    {
        if (AR_RUN_AS_SERVICE_HTTP) :
            return;
        endif;

        if (AR_DEBUG && !AR_AS_CMD) :
            if (\ar\core\cfg('DEBUG_SHOW_EXCEPTION')) :
                \ar\core\comp('ext.out')->deBug('', 'EXCEPTION', true);
            endif;

            if (\ar\core\cfg('DEBUG_SHOW_ERROR')) :
                \ar\core\comp('ext.out')->deBug('', 'ERROR', true);
                \ar\core\comp('ext.out')->deBug('', 'SERVER_ERROR', true);
            endif;

            if (\ar\core\cfg('DEBUG_SHOW_TRACE'))  :
                \ar\core\comp('ext.out')->deBug('[SHUTDOWN]', 'TRACE', true);
            endif;
        endif;

    }

}

<?php
namespace ar\core;
use ar\core\Ar as Ar;
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
 * component holder.
 *
 * @param string $name cname.
 *
 * @return Object
 */
function comp($name = '')
{
    return Ar::c($name);

}

/**
 * alas to cfg.
 *
 * @param string $name key of config.
 *
 * @return mixed
 */
function cfg($name = '', $default = 'NOT_RGI')
{
    if ($default === 'NOT_RGI') :
        return Ar::getConfig($name);
    else :
        return Ar::getConfig($name, $default);
    endif;

}

/**
 * route holder. \ar\core\url => url
 *
 * @param string $name    route path.
 * @param mixed  $params  route param.
 * @param string $urlMode url mode.
 *
 * @return string
 */
function url($name = '', $params = array(), $urlMode = 'NOT_INIT')
{
    return \ar\core\comp('url.route')->createUrl($name, $params, $urlMode);

}

/**
 * \ar\core\module.
 *
 * @param string $name moduleName.
 *
 * @return Module
 */
function module($name = '')
{
    static $moduleList = array();

    $name = str_replace('.', '\\', $name);
    $moduleKey = $name;

    if (!array_key_exists($moduleKey, $moduleList)) :
        if (AR_DEBUG && !AR_AS_CMD) :
            \ar\core\comp('ext.out')->deBug('|MODULE_INIT:' . $moduleKey .'|');
        endif;
        $moduleClassName = AR_ORI_ACTUAL_NAME . '\lib\\module\\' . $name;
        $moduleList[$moduleKey] = new $moduleClassName;

        if (is_callable(array($moduleList[$moduleKey], 'initModule'))) :
            call_user_func_array(array($moduleList[$moduleKey], 'initModule'), array());
        endif;
    endif;
    if (AR_DEBUG && !AR_AS_CMD) :
        \ar\core\comp('ext.out')->deBug('|MODULE_EXEC:' . $moduleKey .'|');
    endif;
    return $moduleList[$moduleKey];

}


/**
 * filter $_GET.
 *
 * @param string $key     get key.
 * @param mixed  $default return value.
 *
 * @return mixed
 */
function get($key = '', $default = null)
{
    $getUrlParamsArray = \ar\core\comp('url.route')->parseGetUrlIntoArray();
    $ret = array();

    if (empty($key)) :
        $ret = $getUrlParamsArray;
    else :
        if (!isset($getUrlParamsArray[$key])) :
            $ret = null;
        else :
            $ret = $getUrlParamsArray[$key];
        endif;
    endif;

    $ret = \ar\core\comp('format.format')->addslashes($ret);
    if (is_numeric($ret) && $ret < 2147483647 && strlen($ret) == 1) :
        $ret = (int)$ret;
    elseif (empty($ret)) :
        $ret = $default;
    endif;

    return \ar\core\comp('format.format')->trim($ret);

}

/**
 * filter $_POST.
 *
 * @param string $key     post key.
 * @param mixed  $default return value.
 *
 * @return mixed
 */
function post($key = '', $default = null)
{
    $ret = array();

    if (empty($key)) :
        $ret = $_POST;
    else :
        if (!isset($_POST[$key])) :
            $ret = $default;
        else :
            $ret = $_POST[$key];
        endif;
    endif;

    return \ar\core\comp('format.format')->addslashes(\ar\core\comp('format.format')->trim($ret));

}

/**
 * filter $_REQUEST 有缓冲.
 *
 * @param string $key      post      key.
 * @param mixed  $default  return    value.
 * @param array  $addArray add merge array.
 *
 * @return mixed
 */
function request($key = '', $default = null, $addArray = array())
{
    $request = \ar\core\comp('url.route')->staticMark['requestUrlParamArray'];
    if (empty($request) || !empty($addArray)) :
        if (!is_array($addArray)) :
            $addArray = array();
        endif;
        if (!AR_AS_WEB_CLI) :
            $getArr = \ar\core\get('', array());
            $postArr = \ar\core\post('', array());
            $request = array_merge($getArr, $postArr, $addArray);
        else :
            $request = $addArray;
        endif;
        $request = \ar\core\comp('format.format')->addslashes(\ar\core\comp('format.format')->trim($request));
        \ar\core\comp('url.route')->staticMark['requestUrlParamArray'] = $request;
    endif;

    if ($key) :
        if (array_key_exists($key, $request)) :
            $ret = $request[$key];
        else :
            $ret = $default;
        endif;
    else :
        $ret = $request;
    endif;

    return $ret;
}

// service
function service($name, $params = [])
{
    if ($ds_name = \ar\core\cfg('AR_DS_NAME')) {
        $ds_cfg = \ar\core\cfg('AR_DS_CFG.' . $ds_name);
        $dsClassName = $ds_name . '.' . $ds_cfg['MODULE_NAME'] . '.' . $name;
        return d_service($dsClassName, $params);
    }

    static $serviceHandler = [];
    if (strpos($name, '.') === false) {
        $serviceClassName = AR_ORI_ACTUAL_NAME . '\ctl\\' . cfg('requestRoute.a_m', AR_DEFAULT_APP_NAME) . '\\' . 'service\\' . $name;
    } else {
        $serviceNameMapArr = explode('.', $name);
        if (count($serviceNameMapArr) == 2) {
            list($mdName, $name) = explode('.', $name);
            $serviceClassName = AR_ORI_ACTUAL_NAME . '\ctl\\' . $mdName . '\\' . 'service\\' . $name;
        } else if (count($serviceNameMapArr) == 3) {
            $serviceClassName = $serviceNameMapArr[0] . '\ctl\\' . $serviceNameMapArr[1] . '\\' . 'service\\' . $serviceNameMapArr[2];
        } else {
            throw new Exception("Service " . $name . ' invalid ', 1005);
        }
    }
    
    if (!isset($serviceHandler[$serviceClassName])) :
        $plength = count($params);
        try {
            if ($plength == 0) :
                $serviceHandler[$serviceClassName] = new $serviceClassName();
            elseif ($plength == 1) :
                $serviceHandler[$serviceClassName] = new $serviceClassName($params[0]);
            elseif ($plength == 2) :
                $serviceHandler[$serviceClassName] = new $serviceClassName($params[0], $params[1]);
            elseif ($plength == 3) :
                $serviceHandler[$serviceClassName] = new $serviceClassName($params[0], $params[1], $params[2]);
            endif;
        } catch (Exception $e) {
            throw new Exception("Service " . $serviceClassName . ' not found ', 1004);
        }
    endif;
    if (is_callable([$serviceHandler[$serviceClassName], 'init'])) {
        call_user_func_array([$serviceHandler[$serviceClassName], 'init'], []);
    }
    return $serviceHandler[$serviceClassName];
}

// data service
function d_service($name, $params = [])
{
    list($projectName, $moduleName, $serviceName) = explode('.', $name);

    if (\ar\core\cfg('AR_DS_NAME')) {
        \ar\core\cfg('AR_PRE_DS_NAME', \ar\core\cfg('AR_DS_NAME'));
    }

    \ar\core\Ar::setConfig('AR_DS_NAME', $projectName);

    $ds_dir = dirname(AR_ROOT_PATH) . '/' . $projectName . '/';
    $ds_ason_file = $ds_dir . 'ar.ason';
    if (!file_exists($ds_ason_file)) {
        throw new \ar\core\ArException('Project "' . $projectName . '" is not an ar ds project', 1);
    }
    $ason_cfg = json_decode(file_get_contents($ds_ason_file), 1);
    $ds_ori_name = $ason_cfg['AR_ORI_ACTUAL_NAME'];
    \ar\core\Ar::setConfig('AR_DS_CFG.' . $projectName, [
        'ROOT_PATH' => $ds_dir,
        'MODULE_NAME' => $moduleName,
        'ORI_NAME' => $ds_ori_name,
    ]);

    static $serviceHandler = [];
    $serviceClassName = $ds_ori_name . '\ctl\\' . $moduleName . '\\' . 'service\\' . $serviceName;

    if (!isset($serviceHandler[$serviceClassName])) :
        $plength = count($params);
        try {
            if ($plength == 0) :
                $serviceHandler[$serviceClassName] = new $serviceClassName();
            elseif ($plength == 1) :
                $serviceHandler[$serviceClassName] = new $serviceClassName($params[0]);
            elseif ($plength == 2) :
                $serviceHandler[$serviceClassName] = new $serviceClassName($params[0], $params[1]);
            elseif ($plength == 3) :
                $serviceHandler[$serviceClassName] = new $serviceClassName($params[0], $params[1], $params[2]);
            endif;
        } catch (Exception $e) {
            throw new Exception("Service " . $serviceClassName . ' not found ', 1004);
        }
    endif;
    if (is_callable([$serviceHandler[$serviceClassName], 'init'])) {
        call_user_func_array([$serviceHandler[$serviceClassName], 'init'], []);
    }

    if (\ar\core\cfg('AR_PRE_DS_NAME')) {
        \ar\core\cfg('AR_DS_NAME', \ar\core\cfg('AR_PRE_DS_NAME'));
    }

    return $serviceHandler[$serviceClassName];
}

// 直接加载页面
function loadPage($module, $params = [])
{
    $r = \ar\core\cfg('requestRoute');
    $route = explode('/', $module);
    $requestRoute = array(
        'a_m' => \ar\core\cfg('requestRoute.a_m'),
        'a_c' => $route[0],
        'a_a' => $route[1],
    );
    \ar\core\Ar::a('\ar\core\ApplicationWeb')->runController($requestRoute, $params);
    \ar\core\Ar::setConfig('requestRoute', $r);
}

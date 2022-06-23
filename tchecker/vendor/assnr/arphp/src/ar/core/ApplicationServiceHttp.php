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
 * class \ar\core\ApplicationServiceHttp
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
class ApplicationServiceHttp extends ApplicationService
{
    /**
     * extend abstract func.
     *
     * @return void
     */
    public function start()
    {
        try  {
            $data = $this->parseHttpServiceHanlder();
            list($namespace, $oriname, $moudule, $ctlname) = explode('.', $data['class']);
            $ctlname = ucfirst($ctlname);
            $data['class'] = implode('.', [$namespace, $oriname, $moudule, $ctlname]);
            $router = [
                'a_a' => $data['method'],
                'a_c' => $ctlname,
                'a_m' => $moudule
            ];
            \ar\core\Ar::setConfig('requestRoute', $router);
            \ar\core\Ar::setConfig('DIR.LOG', AR_DATA_PATH . 'log' . DS . AR_ORI_ACTUAL_NAME . DS . \ar\core\cfg('requestRoute.a_m') . DS);
            return $this->runService($data);
        } catch (\Exception $e) {
            \ar\core\comp('tools.log')->record(['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()], 'server.exception');
            return \ar\core\comp('rpc.service')->response(['SYSTEM_ERROR' => 1, 'errMsg' => $e->getMessage()]);
        }
    }

    /**
     * parse hanlder.
     *
     * @return mixed
     */
    public function parseHttpServiceHanlder()
    {
        // 开启跨域
        if (AR_IN_WORKERMAN) {
            \Workerman\Protocols\Http::header('Access-Control-Allow-Origin:*');
        } else {
            header('Access-Control-Allow-Origin:*');
        }

        if ($ws = \ar\core\request('ws')) :
            if (!$ws = \ar\core\comp('rpc.service')->decrypt($ws)) :
                throw new \ar\core\ServiceException('ws query format incorrect error');
            endif;

            if (empty($ws['class']) || empty($ws['method']) || !isset($ws['param'])) :
                throw new \ar\core\ServiceException('ws query param missing error');
            endif;

            return array(
                'class' => $ws['class'],
                'method' => $ws['method'],
                'param' => $ws['param'],
                'authSign' => $ws['authSign'],
                'CLIENT_SERVER' => $ws['CLIENT_SERVER'],
            );

        else :
            throw new \ar\core\ServiceException('ws query ws info missing error');
        endif;

    }

    /**
     * service exec.
     *
     * @param array $ws ws param.
     *
     * @return mixed
     */
    protected function runService($ws = array())
    {
        $service = '\\' . str_replace('.', '\\',$ws['class']) . 'Service';
        $method = $ws['method'] . 'Worker';
        $param = $ws['param'];

        try {
            $serviceHolder = new $service;
            \ar\core\Ar::setConfig('CLIENT_REQUEST', $ws);
            list(,,$moudule,) = explode('.', $ws['class']);
            
              // 引入新配置文件
            $mouduleConfigFile = AR_PUBLIC_CONFIG_PATH . $moudule . '.php';
            if (is_file($mouduleConfigFile)) :
                $otherConfig = include_once $mouduleConfigFile;
                if (is_array($otherConfig)) :
                    Ar::setConfig('', \ar\core\comp('format.format')->arrayMergeRecursiveDistinct(Ar::getConfig(), $otherConfig));
                endif;
            endif;

            $serviceHolder->init($ws);
            
            if (!is_callable(array($serviceHolder, $method))) :
                throw new \ar\core\ServiceException('ws service do not hava a method ' . $method);
            endif;

            if ($param == '' || $param == "[]" || $param == "[\"\"]") {
                $param = [];
            } else {
                if (is_string($param)) {
                    $param = json_decode($param, true);
                }
            }

            $ret = call_user_func_array(array($serviceHolder, $method), $param);
            return $ret;
        } catch(\ar\core\ServiceException $e) {
            throw new \ar\core\ServiceException($e->getMessage());
        }
    }

}

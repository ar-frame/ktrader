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
            $router = [
                'a_a' => $data['method'],
                'a_c' => $ctlname,
                'a_m' => $moudule
            ];
            \ar\core\Ar::setConfig('requestRoute', $router);
            \ar\core\Ar::setConfig('DIR.LOG', AR_DATA_PATH . 'log' . DS . AR_ORI_ACTUAL_NAME . DS . \ar\core\cfg('requestRoute.a_m') . DS);
            return $this->runService($data);
        } catch (\ar\core\ServiceException $e) {
            return \ar\core\comp('rpc.service')->response($e->getMessage());
        }
    }

    /**
     * parse hanlder.
     *
     * @return mixed
     */
    public function parseHttpServiceHanlder()
    {
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
            $serviceHolder->init($ws);

            \ar\core\Ar::setConfig('CLIENT_REQUEST', $ws);

            if (!is_callable(array($serviceHolder, $method))) :
                throw new \ar\core\ServiceException('ws service do not hava a method ' . $method);
            endif;
            return call_user_func_array(array($serviceHolder, $method), $param);
        } catch(\ar\core\ServiceException $e) {
            
            throw new \ar\core\ServiceException($e->getMessage());
        }
    }

}

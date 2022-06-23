<?php

namespace server\ctl\arcz;
use \ar\core\Controller as Controller;

/**
 * web service
 */
class WebService extends BaseService
{

    /**
     * getHostInfoByMark
     *
     * <pre>
        --主要字段说明
      
        --
    </pre>
     *
     * getHostInfoByMark
        try {
            // 接口名称
            $apiname = 'Ws'.'server.ctl.arcz.Web';
            $res = \ar\core\comp('rpc.service')->$apiname("getHostInfoByMark", [$mark]);
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param string $mark mark
     * 
     * @author abcd0869 <abcd0869@gmail.com>
     *
     * @apiname getHostInfoByMark
     *
     * @return void
     */
    public function getHostInfoByMarkWorker($mark)
    {
        $res = \ar\core\service('server.arcz.Web')->getHostInfoByMark($mark);
        $this->response($res);
    }


    /**
     * copySiteInfo
     *
     * <pre>
        --主要字段说明
      
        --
    </pre>
     *
     * copySiteInfo
        try {
            // 接口名称
            $apiname = 'Ws'.'server.ctl.arcz.Web';
            $res = \ar\core\comp('rpc.service')->$apiname("copySiteInfo", [$infoid]);
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param string $mark mark
     * 
     * @author abcd0869 <abcd0869@gmail.com>
     *
     * @apiname copySiteInfo
     *
     * @return void
     */
    
    public function copySiteInfoWorker($infoid)
    {
        $res = \ar\core\service('server.arcz.Web')->copySiteInfo($infoid);
        $this->response($res);
    }

}
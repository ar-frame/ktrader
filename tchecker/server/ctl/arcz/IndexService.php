<?php

namespace server\ctl\arcz;
use \ar\core\Controller as Controller;

/**
 * 系统参数
 */
class IndexService extends BaseService
{

    /**
     * 获取系统信息
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.Index';
            $res = \ar\core\comp('rpc.service')->$apiname("systemSetting", array());
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 获取系统信息
     *
     * @return object
     */
    public function systemSettingWorker()
    {
        $res = \ar\core\service('arcz.Index')->systemSetting();
        $this->response($res);
    }

    /**
     * 修改系统参数
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.Index';
            $res = \ar\core\comp('rpc.service')->$apiname("editSetting", array($data, $uk, $ip));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param  array   $data  数据
     * @param  string  $uk    uk
     * @param  string  $ip    ip
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 修改系统参数
     *
     * @return object
     */
    public function editSettingWorker($data, $uk, $ip)
    {
        $res = \ar\core\service('arcz.Index')->systemSettingEdit($data, $uk, $ip);
        $this->response($res);
    }

}

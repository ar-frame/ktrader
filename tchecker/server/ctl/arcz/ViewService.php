<?php

namespace server\ctl\arcz;
use \ar\core\Controller as Controller;

/**
 * 样式数据
 */
class ViewService extends BaseService
{

    /**
     * 系统设定信息
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.View';
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
     * @apiname 系统设定信息
     *
     * @return object
     */
    public function systemSettingWorker()
    {
        $res = \ar\core\service('arcz.View')->getSystemSetting();
        $this->response($res);
    }

    /**
     * 设定登录背景颜色
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.View';
            $res = \ar\core\comp('rpc.service')->$apiname("loginBg", array($num));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     *
     * @param  $num  int  编号
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 设定登录背景颜色
     *
     * @return object
     */
    public function loginBgWorker($num)
    {
        $res = \ar\core\service('arcz.View')->setLoginBg($num);
        $this->response($res);
    }

}

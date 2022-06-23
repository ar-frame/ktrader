<?php

namespace server\ctl\arcz;
use \ar\core\Controller as Controller;

/**
 * 登录
 */
class LoginService extends BaseService
{

    public function init($data)
    {

    }

    /**
     * 登录验证接口
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.Login';
            $res = \ar\core\comp('rpc.service')->$apiname("loginApi",array ($userName, $password, $login_ip));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param  string   $userName  userName
     * @param  string   $password  password
     * @param  string   $login_ip  loginip
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 登录验证接口
     *
     * @return void
     */
    public function loginApiWorker($userName, $password, $login_ip)
    {
        $res = \ar\core\service('arcz.User')->login($userName, $password, $login_ip);

        $this->response($res);
    }

    /**
     * 退出
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.Login';
            $res = \ar\core\comp('rpc.service')->$apiname("loginOut",array ($uk));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param  string   $uk  uk
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 退出
     *
     * @return void
     */
    public function loginOutWorker($uk)
    {
        $res = \ar\core\service('arcz.User')->loginOut($uk);

        $this->response($res);
    }


}

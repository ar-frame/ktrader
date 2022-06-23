<?php
/**
 * 前端基于layuicms2.0 ，后端基于arphp 5.1.14
 *
 * @author assnr assnr@coopcoder.com
 *
 * 本项目仅供学习交流使用，如果用于商业请联系授权
 */
namespace arcz\ctl\main;
use \ar\core\ApiController as Controller;

/**
 * 控制器
 */
class Login extends Controller
{
    // 设置登录sessionUK
    public function setSessionUK()
    {
        $data = \ar\core\post();
        $uk = $data['uk'];

        $set = $this->getUserService()->setUK($uk);

        if ($set) {
            $this->showJsonSuccess('设置成功');
        } else {
            $this->showJsonError('设置失败', '1002');
        }
    }

    // 判断验证码
    public function getCode()
    {
        $code = $this->getUserService()->getCode();
        $data = \ar\core\post();
        $logincode = $data['logincode'];
        if($logincode==$code){
            $this->showJsonSuccess('验证码正确');
        } else {
            $this->showJsonError('验证码错误', '1002');
        }
    }

    // 登陆页面
    public function login()
    {
        if ($user = \ar\core\comp('lists.session')->get('ukey')) {
            $this->redirect('/index');
        }

        try {
            // 系统信息
            $apiname2 = 'Ws'.'server.ctl.arcz.Index';
            $systemInfo = \ar\core\comp('rpc.service')->$apiname2("systemSetting", array());
            $this->assign(['systemLoginInfo' => $systemInfo]);
            $this->display('/login/login');
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
    }

    // 获取当前ip
    public function getLoginIp()
    {
        $ip = \ar\core\comp('tools.Util')->getClientIp();
        $this->showJson(['login_ip' => $ip]);
    }

    // 生成验证码图片
    public function code()
    {
        return $this->getUserService()->generateCode();
    }

    // 退出
    public function loginout()
    {
        $uk = $this->getUserService()->getUk();
        try {
            // 登录用户信息
            $apiname = 'Ws'.'server.ctl.arcz.Login';
            $out = \ar\core\comp('rpc.service')->$apiname("loginOut",array ($uk));
            if($out){
                $this->getUserService()->cleanUK();
                $this->redirect('login');
            }
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
    }
}

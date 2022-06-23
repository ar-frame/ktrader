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
 * 基类控制器
 */
class Base extends Controller
{
    // 公用方法
    public function init()
    {
        ini_set('date.timezone','Asia/Shanghai'); // 'Asia/Shanghai' 为上海时区
        // 登录验证
        $uk = \ar\core\comp('lists.session')->get('ukey');
        if (!$uk) {
            $this->redirect('login/login');
        } else {
            try {
                // 登录用户信息
                $apiname = 'Ws'.'server.ctl.arcz.User';
                $loginUser = \ar\core\comp('rpc.service')->$apiname("loginUser", array($uk));

                // 系统信息
                $apiname2 = 'Ws'.'server.ctl.arcz.Index';
                $systemInfo = \ar\core\comp('rpc.service')->$apiname2("systemSetting", array());

                $_SERVER['REQUEST_URI'];

                // 是否开发者
                $isDev = $loginUser['isDev'];

                // 系统设置页面地址
                $href = "systems/setSystem";

                $apinameNav = 'Ws'.'server.ctl.arcz.Nav';
                if($isDev > 0){
                    $topNavs = \ar\core\comp('rpc.service')->$apinameNav("findMenu", array());
                } else {
                    // 用户能访问的所有顶级菜单id
                    $topid = \ar\core\comp('rpc.service')->$apiname("getUserTop", array($uk));
                    // 用户能访问的所有菜单id
                    $navsid = \ar\core\comp('rpc.service')->$apiname("getUserRole", array($uk));
                    $topNavs = \ar\core\comp('rpc.service')->$apinameNav("findUserMenu", array($topid, $navsid));
                }

                // 是否能访问系统设置
                $apiname = 'Ws'.'server.ctl.arcz.Specialized';
                $isQuerySet = \ar\core\comp('rpc.service')->$apiname("queryMenuByHref",array ($href, $uk));
                if($isQuerySet){
                    $setSys = 1;
                } else {
                    $setSys = 0;
                }

                $loginIpNow = \ar\core\comp('tools.Util')->getClientIp();

                $this->assign(['topMenu' => $topNavs['top'], 'topCont' => $topNavs['cont']]);
                $this->assign(['setSys' => $setSys]);
                $this->assign(['firstId' => $topNavs['top'][0]]);
                $this->assign(['user' => $loginUser]);
                $this->assign(['systemInfo' => $systemInfo]);
                $this->assign(['loginIpNow' => $loginIpNow]);
                $this->assign(['userAuthKeyNow' => $uk]);
            } catch (\ar\core\Exception $e) {
                // todos 异常处理
                echo $e->getMessage();
            }

        }

    }
}

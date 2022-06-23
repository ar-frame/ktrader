<?php
/**
 * 前端基于layuicms2.0 ，后端基于arphp 5.1.14
 *
 * @author assnr assnr@coopcoder.com
 *
 * 本项目仅供学习交流使用，如果用于商业请联系授权
 */
namespace arcz\ctl\main;
use \ar\core\Controller as Controller;

/**
 * 用户控制器
 * 该控制器不受权限管理控制
 */
class User extends Base
{

    // 分配用户组页面
    public function graupAdd()
    {
        // 获取uk
        $uk = $this->getUserService()->getUk();
        // 页面地址
        $href = "users/userList";
        // 判断当前管理员是否能访问
        try {
            $apiname = 'Ws'.'server.ctl.arcz.Specialized';
            $isQuery = \ar\core\comp('rpc.service')->$apiname("queryMenuByHref",array ($href, $uk));
            if($isQuery){
                $data = \ar\core\get();

                $uid = $data['uid'];

                $apinameUser = 'Ws'.'server.ctl.arcz.User';
                $roleList = \ar\core\comp('rpc.service')->$apinameUser("getUserGroupList", array($uid));

                $this->assign(['roleList' => $roleList]);
                $this->assign(['uid' => $uid]);
                $this->display('/user/graupAdd');
            } else {
                $this->display('/404');
            }
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }

    }

    // 分配权限页面
    public function roleAdd()
    {
        // 获取uk
        $uk = $this->getUserService()->getUk();
        // 页面地址
        $href = "users/userGrade";
        // 判断当前管理员是否能访问
        try {
            $apiname = 'Ws'.'server.ctl.arcz.Specialized';
            $isQuery = \ar\core\comp('rpc.service')->$apiname("queryMenuByHref",array ($href, $uk));
            if($isQuery){
                $data = \ar\core\get();

                $rid = $data['rid'];

                $apinameUser = 'Ws'.'server.ctl.arcz.User';
                $roleList = \ar\core\comp('rpc.service')->$apinameUser("getGroupNavList", array($rid));

                $this->assign(['roleList' => $roleList]);
                $this->assign(['rid' => $rid]);
                $this->display('/user/roleAdd');
            } else {
                $this->display('/404');
            }
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }

    }

    // 个人中心页面
    public function userInfo()
    {
        // 获取uk
        $uk = $this->getUserService()->getUk();
        try {
            // 登录用户信息
            $apiname = 'Ws'.'server.ctl.arcz.User';
            $userInfo = \ar\core\comp('rpc.service')->$apiname("loginUserInfo", array($uk));

            $this->assign(['userInfo' => $userInfo]);
            $this->display('/user/userInfo');
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }

    }



    // 分配管理员组功能
    public function editFunc()
    {
        // 获取uk
        $uk = $this->getUserService()->getUk();
        // 判断当前管理员是否为开发者
        try {
            $apiname = 'Ws'.'server.ctl.arcz.Specialized';
            $isDev = \ar\core\comp('rpc.service')->$apiname("loginUserIsDev",array ($uk));
            if($isDev){
                $data = \ar\core\get();

                $mid = $data['mid'];
                $type = $data['type'];

                $apinameUser = 'Ws'.'server.ctl.arcz.User';
                $menuFuncRow = \ar\core\comp('rpc.service')->$apinameUser("getMenuFuncRow", array($mid, $type, 0));

                if($data['fid']){
                    $fid = $data['fid'];
                    $roleList = \ar\core\comp('rpc.service')->$apinameUser("getUserRoleFuncList", array($mid, $type, $fid));
                    $menuFuncRow = \ar\core\comp('rpc.service')->$apinameUser("getMenuFuncRow", array($mid, $type, $fid));
                } else {
                    $roleList = \ar\core\comp('rpc.service')->$apinameUser("getUserRoleFuncList", array($mid, $type, 0));
                }

                $this->assign(['roleList' => $roleList, 'menuFuncRow' => $menuFuncRow]);
                $this->display('/user/editFunc');
            } else {
                $this->display('/404');
            }
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }

    }


}

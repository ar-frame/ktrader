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
 * 用户页面控制器
 * 该控制器接受权限访问限制
 */
class Users extends Base
{

    // 管理员列表页面
    public function userList($count = 20, $page = 1, $keyword = '')
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
                // 登录用户信息
                $apinameUser = 'Ws'.'server.ctl.arcz.User';
                $userDetail = \ar\core\comp('rpc.service')->$apinameUser("loginUser", array($uk));
                $uid = $userDetail['id'];
                // 判断是否为开发者
                $isDev = 0;
                $dev = $userDetail['isDev'];
                if($dev) {
                    $isDev = 1;
                }
                // 判断是否为超级管理员
                $isadmin1 = 0;
                if($isDev==1){
                    $isadmin1 = 1;
                } else {
                    $urs = \arcz\lib\model\AdminUserGroup::model()->getDb()
                        ->where(['uid' => $uid])
                        ->select('gid')
                        ->queryAll();
                    foreach($urs as $ur) {
                        if($ur['gid']==1){
                            $isadmin1 = 1;
                        }
                    }
                }

                $apinameNav = 'Ws'.'server.ctl.arcz.Nav';
                $menuTitle = \ar\core\comp('rpc.service')->$apinameNav("getNavTitle", array(2, $href));

                $userList = \ar\core\comp('rpc.service')->$apinameUser("getUserList", array($uk, $count, $page, $keyword));

                $href = AR_SERVER_PATH . $href;

                $headForm = $this->getPageService()->searchSimple();
                $pageShow = $this->getPageService()->pageShowSimple($userList['totalPages'], $href, $count, $page, $keyword);

                $this->assign(['menuTitle' => $menuTitle]);
                $this->assign(['isDev' => $isDev]);
                $this->assign(['isadmin1' => $isadmin1]);
                $this->assign(['users' => $userList['users'], 'totalCount' => $userList['totalCount'], 'totalPages' => $userList['totalPages']]);
                $this->assign(['count' => $count, 'page' => $page, 'keyword' => $keyword]);
                $this->assign(['headForm' => $headForm, 'pageShow' => $pageShow]);
                $this->display('/user/userList');
            } else {
                $this->display('/404');
            }
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }

    }

    // 管理员分组页面
    public function userGrade()
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
                $apinameNav = 'Ws'.'server.ctl.arcz.Nav';
                $menuTitle = \ar\core\comp('rpc.service')->$apinameNav("getNavTitle", array(2, $href));
                $apinameUser = 'Ws'.'server.ctl.arcz.User';
                $roleList = \ar\core\comp('rpc.service')->$apinameUser("getGroupList", array());

                $this->assign(['menuTitle' => $menuTitle]);
                $this->assign(['roleList' => $roleList]);
                $this->display('/user/userGrade');
            } else {
                $this->display('/404');
            }
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }

    }
}

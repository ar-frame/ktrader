<?php

namespace server\ctl\arcz;
use \ar\core\Controller as Controller;

/**
 * 用户数据
 */
class UserService extends BaseService
{



    /**
     * 登录用户信息
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.User';
            $res = \ar\core\comp('rpc.service')->$apiname("loginUser", array($uk));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     *
     * @param  string   $uk  uk
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 登录用户信息
     *
     * @return object
     */
    public function loginUserWorker($uk)
    {
        $res = \ar\core\service('arcz.User')->getLoginUser($uk);
        $this->response($res);
    }

    /**
     * 获取当前登录用户能访问的顶级菜单id并存入数组
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.User';
            $res = \ar\core\comp('rpc.service')->$apiname("getUserTop", array($uk));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     *
     * @param  string   $uk  uk
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 获取当前登录用户能访问的顶级菜单id并存入数组
     *
     * @return object
     */
    public function getUserTopWorker($uk)
    {
        $userDetail = \ar\core\service('arcz.User')->getLoginUser($uk);
        $uid = $userDetail['id'];
        $res = \ar\core\service('arcz.Nav')->getUserTop($uid);
        $this->response($res);
    }

    /**
     * 获取当前登录用户能访问的菜单id并存入数组
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.User';
            $res = \ar\core\comp('rpc.service')->$apiname("getUserRole", array($uk));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     *
     * @param  string   $uk  uk
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 获取当前登录用户能访问的菜单id并存入数组
     *
     * @return object
     */
    public function getUserRoleWorker($uk)
    {
        $userDetail = \ar\core\service('arcz.User')->getLoginUser($uk);
        $uid = $userDetail['id'];
        $res = \ar\core\service('arcz.Nav')->getUserRole($uid);
        $this->response($res);
    }

    /**
     * 登录用户详细信息
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.User';
            $res = \ar\core\comp('rpc.service')->$apiname("loginUserInfo", array($uk));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     *
     * @param  string   $uk  uk
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 登录用户详细信息
     *
     * @return object
     */
    public function loginUserInfoWorker($uk)
    {
        $res = \ar\core\service('arcz.User')->getLoginUserInfo($uk);
        $this->response($res);
    }

    /**
     * 用户修改头像
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.User';
            $res = \ar\core\comp('rpc.service')->$apiname("editUserFace", array($uid, $img));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     *
     * @param  int     $uid  uid
     * @param  string  $img  img
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 用户修改头像
     *
     * @return object
     */
    public function editUserFaceWorker($uid, $img)
    {
        $res = \ar\core\service('arcz.User')->editUserFace($uid, $img);
        $this->response($res);
    }

    /**
     * 用户编辑个人资料
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.User';
            $res = \ar\core\comp('rpc.service')->$apiname("changeUserInfo", array($uk, $nickname, $realname, $age, $tel, $email, $website, $admin_content, $qq, $wx, $weibo, $ip));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     *
     * @param  string  $uk             uk
     * @param  string  $nickname       昵称
     * @param  string  $realname       真实姓名
     * @param  int     $age            年龄
     * @param  string  $tel            电话
     * @param  string  $email          email
     * @param  string  $website        个人网站
     * @param  string  $admin_content  个人简介
     * @param  string  $qq             QQ
     * @param  string  $wx             微信
     * @param  string  $weibo          微博
     * @param  string  $ip             ip
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 用户编辑个人资料
     *
     * @return object
     */
    public function changeUserInfoWorker($uk, $nickname, $realname, $age=0, $tel='', $email='', $website='', $admin_content='', $qq='', $wx='', $weibo='', $ip)
    {
        $res = \ar\core\service('arcz.User')->editUserInfo($uk, $nickname, $realname, $age, $tel, $email, $website, $admin_content, $qq, $wx, $weibo, $ip);
        $this->response($res);
    }

    /**
     * 用户修改密码
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.User';
            $res = \ar\core\comp('rpc.service')->$apiname("changeUserPwd", array($uk, $oldPwd, $newPwd, $new2Pwd, $ip));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     *
     * @param  string  $uk       uk
     * @param  string  $oldPwd   旧密码
     * @param  string  $newPwd   新密码
     * @param  string  $new2Pwd  确认密码
     * @param  string  $ip       ip
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 用户修改密码
     *
     * @return object
     */
    public function changeUserPwdWorker($uk, $oldPwd, $newPwd, $new2Pwd, $ip)
    {
        $res = \ar\core\service('arcz.User')->changePwd($uk, $oldPwd, $newPwd, $new2Pwd, $ip);
        $this->response($res);
    }

    /**
     * 查看管理员列表
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.User';
            $res = \ar\core\comp('rpc.service')->$apiname("getUserList", array($uk, $count, $page, $keyword));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param  string  $uk         uk
     * @param  int     $count      每页显示数量
     * @param  int     $page       当前页
     * @param  string  $keyword    搜索关键字
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 查看管理员列表
     *
     * @return object
     */
    public function getUserListWorker($uk, $count, $page, $keyword)
    {
        $res = \ar\core\service('arcz.User')->userList($uk, $count, $page, $keyword);
        $this->response($res);
    }

    /**
     * 设置开发者
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.User';
            $res = \ar\core\comp('rpc.service')->$apiname("isdevSetSwitch", array($id, $value, $uk, $loginip));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param  int     $id         id
     * @param  int     $value      value
     * @param  string  $uk         uk
     * @param  string  $loginip    ip
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 设置开发者
     *
     * @return object
     */
    public function isdevSetSwitchWorker($id, $value, $uk, $loginip)
    {
        $res = \ar\core\service('arcz.User')->isdevSetSwitch($id, $value, $uk, $loginip);
        $this->response($res);
    }

    /**
     * 根据id查找管理员用户信息
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.User';
            $res = \ar\core\comp('rpc.service')->$apiname("userDetail", array($id));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     *
     * @param  int   $id  id
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 根据id查找管理员用户信息
     *
     * @return object
     */
    public function userDetailWorker($id)
    {
        $res = \ar\core\service('arcz.User')->getUserById($id);
        $this->response($res);
    }

    /**
     * 添加管理员用户
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.User';
            $res = \ar\core\comp('rpc.service')->$apiname("addUser", array($username, $nickname, $realname, $email, $tel, $uk, $loginip));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     *
     * @param  string  $username  登录账号
     * @param  string  $nickname  昵称
     * @param  string  $realname  真实姓名
     * @param  string  $email     email
     * @param  string  $tel       tel
     * @param  string  $uk        uk
     * @param  string  $loginip   loginip
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 添加管理员用户
     *
     * @return object
     */
    public function addUserWorker($username, $nickname, $realname, $email, $tel, $uk, $loginip)
    {
        $res = \ar\core\service('arcz.User')->addUser($username, $nickname, $realname, $email, $tel, $uk, $loginip);
        $this->response($res);
    }

    /**
     * 编辑管理员用户
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.User';
            $res = \ar\core\comp('rpc.service')->$apiname("editUser", array($id, $username, $nickname, $realname, $email, $tel, $uk, $loginip));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     *
     * @param  int     $id        id
     * @param  string  $username  登录账号
     * @param  string  $nickname  昵称
     * @param  string  $realname  真实姓名
     * @param  string  $email     email
     * @param  string  $tel       tel
     * @param  string  $uk        uk
     * @param  string  $loginip   loginip
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 编辑管理员用户
     *
     * @return object
     */
    public function editUserWorker($id, $username, $nickname, $realname, $email, $tel, $uk, $loginip)
    {
        $res = \ar\core\service('arcz.User')->editUser($id, $username, $nickname, $realname, $email, $tel, $uk, $loginip);
        $this->response($res);
    }

    /**
     * 删除管理员用户
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.User';
            $res = \ar\core\comp('rpc.service')->$apiname("delUser", array($id, $uk, $loginip));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     *
     * @param  int     $id        id
     * @param  string  $uk        uk
     * @param  string  $loginip   loginip
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 删除管理员用户
     *
     * @return object
     */
    public function delUserWorker($id, $uk, $loginip)
    {
        $res = \ar\core\service('arcz.User')->delAdmin($id, $uk, $loginip);
        $this->response($res);
    }

    /**
     * 分配用户组列表
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.User';
            $res = \ar\core\comp('rpc.service')->$apiname("getUserGroupList", array($uid));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     *
     * @param  int     $uid        uid
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 分配用户组列表
     *
     * @return object
     */
    public function getUserGroupListWorker($uid)
    {
        $res = \ar\core\service('arcz.User')->getUserRoleList($uid);
        $this->response($res);
    }

    /**
     * 分配管理员角色
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.User';
            $res = \ar\core\comp('rpc.service')->$apiname("changeUserGroup", array($uid, $role_id, $type, $uk, $loginip));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     *
     * @param  int     $uid       uid
     * @param  int     $role_id   管理员组id
     * @param  int     $type      类型
     * @param  string  $uk        uk
     * @param  string  $loginip   loginip
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 分配管理员角色
     *
     * @return object
     */
    public function changeUserGroupWorker($uid, $role_id, $type, $uk, $loginip)
    {
        $res = \ar\core\service('arcz.User')->changeRole($uid, $role_id, $type, $uk, $loginip);
        $this->response($res);
    }

    /**
     * 查看管理员组列表
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.User';
            $res = \ar\core\comp('rpc.service')->$apiname("getGroupList", array());
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
     * @apiname 查看管理员组列表
     *
     * @return object
     */
    public function getGroupListWorker()
    {
        $res = \ar\core\service('arcz.User')->getRoleList();
        $this->response($res);
    }

    /**
     * 添加管理员角色
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.User';
            $res = \ar\core\comp('rpc.service')->$apiname("addGrade", array($groupname, $uk, $loginip));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     *
     * @param  string  $groupname   用户组名称
     * @param  string  $uk          uk
     * @param  string  $loginip     loginip
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 添加管理员角色
     *
     * @return object
     */
    public function addGradeWorker($groupname, $uk, $loginip)
    {
        $res = \ar\core\service('arcz.User')->addRole($groupname, $uk, $loginip);
        $this->response($res);
    }

    /**
     * 管理员角色详情
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.User';
            $res = \ar\core\comp('rpc.service')->$apiname("userGradeDetail", array($gid));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     *
     * @param  int  $gid   用户组id
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 管理员角色详情
     *
     * @return object
     */
    public function userGradeDetailWorker($gid)
    {
        $res = \ar\core\service('arcz.User')->getRoleRow($gid);
        $this->response($res);
    }

    /**
     * 编辑管理员角色
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.User';
            $res = \ar\core\comp('rpc.service')->$apiname("editUserGroup", array($id, $groupname, $uk, $loginip));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     *
     * @param  int     $id          id
     * @param  string  $groupname   用户组名称
     * @param  string  $uk          uk
     * @param  string  $loginip     loginip
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 编辑管理员角色
     *
     * @return object
     */
    public function editUserGroupWorker($id, $groupname, $uk, $loginip)
    {
        $res = \ar\core\service('arcz.User')->editRoleDo($id, $groupname, $uk, $loginip);
        $this->response($res);
    }

    /**
     * 删除管理员角色
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.User';
            $res = \ar\core\comp('rpc.service')->$apiname("delUserGroup", array($id, $uk, $loginip));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     *
     * @param  int     $id          id
     * @param  string  $uk          uk
     * @param  string  $loginip     loginip
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 删除管理员角色
     *
     * @return object
     */
    public function delUserGroupWorker($id, $uk, $loginip)
    {
        $res = \ar\core\service('arcz.User')->delRole($id, $uk, $loginip);
        $this->response($res);
    }

    /**
     * 分配权限列表
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.User';
            $res = \ar\core\comp('rpc.service')->$apiname("getGroupNavList", array($rid));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     *
     * @param  int     $rid        rid
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 分配权限列表
     *
     * @return object
     */
    public function getGroupNavListWorker($rid)
    {
        $res = \ar\core\service('arcz.User')->getRoleNavList($rid);
        $this->response($res);
    }

    /**
     * 分配管理员组权限
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.User';
            $res = \ar\core\comp('rpc.service')->$apiname("changeRoleNav", array($rid, $nav_id, $type, $uk, $loginip));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     *
     * @param  int     $rid       rid
     * @param  int     $nav_id   管理员组id
     * @param  int     $type      类型
     * @param  string  $uk        uk
     * @param  string  $loginip   loginip
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 分配管理员组权限
     *
     * @return object
     */
    public function changeRoleNavWorker($rid, $nav_id, $type, $uk, $loginip)
    {
        $res = \ar\core\service('arcz.User')->changeRoleNav($rid, $nav_id, $type, $uk, $loginip);
        $this->response($res);
    }

    /**
     * 获取单个功能
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.User';
            $res = \ar\core\comp('rpc.service')->$apiname("getMenuFuncRow", array($mid, $type, $id));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     *
     * @param  int     $mid       模型id
     * @param  int     $type      类型  0自定义功能 1添加 2编辑 3删除 4显示详情 5搜索 6自定义显示列 7导出Excel 8打印列表 9导出excel
     * @param  int     $id        功能id
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 获取单个功能
     *
     * @return object
     */
    public function getMenuFuncRowWorker($mid, $type, $id)
    {
        $res = \ar\core\service('arcz.User')->getMenuFuncRow($mid, $type, $id);
        $this->response($res);
    }

    /**
     * 分配用户组功能列表
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.User';
            $res = \ar\core\comp('rpc.service')->$apiname("getUserRoleFuncList", array($mid, $type, $id));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     *
     * @param  int     $mid       模型id
     * @param  int     $type      类型  0自定义功能 1添加 2编辑 3删除 4显示详情 5搜索 6自定义显示列 7导出Excel 8打印列表 9导出excel
     * @param  int     $id        功能id
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 分配用户组功能列表
     *
     * @return object
     */
    public function getUserRoleFuncListWorker($mid, $type, $id)
    {
        $res = \ar\core\service('arcz.User')->getUserRoleFuncList($mid, $type, $id);
        $this->response($res);
    }

    /**
     * 分配用户组相关功能
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.User';
            $res = \ar\core\comp('rpc.service')->$apiname("changeRoleFunc", array($role_id, $type, $mid, $fid, $functype, $uk, $loginip));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     *
     * @param  int     $role_id   用户组id
     * @param  int     $type      类型  0取消分配 1分配
     * @param  int     $mid       模型id
     * @param  int     $fid       功能id
     * @param  int     $functype  功能类型  0自定义功能 1添加 2编辑 3删除 4显示详情 5搜索 6自定义显示列 7导出Excel 8打印列表 9导出excel
     * @param  string  $uk        uk
     * @param  string  $loginip   loginip
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 分配用户组相关功能
     *
     * @return object
     */
    public function changeRoleFuncWorker($role_id, $type, $mid, $fid, $functype, $uk, $loginip)
    {
        $res = \ar\core\service('arcz.User')->changeRoleFunc($role_id, $type, $mid, $fid, $functype, $uk, $loginip);
        $this->response($res);
    }



}

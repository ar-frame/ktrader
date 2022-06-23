<?php

namespace server\ctl\arcz;
use \ar\core\Controller as Controller;

/**
 * 菜单相关数据
 */
class NavService extends BaseService
{

    /**
     * 查看菜单列表（开发者）
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.Nav';
            $res = \ar\core\comp('rpc.service')->$apiname("findMenu", array());
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
     * @apiname 查看菜单列表（开发者）
     *
     * @return object
     */
    public function findMenuWorker()
    {
        // 菜单
        $top = \ar\core\service('arcz.Nav')->findTopMenu();

        $res = $top;
        $this->response($res);
    }

    /**
     * 查看菜单列表
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.Nav';
            $res = \ar\core\comp('rpc.service')->$apiname("findUserMenu", array($topid, $navsid));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     *
     * @param  array  $topid   顶级菜单id
     * @param  array  $navsid  用户能访问的菜单id
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 查看菜单列表
     *
     * @return object
     */
    public function findUserMenuWorker($topid, $navsid)
    {
        // 菜单
        $top = \ar\core\service('arcz.Nav')->findUserTopMenu($topid, $navsid);

        $res = $top;
        $this->response($res);
    }

    /**
     * 根据条件查找单个菜单并返回菜单标题
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.Nav';
            $res = \ar\core\comp('rpc.service')->$apiname("getNavTitle", array($type, $con));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     *
     * @param  int     $type      条件类型 1 id 2 href 3 mid
     * @param  string  $con       查询条件
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 根据条件查找单个菜单并返回菜单标题
     *
     * @return object
     */
    public function getNavTitleWorker($type, $con)
    {
        if($type == 1){
            $res = \ar\core\service('arcz.Nav')->getNavTitleById($con);
            $this->response($res);
        } else if($type == 2){
            $res = \ar\core\service('arcz.Nav')->getNavTitleByHref($con);
            $this->response($res);
        } else if($type == 3){
            $res = \ar\core\service('arcz.Nav')->getNavTitleByMid($con);
            $this->response($res);
        }
    }

    /**
     * 后台菜单列表
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.Nav';
            $res = \ar\core\comp('rpc.service')->$apiname("navslist", array());
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
     * @apiname 后台菜单列表
     *
     * @return object
     */
    public function navslistWorker()
    {
        $res = \ar\core\service('arcz.Nav')->navslist();
        $this->response($res);
    }

    /**
     * 设置开发者菜单开关
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.Nav';
            $res = \ar\core\comp('rpc.service')->$apiname("navSetDevSwitch", array($id, $value, $uk, $loginip));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param  int     $id         菜单id
     * @param  int     $value      字段值
     * @param  string  $uk         uk
     * @param  string  $loginip    loginip
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 设置开发者菜单开关
     *
     * @return object
     */
    public function navSetDevSwitchWorker($id, $value, $uk, $loginip)
    {
        $res = \ar\core\service('arcz.Nav')->navSetDevSwitch($id, $value, $uk, $loginip);
        $this->response($res);
    }

    /**
     * 根据id查找单个菜单
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.Nav';
            $res = \ar\core\comp('rpc.service')->$apiname("getNavById", array($id));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param  int  $id  id
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 根据id查找单个菜单
     *
     * @return object
     */
    public function getNavByIdWorker($id)
    {
        $res = \ar\core\service('arcz.Nav')->getNavById($id);
        $this->response($res);
    }

    /**
     * 添加菜单下拉框查找一级菜单 非系统菜单
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.Nav';
            $res = \ar\core\comp('rpc.service')->$apiname("findTopMenuAddMenu", array());
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
     * @apiname 添加菜单下拉框查找一级菜单 非系统菜单
     *
     * @return object
     */
    public function findTopMenuAddMenuWorker()
    {
        $res = \ar\core\service('arcz.Nav')->findTopMenuAddMenu();
        $this->response($res);
    }

    /**
     * 添加菜单下拉框查找一级菜单 包括系统菜单
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.Nav';
            $res = \ar\core\comp('rpc.service')->$apiname("findTopMenuAddMenuSys", array());
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
     * @apiname 添加菜单下拉框查找一级菜单 包括系统菜单
     *
     * @return object
     */
    public function findTopMenuAddMenuSysWorker()
    {
        $res = \ar\core\service('arcz.Nav')->findTopMenuAddMenuSys();
        $this->response($res);
    }

    /**
     * 添加菜单下拉框查找二级菜单 非系统菜单
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.Nav';
            $res = \ar\core\comp('rpc.service')->$apiname("findSecondMenuAddMenu", array());
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
     * @apiname 添加菜单下拉框查找二级菜单 非系统菜单
     *
     * @return object
     */
    public function findSecondMenuAddMenuWorker()
    {
        $res = \ar\core\service('arcz.Nav')->findSecondMenuAddMenu();
        $this->response($res);
    }

    /**
     * 添加菜单下拉框查找二级菜单 包括系统菜单
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.Nav';
            $res = \ar\core\comp('rpc.service')->$apiname("findSecondMenuAddMenuSys", array());
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
     * @apiname 添加菜单下拉框查找二级菜单 包括系统菜单
     *
     * @return object
     */
    public function findSecondMenuAddMenuSysWorker()
    {
        $res = \ar\core\service('arcz.Nav')->findSecondMenuAddMenuSys();
        $this->response($res);
    }

    /**
     * 添加编辑菜单
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.Nav';
            $res = \ar\core\comp('rpc.service')->$apiname("addMenuSys", array($id, $title, $href, $info, $icon, $cate, $fid, $num, $mid, $uk, $loginip));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param  int     $id       id
     * @param  string  $title    名称
     * @param  string  $href     链接
     * @param  string  $info     说明
     * @param  string  $icon     图标
     * @param  int     $cate     分类
     * @param  int     $fid      父级菜单
     * @param  int     $num      排序
     * @param  int     $mid      模型id
     * @param  string  $uk       uk
     * @param  string  $loginip  loginip
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 添加编辑菜单
     *
     * @return object
     */
    public function addMenuSysWorker($id, $title, $href, $info, $icon, $cate, $fid, $num, $mid, $uk, $loginip)
    {
        $res = \ar\core\service('arcz.Nav')->addMenu($id, $title, $href, $info, $icon, $cate, $fid, $num, $mid, $uk, $loginip);
        $this->response($res);
    }

    /**
     * 删除菜单
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.Nav';
            $res = \ar\core\comp('rpc.service')->$apiname("delNav", array($id, $uk, $loginip));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param  int     $id       id
     * @param  string  $uk       uk
     * @param  string  $loginip  loginip
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 删除
     *
     * @return object
     */
    public function delNavWorker($id, $uk, $loginip)
    {
        $res = \ar\core\service('arcz.Nav')->delMenu($id, $uk, $loginip);
        $this->response($res);
    }

}

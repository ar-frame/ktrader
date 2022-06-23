<?php

namespace server\ctl\arcz;
use \ar\core\Controller as Controller;

/**
 * 权限验证
 */
class SpecializedService extends BaseService
{

    public function init($data)
    {

    }

    /**
     * 判断当前管理员是否为开发者
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.Specialized';
            $res = \ar\core\comp('rpc.service')->$apiname("loginUserIsDev",array ($uk));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param  string   $uk   uk
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 判断当前管理员是否为开发者
     *
     * @return void
     */
    public function loginUserIsDevWorker($uk)
    {
        $res = \ar\core\service('arcz.Specialized')->loginUserIsDev($uk);

        $this->response($res);
    }

    /**
     * 判断当前管理员是否能访问该地址
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.Specialized';
            $res = \ar\core\comp('rpc.service')->$apiname("queryMenuByHref",array ($href, $uk));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param  string   $href  地址
     * @param  string   $uk    uk
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 判断当前管理员是否能访问该地址
     *
     * @return void
     */
    public function queryMenuByHrefWorker($href, $uk)
    {
        $res = \ar\core\service('arcz.Specialized')->queryMenuByHref($href, $uk);

        $this->response($res);
    }

    /**
     * 判断当前管理员是否能访问该模型
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.Specialized';
            $res = \ar\core\comp('rpc.service')->$apiname("queryModelByMid",array ($mid, $uk));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param  int      $mid   mid
     * @param  string   $uk    uk
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 判断当前管理员是否能访问该模型
     *
     * @return void
     */
    public function queryModelByMidWorker($mid, $uk)
    {
        $res = \ar\core\service('arcz.Specialized')->queryModelByMid($mid, $uk);

        $this->response($res);
    }

    /**
     * 判断当前管理员是否能访问该功能
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.Specialized';
            $res = \ar\core\comp('rpc.service')->$apiname("queryFuncByCon",array ($mid, $type, $href, $uk));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param  int      $mid   mid
     * @param  int      $type  类型  0自定义功能 1添加 2编辑 3删除 4显示详情 5搜索 6自定义显示列 7导出Excel 8打印列表 9导出excel
     * @param  string   $href  地址
     * @param  string   $uk    uk
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 判断当前管理员是否能访问该功能
     *
     * @return void
     */
    public function queryFuncByConWorker($mid, $type, $href, $uk)
    {
        $res = \ar\core\service('arcz.Specialized')->queryFuncByCon($mid, $type, $href, $uk);

        $this->response($res);
    }


}

<?php

namespace server\ctl\arcz;
use \ar\core\Controller as Controller;

/**
 * 数据获取编辑
 */
class DBModelService extends BaseService
{

    /**
     * 获取所有的数据库列表
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.DBModel';
            $res = \ar\core\comp('rpc.service')->$apiname("getDbLists", array());
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
     * @apiname 获取所有的数据库列表
     *
     * @return object
     */
    public function getDbListsWorker()
    {
        $res = \ar\core\service('arcz.DBModel')->getDbLists();
        $this->response($res);
    }

    /**
     * 获取数据表
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.DBModel';
            $res = \ar\core\comp('rpc.service')->$apiname("tableLists", array($db));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     *
     * @param  string  $db   数据库名
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 获取数据表
     *
     * @return object
     */
    public function tableListsWorker($db)
    {
        $res = \ar\core\service('arcz.DBModel')->tableLists($db);
        $this->response($res);
    }

    /**
     * 生成模型
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.DBModel';
            $res = \ar\core\comp('rpc.service')->$apiname("changeModel", array($tablename, $uk, $loginip));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     *
     * @param  string  $tablename   数据表名
     * @param  string  $uk          uk
     * @param  string  $loginip     loginip
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 生成模型
     *
     * @return object
     */
    public function changeModelWorker($tablename, $uk, $loginip)
    {
        $modelName = $this->convertUnderline($tablename);
        $dbname = substr($tablename, 0, strpos($tablename, '.'));

        $modelDetail = [
            'modelname' => $modelName,
            'tablename' => $tablename,
            'dbname' => $dbname
        ];

        $res = \ar\core\service('arcz.DBModel')->addModel($modelDetail, $uk, $loginip);
        $this->response($res);
    }

    /**
     * 添加模型字段
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.DBModel';
            $res = \ar\core\comp('rpc.service')->$apiname("changeModelCol", array($colname, $tablename, $uk, $loginip));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     *
     * @param  string  $colname     字段名
     * @param  string  $tablename   数据表名
     * @param  string  $uk          uk
     * @param  string  $loginip     loginip
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 添加模型字段
     *
     * @return object
     */
    public function changeModelColWorker($colname, $tablename, $uk, $loginip)
    {
        $modelName = $this->convertUnderline($tablename);
        $dbname = substr($tablename, 0, strpos($tablename, '.'));

        $modelDetail = [
            'modelname' => $modelName,
            'tablename' => $tablename,
            'dbname' => $dbname
        ];

        $res = \ar\core\service('arcz.DBModel')->addModelCol($modelDetail, $colname, $uk, $loginip);
        $this->response($res);
    }

    // 将下划线命名转换为驼峰式命名
    function convertUnderline($str , $ucfirst = true)
    {
        list($dbConfig, $str) = explode('.', $str);

        while(($pos = strpos($str , '_'))!==false)
            $str = substr($str , 0 , $pos).ucfirst(substr($str , $pos+1));

        $modelName = $ucfirst ? ucfirst($str) : $str;
        // ader2 modify
        $modelName = str_replace('-', '', $modelName);
        return $dbConfig . '/' . $modelName;
    }

    /**
     * 查看模型列表
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.DBModel';
            $res = \ar\core\comp('rpc.service')->$apiname("getModelList", array($uk, $count, $page, $search_col, $keyword, $sort_col, $sort_type));
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
     * @param  string  $search_col 搜索字段
     * @param  string  $keyword    搜索关键字
     * @param  string  $sort_col   排序字段
     * @param  string  $sort_type  排序方式  desc asc
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 查看模型列表
     *
     * @return object
     */
    public function getModelListWorker($uk, $count, $page, $search_col, $keyword, $sort_col, $sort_type)
    {
        $res = \ar\core\service('arcz.DBModel')->getModelList($uk, $count, $page, $search_col, $keyword, $sort_col, $sort_type);
        $this->response($res);
    }

    /**
     * 查看模型详情
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.DBModel';
            $res = \ar\core\comp('rpc.service')->$apiname("getModelRow", array($id));
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
     * @apiname 查看模型详情
     *
     * @return object
     */
    public function getModelRowWorker($id)
    {
        $res = \ar\core\service('arcz.DBModel')->modellistRow($id);
        $this->response($res);
    }

    /**
     * 根据数据表名查看模型详情
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.DBModel';
            $res = \ar\core\comp('rpc.service')->$apiname("getModelRowByTname", array($tname));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param  string  $tname  tname
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 根据数据表名查看模型详情
     *
     * @return object
     */
    public function getModelRowByTnameWorker($tname)
    {
        $res = \ar\core\service('arcz.DBModel')->modellistRowByTname($tname);
        $this->response($res);
    }

    /**
     * 查看模型字段详情
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.DBModel';
            $res = \ar\core\comp('rpc.service')->$apiname("getColRow", array($id));
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
     * @apiname 查看模型字段详情
     *
     * @return object
     */
    public function getColRowWorker($id)
    {
        $res = \ar\core\service('arcz.DBModel')->colRow($id);
        $this->response($res);
    }

    /**
     * 查看模型字段
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.DBModel';
            $res = \ar\core\comp('rpc.service')->$apiname("getTableCols", array($tname));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param  string  $tname  tname
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 查看模型字段
     *
     * @return object
     */
    public function getTableColsWorker($tname)
    {
        $res = \ar\core\service('arcz.DBModel')->tableCols($tname);
        $this->response($res);
    }

    /**
     * 设置模型字段属性开关
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.DBModel';
            $res = \ar\core\comp('rpc.service')->$apiname("modelSetSwitch", array($id, $value, $name, $uk, $loginip));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param  int     $id         模型id
     * @param  int     $value      字段值
     * @param  string  $name       字段名称
     * @param  string  $uk         uk
     * @param  string  $loginip    loginip
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 设置模型字段属性开关
     *
     * @return object
     */
    public function modelSetSwitchWorker($id, $value, $name, $uk, $loginip)
    {
        $res = \ar\core\service('arcz.DBModel')->modelSetSwitch($id, $value, $name, $uk, $loginip);
        $this->response($res);
    }

    /**
     * 设置模型字段属性开关
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.DBModel';
            $res = \ar\core\comp('rpc.service')->$apiname("modelSetCol", array($id, $value, $name, $uk, $loginip));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param  int     $id         模型id
     * @param  int     $value      字段值
     * @param  string  $name       字段名称
     * @param  string  $uk         uk
     * @param  string  $loginip    loginip
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 设置模型字段属性开关
     *
     * @return object
     */
    public function modelSetColWorker($id, $value, $name, $uk, $loginip)
    {
        $res = \ar\core\service('arcz.DBModel')->setColValNow($id, $value, $name, $uk, $loginip);
        $this->response($res);
    }

    /**
     * 删除模型
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.DBModel';
            $res = \ar\core\comp('rpc.service')->$apiname("delModel", array($id, $uk, $loginip));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param  int     $id         模型id
     * @param  string  $uk         uk
     * @param  string  $loginip    loginip
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 删除模型
     *
     * @return object
     */
    public function delModelWorker($id, $uk, $loginip)
    {
        $res = \ar\core\service('arcz.DBModel')->delModel($id, $uk, $loginip);
        $this->response($res);
    }

    /**
     * 添加外键模型
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.DBModel';
            $res = \ar\core\comp('rpc.service')->$apiname("addFkModel", array($id, $uk, $loginip));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param  int     $id         模型字段id
     * @param  string  $uk         uk
     * @param  string  $loginip    loginip
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 添加外键模型
     *
     * @return object
     */
    public function addFkModelWorker($id, $uk, $loginip)
    {
        $res = \ar\core\service('arcz.DBModel')->addFkModel($id, $uk, $loginip);
        $this->response($res);
    }

    /**
     * 查看外键模型
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.DBModel';
            $res = \ar\core\comp('rpc.service')->$apiname("getFkModel", array($id));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param  int     $id         模型字段id
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 查看外键模型
     *
     * @return object
     */
    public function getFkModelWorker($id)
    {
        $res = \ar\core\service('arcz.DBModel')->getFkModel($id);
        $this->response($res);
    }

    /**
     * 查找所有模型
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.DBModel';
            $res = \ar\core\comp('rpc.service')->$apiname("getAllModel", array());
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
     * @apiname 查找所有模型
     *
     * @return object
     */
    public function getAllModelWorker()
    {
        $res = \ar\core\service('arcz.DBModel')->getAllModel();
        $this->response($res);
    }

    /**
     * 获取外键模型字段
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.DBModel';
            $res = \ar\core\comp('rpc.service')->$apiname("getCol", array($id));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param  int     $id         模型id
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 获取外键模型字段
     *
     * @return object
     */
    public function getColWorker($id)
    {
        $res = \ar\core\service('arcz.DBModel')->getCol($id);
        $this->response($res);
    }

    /**
     * 编辑关联外键
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.DBModel';
            $res = \ar\core\comp('rpc.service')->$apiname("manageFkCol", array($fkid, $fmodelid, $funivalid, $fcolnameid, $uk, $loginip));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param  int     $fkid          外键模型id
     * @param  int     $fmodelid      关联模型id
     * @param  int     $funivalid     映射字段对应字段id
     * @param  int     $fcolnameid    关联字段对应字段id
     * @param  string  $uk            uk
     * @param  string  $loginip       loginip
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 编辑关联外键
     *
     * @return object
     */
    public function manageFkColWorker($fkid, $fmodelid, $funivalid, $fcolnameid, $uk, $loginip)
    {
        $res = \ar\core\service('arcz.DBModel')->updateFkCol($fkid, $fmodelid, $funivalid, $fcolnameid, $uk, $loginip);
        $this->response($res);
    }

    /**
     * 查看模型自定义功能
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.DBModel';
            $res = \ar\core\comp('rpc.service')->$apiname("getFuncList", array($id));
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
     * @apiname 查看模型自定义功能
     *
     * @return object
     */
    public function getFuncListWorker($id)
    {
        $res = \ar\core\service('arcz.DBModel')->getFuncList($id);
        $this->response($res);
    }

    /**
     * 添加自定义功能
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.DBModel';
            $res = \ar\core\comp('rpc.service')->$apiname("addFunc", array($mid, $menuid, $title, $name, $apiaddr, $uk, $loginip));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param  int     $mid          模型id
     * @param  int     $menuid       菜单id
     * @param  string  $title        功能按钮名称
     * @param  string  $name         功能代号
     * @param  string  $apiaddr      接口地址
     * @param  string  $uk           uk
     * @param  string  $loginip      loginip
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 添加自定义功能
     *
     * @return object
     */
    public function addFuncWorker($mid, $menuid, $title, $name, $apiaddr, $uk, $loginip)
    {
        $res = \ar\core\service('arcz.DBModel')->addFunc($mid, $menuid, $title, $name, $apiaddr, $uk, $loginip);
        $this->response($res);
    }

    /**
     * 设置功能字段属性开关
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.DBModel';
            $res = \ar\core\comp('rpc.service')->$apiname("funcSetSwitch", array($id, $value, $name, $uk, $loginip));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param  int     $id         功能id
     * @param  int     $value      字段值
     * @param  string  $name       字段名称
     * @param  string  $uk         uk
     * @param  string  $loginip    loginip
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 设置功能字段属性开关
     *
     * @return object
     */
    public function funcSetSwitchWorker($id, $value, $name, $uk, $loginip)
    {
        $res = \ar\core\service('arcz.DBModel')->funcSetSwitch($id, $value, $name, $uk, $loginip);
        $this->response($res);
    }

    /**
     * 查询单个功能
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.DBModel';
            $res = \ar\core\comp('rpc.service')->$apiname("getFuncRow", array($id));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param  int     $id        功能id
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 查询单个功能
     *
     * @return object
     */
    public function getFuncRowWorker($id)
    {
        $res = \ar\core\service('arcz.DBModel')->getFuncRow($id);
        $this->response($res);
    }

    /**
     * 编辑自定义功能
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.DBModel';
            $res = \ar\core\comp('rpc.service')->$apiname("editFunc", array($id, $title, $apiaddr, $uk, $loginip));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param  int     $id           id
     * @param  string  $title        功能按钮名称
     * @param  string  $apiaddr      接口地址
     * @param  string  $uk           uk
     * @param  string  $loginip      loginip
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 编辑自定义功能
     *
     * @return object
     */
    public function editFuncWorker($id, $title, $apiaddr, $uk, $loginip)
    {
        $res = \ar\core\service('arcz.DBModel')->editFunc($id, $title, $apiaddr, $uk, $loginip);
        $this->response($res);
    }

    /**
     * 删除自定义功能
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.DBModel';
            $res = \ar\core\comp('rpc.service')->$apiname("delFunc", array($id, $uk, $loginip));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param  int     $id        功能id
     * @param  string  $uk        uk
     * @param  string  $loginip   loginip
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 删除自定义功能
     *
     * @return object
     */
    public function delFuncWorker($id, $uk, $loginip)
    {
        $res = \ar\core\service('arcz.DBModel')->delFunc($id, $uk, $loginip);
        $this->response($res);
    }

}

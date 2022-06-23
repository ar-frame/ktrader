<?php

namespace server\ctl\arcz;
use \ar\core\Controller as Controller;

/**
 * 数据获取编辑
 */
class DataService extends BaseService
{

    /**
     * 查看管理员操作日志
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.Data';
            $res = \ar\core\comp('rpc.service')->$apiname("getLogList", array($uk, $count, $page, $search_col, $keyword, $sort_col, $sort_type));
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
     * @apiname 查看管理员操作日志
     *
     * @return object
     */
    public function getLogListWorker($uk, $count, $page, $search_col, $keyword, $sort_col, $sort_type)
    {
        $res = \ar\core\service('arcz.Data')->getLogList($uk, $count, $page, $search_col, $keyword, $sort_col, $sort_type);
        $this->response($res);
    }

    /**
     * 查看管理员操作日志详情
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.Data';
            $res = \ar\core\comp('rpc.service')->$apiname("getLogDetail", array($id));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param  int  $id   id
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 查看管理员操作日志详情
     *
     * @return object
     */
    public function getLogDetailWorker($id)
    {
        $res = \ar\core\service('arcz.Data')->getLogDetail($id);
        $this->response($res);
    }

    /**
     * 获取模型字段名
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.Data';
            $res = \ar\core\comp('rpc.service')->$apiname("getModelColumns", array($mid));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param  int  $mid   模型id
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 获取模型字段名
     *
     * @return object
     */
    public function getModelColumnsWorker($mid)
    {
        $res = \ar\core\service('arcz.Data')->getModelColumns($mid);
        $this->response($res);
    }

    /**
     * 获取模型是否有唯一键
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.Data';
            $res = \ar\core\comp('rpc.service')->$apiname("modelHasUniqueKey", array($mid));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param  int  $mid   模型id
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 获取模型是否有唯一键
     *
     * @return object
     */
    public function modelHasUniqueKeyWorker($mid)
    {
        $res = \ar\core\service('arcz.Data')->modelHasUniqueKey($mid);
        $this->response($res);
    }

    /**
     * 获取模型的唯一键
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.Data';
            $res = \ar\core\comp('rpc.service')->$apiname("modelUniqueKey", array($mid));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param  int  $mid   模型id
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 获取模型的唯一键
     *
     * @return object
     */
    public function modelUniqueKeyWorker($mid)
    {
        $res = \ar\core\service('arcz.Data')->modelUniqueKey($mid);
        $this->response($res);
    }

    /**
     * 获取模型
     *
     * 客户端调用方式
            try {
            $apiname = 'Ws'.'server.ctl.arcz.Data';
            $res = \ar\core\comp('rpc.service')->$apiname("getModel", array($mid));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param  int  $mid   模型id
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 获取模型
     *
     * @return object
     */
    public function getModelWorker($mid)
    {
        $res = \ar\core\service('arcz.Data')->getModel($mid);
        $this->response($res);
    }

    /**
     * 获取菜单
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.Data';
            $res = \ar\core\comp('rpc.service')->$apiname("getMenuByModel", array($mid));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param  int  $mid   模型id
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 获取菜单
     *
     * @return object
     */
    public function getMenuByModelWorker($mid)
    {
        $res = \ar\core\service('arcz.Data')->getMenuByModel($mid);
        $this->response($res);
    }

    /**
     * 查找开发者访问的所有通用(type = 1-9)功能按钮
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.Data';
            $res = \ar\core\comp('rpc.service')->$apiname("findDevButtons", array($mid));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param  int  $mid   模型id
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 查找开发者访问的所有通用(type = 1-9)功能按钮
     *
     * @return object
     */
    public function findDevButtonsWorker($mid)
    {
        $res = \ar\core\service('arcz.Data')->findDevButtons($mid);
        $this->response($res);
    }

    /**
     * 查找非开发者访问的所有通用(type = 1-9)功能按钮
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.Data';
            $res = \ar\core\comp('rpc.service')->$apiname("findUserButtons", array($mid, $uk));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param  int     $mid   模型id
     * @param  string  $uk    uk
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 查找非开发者访问的所有通用(type = 1-9)功能按钮
     *
     * @return object
     */
    public function findUserButtonsWorker($mid, $uk)
    {
        $res = \ar\core\service('arcz.Data')->findUserButtons($mid, $uk);
        $this->response($res);
    }

    /**
     * 获取模型对应数据
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.Data';
            $res = \ar\core\comp('rpc.service')->$apiname("modelDataList", array($mid, $count, $page, $search_col, $keyword, $sort_col, $sort_type, $unikey));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param  int     $mid        模型id
     * @param  int     $count      每页显示数量
     * @param  int     $page       当前页
     * @param  string  $search_col 搜索字段
     * @param  string  $keyword    搜索关键字
     * @param  string  $sort_col   排序字段
     * @param  string  $sort_type  排序方式  desc asc
     * @param  string  $unikey     唯一键
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 获取模型对应数据
     *
     * @return object
     */
    public function modelDataListWorker($mid, $count, $page, $search_col, $keyword, $sort_col, $sort_type, $unikey)
    {
        $res = \ar\core\service('arcz.Data')->modelDataList($mid, $count, $page, $search_col, $keyword, $sort_col, $sort_type, $unikey);
        $this->response($res);
    }

    /**
     * 获取模型对应数据
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.Data';
            $res = \ar\core\comp('rpc.service')->$apiname("modelDataList", array($mid, $colname, $id, $value, $uk, $loginip));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param  int     $mid        模型id
     * @param  string  $colname    字段名
     * @param  int     $id         id
     * @param  int     $value      值
     * @param  string  $uk         uk
     * @param  string  $loginip    loginip
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 获取模型对应数据
     *
     * @return object
     */
    public function setSwitchNowWorker($mid, $colname, $id, $value, $uk, $loginip)
    {
        $res = \ar\core\service('arcz.Data')->setSwitchNow($mid, $colname, $id, $value, $uk, $loginip);
        $this->response($res);
    }

    /**
     * 根据指定字段查看模型文章内容
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.Data';
            $res = \ar\core\comp('rpc.service')->$apiname("getColContent", array($mid, $colname, $id));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param  int     $mid        模型id
     * @param  string  $colname    字段名
     * @param  int     $id         id
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 根据指定字段查看模型文章内容
     *
     * @return object
     */
    public function getColContentWorker($mid, $colname, $id)
    {
        $res = \ar\core\service('arcz.Data')->getColContent($mid, $colname, $id);
        $this->response($res);
    }

    /**
     * 获取数据
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.Data';
            $res = \ar\core\comp('rpc.service')->$apiname("getDataByUniKey", array($mid, $id, $type));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param  int     $mid        模型id
     * @param  int     $id         id
     * @param  string  $type       类型 edit编辑 view查看
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 获取数据
     *
     * @return object
     */
    public function getDataByUniKeyWorker($mid, $id, $type)
    {
        $columns = \ar\core\service('arcz.Data')->getModelColumns($mid);
        $row = \ar\core\service('arcz.Data')->getDataByUniKey($mid, $id);
        foreach($columns as &$column){
            if($column['type']==3){ // 富文本
                $cval = $row[$column['colname']];
                $cval = stripslashes($cval);
                $row[$column['colname']] = stripcslashes($cval);
            } else if($column['type']==5){ // 时间戳转时间
                if($type=='view'){
                    $typeex = $column['typeexplain'];
                    $cval = $row[$column['colname']];
                    $row[$column['colname']] = date($typeex, $cval);
                } else if($type=='edit'){
                    $typeex = 'Y-m-d H:i:s';
                    $cval = $row[$column['colname']];
                    $row[$column['colname']] = date($typeex, $cval);
                }
            }
        }
        $this->response($row);
    }

    /**
     * 提交添加编辑数据
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.Data';
            $res = \ar\core\comp('rpc.service')->$apiname("modelDataEdit", array($array));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param  array     $array      传入数据
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 提交添加编辑数据
     *
     * @return object
     */
    public function modelDataEditWorker($array)
    {
        $editData = [];
        // 数据
        $editData['data'] = $array;
        // ip
        $ip = array_pop($editData['data']);
        // uk
        $uk = array_pop($editData['data']);
        // mid
        $mid = array_pop($editData['data']);
        // 唯一键值
        $uniKeyVal = array_pop($editData['data']);
        // 唯一键名
        $uniKeyName = array_pop($editData['data']);
        $editData['mid'] = $mid;
        $editData['uniKeyVal'] = $uniKeyVal;
        $editData['uniKeyName'] = $uniKeyName;
        $editData['ip'] = $ip;
        $editData['uk'] = $uk;
        // 提交数据
        $data = $editData['data'];
        
        
        
        $obj = $array;
        
        $mid = $obj['uni_primary_mid'];
        $uniKeyName = $obj['uniKeyName'];
        $uniKeyVal = $obj['uniKeyVal'];
        $uk = $obj['uk'];
        $ip = $obj['ip'];
        
        unset($obj['uni_primary_mid']);
        unset($obj['uniKeyName']);
        unset($obj['uniKeyVal']);
        unset($obj['uk']);
        unset($obj['ip']);
        
        $data = $obj;
        
        
        
        

        $res = \ar\core\service('arcz.Data')->modelDataEdit($data, $mid, $uniKeyName, $uniKeyVal, $uk, $ip);

        $this->response($res);
    }

    /**
     * 提交添加编辑数据
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.Data';
            $res = \ar\core\comp('rpc.service')->$apiname("getFkDataList", array($mtablename, $mcolname, $cval));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param  string     $mtablename      表名
     * @param  string     $mcolname        字段名
     * @param  string     $cval            值
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 提交添加编辑数据
     *
     * @return object
     */
    public function getFkDataListWorker($mtablename, $mcolname, $cval)
    {
        $res = \ar\core\service('arcz.Data')->getFkDataList($mtablename, $mcolname, $cval);

        $this->response($res);
    }

    /**
     * 删除模型对应数据
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.Data';
            $res = \ar\core\comp('rpc.service')->$apiname("delModelData", array($mid, $id, $uk, $loginip));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param  int     $mid        模型id
     * @param  int     $id         id
     * @param  string  $uk         uk
     * @param  string  $loginip    loginip
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 删除模型对应数据
     *
     * @return object
     */
    public function delModelDataWorker($mid, $id, $uk, $loginip)
    {
        $res = \ar\core\service('arcz.Data')->delModelData($mid, $id, $uk, $loginip);
        $this->response($res);
    }

    /**
     * 自定义显示列
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.Data';
            $res = \ar\core\comp('rpc.service')->$apiname("editShowCol", array($tablename, $colname, $type, $uk, $loginip));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param  string  $tablename  数据表名
     * @param  string  $colname    字段名
     * @param  int     $type       isshow值
     * @param  string  $uk         uk
     * @param  string  $loginip    loginip
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 自定义显示列
     *
     * @return object
     */
    public function editShowColWorker($tablename, $colname, $type, $uk, $loginip)
    {
        $res = \ar\core\service('arcz.Data')->editShowCol($tablename, $colname, $type, $uk, $loginip);
        $this->response($res);
    }

    /**
     * 导出Excel
     *
     * 客户端调用方式
        try {
            $apiname = 'Ws'.'server.ctl.arcz.Data';
            $res = \ar\core\comp('rpc.service')->$apiname("downAsExcel", array($mid));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param  int     $mid        模型id
     *
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 导出Excel
     *
     * @return object
     */
    public function downAsExcelWorker($mid)
    {
        $res = \ar\core\service('arcz.Excel')->downAsExcel($mid);
        $this->response($res);
    }

      /**
     * uploadPicWorker
     *
     * 客户端调用方式
        try {
            $response = \ar\core\comp('rpc.service')
                ->call('server.ctl.arcz.Data', " uploadPic", [$picBase64String]);
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @author abcd <abcd0668@gmail.com>
     *
     * @apiname uploadPicWorker
     *
     * @return object
     */
    public function uploadPicWorker($picBase64String)
    {
        $errMsg = [
            'errMsg' => ''
        ];
        
        //匹配出图片的格式
        if (preg_match('/^(data:image\/(\S+);base64,)/', $picBase64String, $result)) {
            $type = $result[2];
            $uploadPath = \ar\core\cfg('UPLOAD_IMG_PATH') . '/' . date('Ymd', time());

            // x-icon
            // \ar\core\comp('tools.log')->record($result,'ico');
            if ($result[2] == 'x-icon') {
                $filename = \ar\core\comp('tools.util')->randpw(16, 'NUMBER')  . '.ico';
            } else {
                $filename = \ar\core\comp('tools.util')->randpw(16, 'NUMBER')  . '.png';
            }

            $new_file = $uploadPath . '/' . $filename;
            
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $picBase64String)))){
                $errMsg['picurl'] = \ar\core\cfg('UPLOAD_IMG_URL_PREFIX') . '/' . date('Ymd', time()) . '/' . $filename;
            } else {
                $errMsg['errMsg'] = 'write err';
            }
        } else {
            $errMsg['errMsg'] = '格式错误';
        }
        $this->response($errMsg);
    }

}

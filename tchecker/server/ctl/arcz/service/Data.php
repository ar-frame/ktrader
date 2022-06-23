<?php

namespace server\ctl\arcz\service;
/**
 * 数据获取编辑
 */
class Data extends Base
{
    // 查看管理员操作日志  \ar\core\service('arcz.Data')->getLogList($uk, $count, $page, $search_col, $key, $sort_col, $sort_type);
    public function getLogList($uk, $count, $page, $search_col, $key, $sort_col, $sort_type)
    {
        // 登录用户详情
        $userDetail = \ar\core\service('arcz.User')->getLoginUser($uk);

        $isDev = $userDetail['isDev'];
        if($isDev==1){
            $condition['is_dev'] = [0,1];
        } else {
            $condition['is_dev'] = 0;
        }

        // 搜索
        $keyword = !empty($key) ? $key : '';
        if ($keyword) {
            $like = $search_col . ' like';
            $condition[$like] = '%'. $keyword . '%';
        }
        // 排序
        $sort_con = $sort_col . " " . $sort_type;

        $totalCount =  $this->arczdb->table(self::LOG_TABLENAME)->where($condition)->count();
        $pageObj = new \server\lib\ext\Page($totalCount, $count, $page);

        $logLists = $this->arczdb->table(self::LOG_TABLENAME)
            ->where($condition)
            ->order($sort_con)
            ->limit($pageObj->limit())
            ->queryAll();

        foreach($logLists as &$l){
            $l['log_date'] = date('Y-m-d H:i:s', $l['log_time']);
        }

        $arr = get_object_vars($pageObj);
        $totalPages = $arr['totalPages'];
        if ($page > $totalPages) {
            $logLists = [];
        }

        return [
            'logLists' => $logLists,
            'totalCount' => $totalCount,
            'totalPages' => $totalPages
        ];

    }

    // 查看日志详情  \ar\core\service('arcz.Data')->getLogDetail($id);
    public function getLogDetail($id)
    {
        $log = $this->arczdb->table(self::LOG_TABLENAME)->where(['id' => $id])->queryRow();
        $user = $this->arczdb->table(self::USER_TABLENAME)->where(['id' => $log['uid']])->queryRow();
        $log['nickname'] = $user['nickname'];
        $log['admin_face'] = $user['admin_face'];

        return $log;
    }

    // 查找开发者访问的所有通用(type = 1-9)功能按钮  \ar\core\service('arcz.Data')->findDevButtons($mid);
    public function findDevButtons($mid)
    {
        $buttons = $this->arczdb->table(self::MODEL_MENUFUNC_TABLENAME)->where(['mid' => $mid, 'status' => 1])->queryAll();
        // 列表按钮数量
        $count = $this->arczdb->table(self::MODEL_MENUFUNC_TABLENAME)->where(['mid' => $mid, 'status' => 1, 'type_button' => 0])->count();

        return ['buttons' => $buttons, 'count' => $count];

    }

    // 查找非开发者访问的所有通用(type = 1-9)功能按钮  \ar\core\service('arcz.Data')->findUserButtons($mid, $uk);
    public function findUserButtons($mid, $uk)
    {
        // 当前登录用户
        $userDetail = $userDetail = \ar\core\service('arcz.User')->getLoginUser($uk);
        $uid = $userDetail['id'];

        $unav = [];
        // 根据uid获取用户所属的用户组
        $role = \ar\core\service('arcz.User')->getRidByUid($uid);
        foreach($role as $key => $value){
            $gid = $role[$key]['gid'];
            // 根据gid获取用户组所属的功能权限ids
            $fids = \ar\core\service('arcz.User')->getFidByRid($gid,$mid);
            foreach($fids as $k => $v){
                // 将当前用户的权限id添加到数组
                array_push($unav,$v['fid']);
            }
        }
        // 去掉重复数据
        $unav = array_unique($unav);

        $funcids = \ar\core\service('arcz.Data')->findUserButtonsData($unav);

        return $funcids;
    }

    // 查找非开发者访问的所有通用(type = 1-9)功能按钮数据操作  \ar\core\service('arcz.Data')->findUserButtonsData($funcids);
    public function findUserButtonsData($funcids)
    {
        $buttons = [];
        $count = 0;

        foreach($funcids as &$fun){
            $func = $this->arczdb->table(self::MODEL_MENUFUNC_TABLENAME)->where(['id' => $fun, 'status' => 1])->queryRow();
            if($func){
                array_push($buttons,$func);
            }
            // 列表按钮数量
            if($func['type_button'] == 0){
                $count++;
            }
        }

        return ['buttons' => $buttons, 'count' => $count];

    }

    // 模型通用数据列表  \ar\core\service('arcz.Data')->modelDataList($mid, $count, $page, $search_col, $keyword, $sort_col, $sort_type);
    public function modelDataList($mid, $count, $page, $search_col, $keyword, $sort_col, $sort_type, $unikey)
    {
        // 条件
        $condition = [];
        // 排序
        $orders = $sort_col . " " . $sort_type;

        // 获取模型名称
        $model = $this->arczdb->table(self::MODELLIST_TABLENAME)
            ->where(['id' => $mid])
            ->queryRow();

        $modelName = '\server\lib\model\\' .  str_replace('/', '\\', $model['modelname']);

        // 查出模型字段
        $modelDetailColumns = $this->arczdb->table(self::MODEL_DETAIL_TABLENAME)
            ->where(['tablename' => $model['tablename']])
            ->queryAll('colname');

        // 查出 isshow = 1 的模型字段，用于搜索功能
        $columnIsshow = $this->arczdb->table(self::MODEL_DETAIL_TABLENAME)
            ->where(['tablename' => $model['tablename'], 'isshow' => 1])
            ->order('ordernum')
            ->queryAll();
        foreach ($columnIsshow as $key => &$value) {
            $showColumn[] = $value['colname'];
            $typeexplain[] = $value['typeexplain'];
        }


        $col = $search_col;
        // modelDetail表里查询搜索的字段类型
        $columnType = $this->arczdb->table(self::MODEL_DETAIL_TABLENAME)
            ->where(['tablename' => $model['tablename'], 'colname' => $col])
            ->queryRow();

        // 字段排序
        $selectStr = $this->getModelColumnsStr($mid);

        $datas = [];
        $totalCount = 0;
        $totalPages = 0;
        if (empty($keyword)||empty($col)) {
            $totalCount = $modelName::model()->getDb()
                ->where($condition)
                ->count();
            $pageObj = new \server\lib\ext\Page($totalCount, $count, $page);
            // 获取数据
            $datas = $modelName::model()->getDb()
                ->where($condition)
                ->order($orders)
                ->limit($pageObj->limit())
                ->select($selectStr)
                ->queryAll();
            $pageArr = get_object_vars($pageObj);
            $totalPages = $pageArr['totalPages'];
            if ($page > $totalPages) {
                $datas = [];
            }
        } else {
            if(!empty($col)){
                switch ($columnType['type']) {
                    case '0':  // 搜索项是字符串
                        $showColumnCondition = $col . " like ";
                        $condition[$showColumnCondition] = '%' . $keyword . '%';

                        $totalCount = $modelName::model()->getDb()->where($condition)->count();
                        $pageObj = new \server\lib\ext\Page($totalCount, $count, $page);
                        // 数据
                        $datas = $modelName::model()->getDb()
                            ->where($condition)
                            ->order($orders)
                            ->limit($pageObj->limit())
                            ->select($selectStr)
                            ->queryAll();
                        $pageArr = get_object_vars($pageObj);
                        $totalPages = $pageArr['totalPages'];
                        if ($page > $totalPages) {
                            $datas = [];
                        }

                        break;
                    case '8':  // 搜索项是外键
                        // 查询关联表名称
                        $linkTable = $this->arczdb->table(self::MODEL_FK_TABLENAME)
                            ->where(['mid' => $mid, 'mcolname' => $col])
                            ->queryRow();
                        // 关联模型名称
                        $linkTableModelName = '\server\lib\model\\' . $linkTable['fmodelname'];
                        $linkTableModelName = str_replace("/","\\",$linkTableModelName);
                        // 传入搜索条件
                        $con = $linkTable['fcolname'] . " like ";

                        // 关联字段名进行模糊查询
                        $searchCon[$con] = '%' . $keyword . '%';
                        // 根据关联字段名进行模糊查询关联表唯一键信息，可能为一个，可能为多个
                        $linkTableCons = $linkTableModelName::model()->getDb()
                            ->where($searchCon)
                            ->select($linkTable['fcolname'] . "," . $linkTable['funival'])
                            ->queryAll();

                        // 唯一键数量
                        $linkIds = $linkTableModelName::model()->getDb()->where($searchCon)->count();

                        // 最终搜索条件
                        if($linkIds==1){ // 只有一个唯一键符合条件
                            // 搜索条件
                            $condition = [$col => $linkTableCons[0][$linkTable['funival']]];
                            // 将单个唯一键作为条件放在主表查询
                            $totalCount = $modelName::model()->getDb()->where($condition)->count();
                            $pageObj = new \server\lib\ext\Page($totalCount, $count, $page);
                            // 获取数据
                            $datas = $modelName::model()->getDb()
                                ->where($condition)
                                ->order($orders)
                                ->limit($pageObj->limit())
                                ->select($selectStr)
                                ->queryAll();
                            $pageArr = get_object_vars($pageObj);
                            $totalPages = $pageArr['totalPages'];
                            if ($page > $totalPages) {
                                $datas = [];
                            }
                        } else if($linkIds>1){ // 有多个唯一键符合条件
                            // 搜索条件
                            $cons = [];
                            foreach($linkTableCons as $lcon){
                                array_push($cons,$lcon[$linkTable['funival']]);
                            }
                            $condition = [$col => $cons];
                            // 将多个唯一键作为条件放在主表查询
                            $totalCount = $modelName::model()->getDb()->where($condition)->count();
                            $pageObj = new \server\lib\ext\Page($totalCount, $count, $page);
                            // 获取数据
                            $datas = $modelName::model()->getDb()
                                ->where($condition)
                                ->order($orders)
                                ->limit($pageObj->limit())
                                ->select($selectStr)
                                ->queryAll();
                            $pageArr = get_object_vars($pageObj);
                            $totalPages = $pageArr['totalPages'];
                            if ($page > $totalPages) {
                                $datas = [];
                            }
                        }

                        break;
                    default:
                        # code...
                        break;
                }
            }

        }

        // 处理格式
        foreach ($datas as &$data) {
            foreach ($data as $keyColumn => &$d) {
                // 唯一键的值
                $unval = $data[$unikey];
                if(isset($modelDetailColumns[$keyColumn])){
                    $keyColumnDetail = $modelDetailColumns[$keyColumn];
                    // 按字段类型处理格式
                    switch($keyColumnDetail['type']) {
                        // type=0 字符串
                        case '0':
                            break;
                        // type=1 多个状态值
                        case '1':
                            // 字段类型说明
                            $typeex = $keyColumnDetail['typeexplain'];
                            // 根据'|'截取字符串并放入数组
                            $str1 = explode("|",$typeex);
                            foreach($str1 as $t){
                                // 截取':'前面的内容
                                $tn1 = substr($t,0,strpos($t, ':'));
                                // 截取':'后面的内容
                                $tn2 = substr($t,strpos($t, ':')+1);
                                if($d==$tn1){
                                    $d=$tn2;
                                }
                            }
                            break;
                        // type=2 开关状态值
                        case '2':
                            // 字段类型说明
                            $typeex = $keyColumnDetail['typeexplain'];
                            $colname = $keyColumnDetail['colname'];
                            $d == 0 ? $check = '' : $check = 'checked';
                            $d = '<input type="checkbox" class="ace ace-switch ace-switch-6 switch_model" value="'.$unval.'" name="'.$colname.'" '.$check.'><span class="lbl middle"></span>';
                            break;
                        // type=3 文章
                        case '3':
                            $colname = $keyColumnDetail['colname'];
                            $d = '<button type="button" id="typeContent_'.$colname.'_' .$unval.'" class="btn btn-white btn-primary btn-xs" data-toggle="modal" data-target="#checkContent">点击查看内容</button>';
                            break;
                        // type=4 图片
                        case '4':
                            $d = \ar\core\cfg('CZ_PUB_SERVER_PATH') . $d;
                            $img = '<img src="' . $d . '" style="height:32px;width:32px;">';
                            $d = $img;
                            break;
                        // type=5 时间戳
                        case '5':
                            $dateTypeExplain = $keyColumnDetail['typeexplain'];
                            $d = date($dateTypeExplain, $d);
                            break;
                        // type=6 整数
                        case '6':
                            break;
                        // type=7 浮点数
                        case '7':
                            break;
                        // type=8 外键
                        case '8':
                            // 根据表名及字段名称查找模型外键关联表信息
                            $mtablename = $keyColumnDetail['tablename'];
                            $mcolname = $keyColumnDetail['colname'];
                            $con = [
                                'mtablename' => $mtablename,
                                'mcolname' => $mcolname
                            ];
                            $fkDetail = $this->getFkModel($con);
                            $fid = $fkDetail['fid'];
                            $fk_id = $fkDetail['id'];
                            $unival = $d;
                            if($fid > 0){
                                // 关联模型名
                                $strFmodelname = $fkDetail['fmodelname'];
                                // 截取'/'前面的内容
                                $sForder = substr($strFmodelname,0,strpos($strFmodelname, '/'));
                                // 截取'/'后面的内容
                                $sModelname = substr($strFmodelname,strpos($strFmodelname, '/')+1);
                                $fmodelname = '\server\lib\model\\' . $sForder . '\\' . $sModelname;
                                // 关联模型字段名
                                $fcolname = $fkDetail['fcolname'];
                                // 关联表映射键名 $fkid
                                $fkid = $fkDetail['funival'];
                                // 映射键值 $unival
                                // 查找关联模型信息
                                $fmodelDetail = $fmodelname::model()->getDb()
                                    ->where([$fkid => $unival])
                                    ->queryRow();

                                if ($fmodelDetail) {
                                    // 查找关联字段值
                                    $d = $fmodelDetail[$fcolname];
                                }
                               
                            } else {
                                $d = $unival;
                            }
                            break;

                    }
                }
            }
        }
        return [
            'data' => $datas,
            'count' => $totalCount,
            'totalPages' => $totalPages
        ];
    }

    // 获取模型  \ar\core\service('arcz.Data')->getModel($mid);
    public function getModel($mid)
    {

        $model = $this->arczdb->table(self::MODELLIST_TABLENAME)
            ->where(['id' => $mid])
            ->queryRow();

        list($dbConfigName, $tableName) = explode('.', $model['tablename']);

        $model['table_real_name'] = $tableName;
        $model['db_config_name'] = $dbConfigName;
        return $model;
    }

    // 根据表名和字段名获取关联模型  \ar\core\service('arcz.Data')->getFkModel($data);
    public function getFkModel($data)
    {
        return $this->arczdb->table(self::MODEL_FK_TABLENAME)->where($data)->queryRow();
    }

    // 获取模型所有字段名  \ar\core\service('arcz.Data')->getModelColumns($mid);
    public function getModelColumns($mid)
    {
        $model = $this->getModel($mid);
        $columns = $this->arczdb->table(self::MODEL_DETAIL_TABLENAME)
            ->where(['tablename' => $model['tablename']])
            ->order('ordernum')
            ->queryAll();
        foreach ($columns as &$column) {
            $column['colname'] = trim($column['colname']);
            $column['colshowname'] = $column['explain'] ? $column['explain'] : $column['colname'];
            if($column['type']==8){
                $mtablename = $column['tablename'];
                $mcolname = $column['colname'];
                $con = [
                    'mtablename' => $mtablename,
                    'mcolname' => $mcolname
                ];
                $fkDetail = $this->getFkModel($con);
                $fcolname = $fkDetail['fexplain'] ? $fkDetail['fexplain'] : $fkDetail['fcolname'];
                $column['colshowname'] = $column['colshowname'];
            }
            $column['issort'] == 1 ? $column['issort']=true : $column['issort']=false;
        }
        return $columns;
    }

    // 获取模型所有可显示字段名  \ar\core\service('arcz.Data')->getModelColumnsIsShow($mid);
    public function getModelColumnsIsShow($mid)
    {
        $model = $this->getModel($mid);
        $columns = $this->arczdb->table(self::MODEL_DETAIL_TABLENAME)
            ->where(['tablename' => $model['tablename'], 'isshow' => 1])
            ->order('ordernum')
            ->queryAll();
        foreach ($columns as &$column) {
            $column['colname'] = trim($column['colname']);
            $column['colshowname'] = $column['explain'] ? $column['explain'] : $column['colname'];
            if($column['type']==8){
                $mtablename = $column['tablename'];
                $mcolname = $column['colname'];
                $con = [
                    'mtablename' => $mtablename,
                    'mcolname' => $mcolname
                ];
                $fkDetail = $this->getFkModel($con);
                $fcolname = $fkDetail['fexplain'] ? $fkDetail['fexplain'] : $fkDetail['fcolname'];
                $column['colshowname'] = $column['colshowname'];
            }
            $column['issort'] == 1 ? $column['issort']=true : $column['issort']=false;
        }
        return $columns;
    }

    // 获取模型所有可查看字段名  \ar\core\service('arcz.Data')->getModelColumnsView($mid);
    public function getModelColumnsView($mid)
    {
        $model = $this->getModel($mid);
        $columns = $this->arczdb->table(self::MODEL_DETAIL_TABLENAME)
            ->where(['tablename' => $model['tablename'], 'isview' => 1])
            ->order('ordernum')
            ->queryAll();
        foreach ($columns as &$column) {
            $column['colname'] = trim($column['colname']);
            $column['colshowname'] = $column['explain'] ? $column['explain'] : $column['colname'];
            if($column['type']==8){
                $mtablename = $column['tablename'];
                $mcolname = $column['colname'];
                $con = [
                    'mtablename' => $mtablename,
                    'mcolname' => $mcolname
                ];
                $fkDetail = $this->getFkModel($con);
                $fcolname = $fkDetail['fexplain'] ? $fkDetail['fexplain'] : $fkDetail['fcolname'];
                $column['colshowname'] = $column['colshowname'];
            }
            $column['issort'] == 1 ? $column['issort']=true : $column['issort']=false;
        }
        return $columns;
    }

    // 获取模型所有可编辑字段名  \ar\core\service('arcz.Data')->getModelColumnsEdit($mid);
    public function getModelColumnsEdit($mid)
    {
        $model = $this->getModel($mid);
        $columns = $this->arczdb->table(self::MODEL_DETAIL_TABLENAME)
            ->where(['tablename' => $model['tablename'], 'isedit' => 1])
            ->order('ordernum')
            ->queryAll();
        foreach ($columns as &$column) {
            $column['colname'] = trim($column['colname']);
            $column['colshowname'] = $column['explain'] ? $column['explain'] : $column['colname'];
            if($column['type']==8){
                $mtablename = $column['tablename'];
                $mcolname = $column['colname'];
                $con = [
                    'mtablename' => $mtablename,
                    'mcolname' => $mcolname
                ];
                $fkDetail = $this->getFkModel($con);
                $fcolname = $fkDetail['fexplain'] ? $fkDetail['fexplain'] : $fkDetail['fcolname'];
                $column['colshowname'] = $column['colshowname'];
            }
            $column['issort'] == 1 ? $column['issort']=true : $column['issort']=false;
        }
        return $columns;
    }

    // 获取模型可显示字段名Str  \ar\core\service('arcz.Data')->getModelColumnsStr($mid);
    public function getModelColumnsStr($mid)
    {
        $model = $this->getModel($mid);
        $columns = $this->arczdb->table(self::MODEL_DETAIL_TABLENAME)
            ->where(['tablename' => $model['tablename'], 'isshow' => 1])
            ->order('ordernum')
            ->queryAll();
        $columnsCount = $this->arczdb->table(self::MODEL_DETAIL_TABLENAME)->where(['tablename' => $model['tablename'], 'isshow' => 1])->count();
        $columnsStr = "";
        foreach ($columns as $key => $column) {
            $colname = $column['colname'];
            $columnsStr .= $colname;
            if($key != ($columnsCount-1)){
                $columnsStr .= ",";
            }
        }
        $columnsStr .= "";
        return $columnsStr;
    }

    // 获取模型是否有唯一键  \ar\core\service('arcz.Data')->modelHasUniqueKey($mid);
    public function modelHasUniqueKey($mid)
    {
        $model = $this->getModel($mid);
        return $this->arczdb->table(self::MODEL_DETAIL_TABLENAME)
            ->order('ordernum')
            ->where(['isunique' => 1, 'tablename' => $model['tablename']])
            ->count() > 0;
    }

    // 获取模型的唯一键  \ar\core\service('arcz.Data')->modelUniqueKey($mid);
    public function modelUniqueKey($mid)
    {
        $model = $this->getModel($mid);
        $unikey = $this->arczdb->table(self::MODEL_DETAIL_TABLENAME)
            ->where(['isunique' => 1, 'tablename' => $model['tablename']])
            ->queryColumn('colname');
        if ($unikey) {
            return $unikey;
        } else {
            return 'id';
        }
    }

    // 根据模型id获取对应菜单  \ar\core\service('arcz.Data')->getMenuByModel($mid);
    public function getMenuByModel($mid)
    {
        return $this->arczdb->table(self::NAV_TABLENAME)
            ->where(['mid' => $mid])
            ->queryRow();
    }

    // 获取模型名称  \ar\core\service('arcz.Data')->getModelName($mid, $full = true);
    public function getModelName($mid, $full = true)
    {
        $model = $this->getModel($mid);
        if ($full) {
            return '\server\lib\model\\' . str_replace('/', '\\', $model['modelname']);
        } else {
            return $model['modelname'];
        }
    }

    // 设置开关状态值  \ar\core\service('arcz.Data')->setSwitchNow($mid, $colname, $id, $value, $uk, $loginip);
    public function setSwitchNow($mid, $colname, $id, $value, $uk, $loginip)
    {
        // 当前登录用户详情
        $userDetail = \ar\core\service('arcz.User')->getLoginUser($uk);
        $nowid = $userDetail['id'];

        $errCode = 1000;
        $errMsg = '';

        // 菜单详情
        $navDetail = \ar\core\service('arcz.Specialized')->getNavDetailByMid($mid);
        $navTitle = $navDetail['title'];
        // 权限验证
        $isFunc = \ar\core\service('arcz.Specialized')->queryFuncByCon($mid, 2, '', $uk);
        if($isFunc){
            $uniKey = $this->modelUniqueKey($mid);
            $modelName = $this->getModelName($mid, true);
            $con = [
                $uniKey => $id
            ];
            $setResult = $modelName::model()->getDb()
                ->where($con)
                ->update([$colname => (int)$value]);
            if ($setResult) {
                // 日志记录
                $title = '编辑数据';
                $content = '管理员编辑菜单: ' . $navTitle . ' 的数据 ID: ' . $id;
                \ar\core\service('arcz.Specialized')->addAdminLog($nowid, $title, $content, $loginip);
                $errMsg = '操作成功';
            } else {
                $errCode = 6004;
                $errMsg = '操作失败，请稍后重试';
            }
        } else {
            $errCode = 2550;
            $errMsg = '非法操作！你没有修改权限';
        }

        return ['errCode' => $errCode, 'errMsg' => $errMsg];

    }

    // 根据指定字段查看模型文章内容  \ar\core\service('arcz.Data')->getColContent($mid, $colname, $id);
    public function getColContent($mid, $colname, $id)
    {
        $uniKey = $this->modelUniqueKey($mid);
        $modelName = $this->getModelName($mid, true);
        $con = [
            $uniKey => $id
        ];
        $result = $modelName::model()->getDb()->where($con)->select($colname)->queryRow();
        $d = $result[$colname];
        $d = stripslashes($d);
        $d = stripcslashes($d);
        $content = ['contentView' => $d];
        return $content;
    }

    // 获取数据  \ar\core\service('arcz.Data')->getDataByUniKey($mid, $id);
    public function getDataByUniKey($mid, $id)
    {
        $tableName = $this->getModelRealTableName($mid);
        $uniKey = $this->modelUniqueKey($mid);


        $row = \ar\core\comp('db.mysql')->read($this->getModelDbConfigName($mid))->table($tableName)
            ->where([$uniKey => $id])
            ->queryRow();

        return $row;

            // var_dump($row);

            // return $row;

        $realtname = $this->getModelDbConfigName($mid) . '.' . $tableName;
        foreach ($row as $key => $data) {
            var_dump($key);
            $colDetail = $this->arczdb->table(self::MODEL_DETAIL_TABLENAME)
                ->where(['tablename' => $realtname, 'colname' => $key])
                ->queryRow();
            // var_dump(self::MODEL_DETAIL_TABLENAME,$tableName, $key);
            if($colDetail['type']==4){ 
                $row[$key] = \ar\core\cfg('CZ_PUB_SERVER_PATH') . $data;
            }
        }

        var_dump($row);

        return $row;

       


        // case '4':
        //     $d = \ar\core\cfg('CZ_PUB_SERVER_PATH') . $d;
        //     $img = '<img src="' . $d . '" style="height:32px;width:32px;">';
        //     $d = $img;


        // return 
    }

    // 获取模型真实数据表  \ar\core\service('arcz.Data')->getModelRealTableName($mid);
    public function getModelRealTableName($mid)
    {
        $model = $this->getModel($mid);
        return $model['table_real_name'];
    }

    // 获取模型数据库配置名  \ar\core\service('arcz.Data')->getModelDbConfigName($mid);
    public function getModelDbConfigName($mid)
    {
        $model = $this->getModel($mid);
        return $model['db_config_name'];
    }

    // 获取模型真实数据表  \ar\core\service('arcz.Data')->getModelRealTabelName($mid);
    public function getModelRealTabelName($mid)
    {
        $model = $this->getModel($mid);
        return $model['table_real_name'];
    }

    // 提交模型数据  \ar\core\service('arcz.Data')->modelDataEdit($data, $mid, $uniKeyName, $uniKeyVal, $uk, $ip);
    public function modelDataEdit($data, $mid, $uniKeyName, $uniKeyVal, $uk, $loginip)
    {
        // 当前登录用户详情
        $userDetail = \ar\core\service('arcz.User')->getLoginUser($uk);
        $nowid = $userDetail['id'];

        $errCode = 1000;
        $errMsg = '';

        // 菜单详情
        $navDetail = \ar\core\service('arcz.Specialized')->getNavDetailByMid($mid);
        $navTitle = $navDetail['title'];

        if($uniKeyVal>0){ // 编辑
            // 权限验证
            $isFunc = \ar\core\service('arcz.Specialized')->queryFuncByCon($mid, 2, '', $uk);
            // 日志记录参数
            $title = '编辑数据';
            $content = '管理员编辑菜单: ' . $navTitle . ' 的数据 ID: ' . $uniKeyVal;
        } else { // 添加
            // 权限验证
            $isFunc = \ar\core\service('arcz.Specialized')->queryFuncByCon($mid, 1, '', $uk);
            // 日志记录参数
            $title = '添加数据';
            $content = '管理员添加菜单: ' . $navTitle . ' 的数据';
        }
        
        // \ar\core\comp('tools.log')->record([$isFunc, $userDetail], 'isFunc');
        if($isFunc){
            $tableName = $this->getModelRealTabelName($mid);
            $modelDetailTablename = $this->getModelDbConfigName($mid) . '.' . $tableName;
            $isRequire = 0;
            $requireCol = '';
            foreach($data as $k => $d){
                $colDetail = $this->arczdb->table(self::MODEL_DETAIL_TABLENAME)->where(['tablename' => $modelDetailTablename, 'colname' => $k])->queryRow();
                if($colDetail['type']==5){ // 日期字符串转时间戳
                    $data[$k] = strtotime($d);
                } else if ($colDetail['type']==9) { // 视频处理

                    $mp4mark = 'data:video/mp4;base64,';

                    if (substr($d, 0, strlen($mp4mark)) == $mp4mark) {

                        $uploadPath = \ar\core\cfg('UPLOAD_VIDEO_PATH') . '/' . date('Ymd', time());

                        $filename = \ar\core\comp('tools.util')->randpw(16, 'NUMBER')  . '.mp4';
                        $new_file = $uploadPath . '/' . $filename;

                        if (!file_exists($uploadPath)) {
                             mkdir($uploadPath, 0755, true);
                        }

                        // \ar\core\comp('tools.log')->record([$new_file], 'dv');

                        if (file_put_contents($new_file, base64_decode(substr($d, strlen($mp4mark))))){
                            $data[$k] = \ar\core\cfg('UPLOAD_VIDEO_PREFIX') . '/' . date('Ymd', time()) . '/' . $filename;;
                        } else {
                            // $data[$k] = 'write err';
                        }
                    }
                    
                }

                if($d==''){ // 是否必填
                    $row = $this->arczdb->table(self::MODEL_DETAIL_TABLENAME)->where(['tablename' => $modelDetailTablename, 'colname' => $k, 'isrequire' => 1, 'isedit' => 1])->queryRow();
                    if($row){
                        $row['colname'] = trim($row['colname']);
                        $row['colshowname'] = $row['explain'] ? $row['explain'] : $row['colname'];
                        if($row['type']==8){
                            $mtablename = $row['tablename'];
                            $mcolname = $row['colname'];
                            $con = [
                                'mtablename' => $mtablename,
                                'mcolname' => $mcolname
                            ];
                            $fkDetail = $this->getFkModel($con);
                            $fcolname = $fkDetail['fexplain'] ? $fkDetail['fexplain'] : $fkDetail['fcolname'];
                            $row['colshowname'] = $row['colshowname'];
                        }
                        $isRequire = 1;
                        $requireCol = $row['colshowname'];
                        break;
                    }
                }
            }
            if($isRequire==0){
                if ($uniKeyVal>0) { // 编辑
                    $updateData = \ar\core\comp('db.mysql')->read($this->getModelDbConfigName($mid))->table($tableName)
                        ->where([$uniKeyName => $uniKeyVal])
                        ->update($data, true);
                } else { // 新增
                    $updateData = \ar\core\comp('db.mysql')->read($this->getModelDbConfigName($mid))->table($tableName)
                        ->insert($data, 1);
                }
                if ($updateData) {
                    // 日志记录
                    \ar\core\service('arcz.Specialized')->addAdminLog($nowid, $title, $content, $loginip);
                    $errMsg = '操作成功';
                } else {
                    $errCode = 6004;
                    $errMsg = '操作失败，请稍后重试';
                }
            } else {
                $errCode = 3005;
                $errMsg = '操作失败，' . $requireCol . '不能为空';
            }
        } else {
            $errCode = 2550;
            $errMsg = '非法操作！你没有相关权限';
        }

        return ['errCode' => $errCode, 'errMsg' => $errMsg];

    }

    // 外键关联数据列表  \ar\core\service('arcz.Data')->getFkDataList($mtablename, $mcolname, $cval);
    public function getFkDataList($mtablename, $mcolname, $cval)
    {
        // 根据表名及字段名称查找模型外键关联表信息
        $con = [
            'mtablename' => $mtablename,
            'mcolname' => $mcolname
        ];
        $fkDetail = $this->arczdb->table(self::MODEL_FK_TABLENAME)->where($con)->queryRow();
        $fid = $fkDetail['fid'];
        $fk_id = $fkDetail['id'];
        // 映射键的值
        $unival = $cval;
        $optionStr = '<option value="">---请选择---</option>';
        if($fid > 0){
            // 关联模型名
            $strFmodelname = $fkDetail['fmodelname'];
            // 截取'/'前面的内容
            $sForder = substr($strFmodelname,0,strpos($strFmodelname, '/'));
            // 截取'/'后面的内容
            $sModelname = substr($strFmodelname,strpos($strFmodelname, '/')+1);

            $fmodelname = '\server\lib\model\\' . $sForder . '\\' . $sModelname;

            // 关联模型字段名
            $fcolname = $fkDetail['fcolname'];
            // 关联表映射键名 $fkid
            $fkid = 'id';
            $funikey = $fkDetail['funival'];
            if ($funikey) {
                $fkid = $funikey;
            }
            // 唯一键值 $unival
            // 查找关联模型信息
            $fmodelDetail = $fmodelname::model()->getDb()
                ->queryAll();
            foreach($fmodelDetail as $de){
                $seled = '';
                if($unival==$de[$fkid]){
                    $seled = 'selected';
                }
                $optionStr .= '<option value="'.$de[$fkid].'"  '.$seled.'>'.$de[$fcolname].'</option>';
            }
        } else {
            $optionStr .= '<option value="">---请在模型管理里面编辑外键关联模型---</option>';
        }

        return ['option' => $optionStr];

    }

    // 删除模型对应数据  \ar\core\service('arcz.Data')->delModelData($mid, $id, $uk, $loginip);
    public function delModelData($mid, $id, $uk, $loginip)
    {
        // 当前登录用户详情
        $userDetail = \ar\core\service('arcz.User')->getLoginUser($uk);
        $nowid = $userDetail['id'];

        $errCode = 1000;
        $errMsg = '';

        // 菜单详情
        $navDetail = \ar\core\service('arcz.Specialized')->getNavDetailByMid($mid);
        $navTitle = $navDetail['title'];
        // 权限验证
        $isFunc = \ar\core\service('arcz.Specialized')->queryFuncByCon($mid, 2, '', $uk);
        if($isFunc){
            $uniKey = $this->modelUniqueKey($mid);
            $modelName = $this->getModelName($mid, true);
            $delResult = $modelName::model()->getDb()->where([$uniKey => $id])->delete();
            if ($delResult) {
                // 日志记录
                $title = '删除数据';
                $content = '管理员删除菜单: ' . $navTitle . ' 的数据 ID: ' . $id;
                \ar\core\service('arcz.Specialized')->addAdminLog($nowid, $title, $content, $loginip);
                $errMsg = '删除成功';
            } else {
                $errCode = 6003;
                $errMsg = '删除失败，数据不存在';
            }
        } else {
            $errCode = 2550;
            $errMsg = '非法操作！你没有相关权限';
        }

        return ['errCode' => $errCode, 'errMsg' => $errMsg];

    }

    // 自定义显示列  \ar\core\service('arcz.Data')->editShowCol($tablename, $colname, $type, $uk, $loginip);
    public function editShowCol($tablename, $colname, $type, $uk, $loginip)
    {
        // 当前登录用户详情
        $userDetail = \ar\core\service('arcz.User')->getLoginUser($uk);

        $errCode = 1000;
        $errMsg = '';

        $uid = $userDetail['id'];

        // 模型详情
        $modelRow = $this->arczdb->table(self::MODELLIST_TABLENAME)->where(['tablename' => $tablename])->queryRow();
        $mid = $modelRow['id'];
        // 权限
        $isFunc = \ar\core\service('arcz.Specialized')->queryFuncByCon($mid, 6, '', $uk);
        if($isFunc){
            $con = ['tablename' => $tablename, 'colname' => $colname];
            $editResult = $this->arczdb->table(self::MODEL_DETAIL_TABLENAME)->where($con)->update(['isshow' => $type]);
            if ($editResult) {
                // 日志记录
                $title = '编辑自定义显示列';
                if($type==1){
                    $isshow = ' 显示 ';
                } else if($type==0){
                    $isshow = ' 不显示 ';
                }
                $content = '管理员设置: ' . $tablename . ' 字段: ' . $colname . $isshow;
                \ar\core\service('arcz.Specialized')->addAdminLog($uid, $title, $content, $loginip);
                $errMsg = '编辑成功';
            } else {
                $errCode = 6003;
                $errMsg = '编辑失败';
            }
        } else {
            $errCode = 2550;
            $errMsg = '非法操作！你没有相关权限';
        }

        return ['errCode' => $errCode, 'errMsg' => $errMsg];

    }

    // 设置菜单是否可编辑删除
    public function setMenuNow($colname, $id, $value)
    {
        $con = ['id' => $id];

        return $this->arczdb->table(self::MODELLIST_TABLENAME)
            ->where($con)
            ->update([$colname => (int)$value]);
    }

    // 开关自定义功能
    public function setFuncNow($colname, $id, $value)
    {
        $con = ['id' => $id];

        return $this->arczdb->table(self::MODEL_MENUFUNC_TABLENAME)
            ->where($con)
            ->update([$colname => (int)$value]);
    }

    // 根据模型名称查找模型字段
    public function getCol($tablename)
    {
        $colLists = $this->arczdb->table(self::MODEL_DETAIL_TABLENAME)
            ->where(['tablename' => $tablename])
            ->queryAll();

        return [
            'colLists' => $colLists,
        ];
    }

    // 根据模型名及条件查看否存在
    public function getModelDetail($con)
    {
        return $this->arczdb->table(self::MODEL_DETAIL_TABLENAME)
            ->where($con)
            ->queryAll();
    }

    // 获取菜单关联模型
    public function getNavModel($id)
    {
        return $this->arczdb->table(self::NAV_TABLENAME)
            ->where(['id' => $id])
            ->queryRow();
    }

    // 根据表名获取模型
    public function getModelByName($tname)
    {
        return $this->arczdb->table(self::MODELLIST_TABLENAME)
            ->where(['tablename' => $tname])
            ->queryRow();
    }

    // 根据表名查找所有多状态值字段
    public function getModelDetailByName($tname)
    {
        return $this->arczdb->table(self::MODEL_DETAIL_TABLENAME)
            ->where(['tablename' => $tname, 'type' => [1,2]])
            ->queryAll();
    }

    // 根据id查找模型字段详情
    public function getModelDetailById($id)
    {
        return $this->arczdb->table(self::MODEL_DETAIL_TABLENAME)
            ->where(['id' => $id])
            ->queryRow();
    }

    // 获取模型数据表
    public function getModelTabelName($mid)
    {
        $model = $this->getModel($mid);
        return $model['tablename'];
    }



}

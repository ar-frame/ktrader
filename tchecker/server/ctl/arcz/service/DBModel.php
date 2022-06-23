<?php
/**
 * Powerd by ArPHP.
 *
 * Index service.
 *
 */
namespace server\ctl\arcz\service;

define('COOP_SYSTEM', dirname(dirname(dirname(dirname(dirname(__FILE__))))));

class DBModel extends Base
{

    // 数据表  \ar\core\service('arcz.DBModel')->tableLists($request);
    public function tableLists($request)
    {
        // var_dump($request);
        $dbConfig = $request['db'];
        // 获取公告配置文件中的数据库名
        $dbInfo = $this->dbInfo($dbConfig);

        $tablename_in_db = 'Tables_in_'.$dbInfo['dbname'];

        $sqlShowTables = 'show tables;';
        $tables = \ar\core\comp('db.mysql')->read($dbConfig)->sqlQuery($sqlShowTables);

        $countTables = count($tables);

        $newTables = array();
        $count = 0;
        for ($i=0; $i < $countTables; $i++) {
            $str = $tables[$i][$tablename_in_db];
            // 判断是否为系统表
            if(substr($str, 0, 2) != 'cz') {
                $tableName = $dbConfig . '.' . $tables[$i][$tablename_in_db];
                $modelRow = $this->arczdb->table(self::MODELLIST_TABLENAME)
                    ->where(['tablename' => $tableName])
                    ->queryRow();
                // 判断是否存在模型
                if(!$modelRow){
                    $newTables[$i]['ismodel'] = '0';
                } else {
                    $newTables[$i]['ismodel'] = '1';
                }
                $newTables[$i]['name'] = $tableName;
                $count++;

            }
        }

        return ['tableLists' => $newTables, 'count' => $count];

    }

    // 获取数据表配置信息
    public function dbInfo($config = 'default')
    {
        $dbinfo = \ar\core\cfg("components.db.mysql.config.read." . $config);//
        $dbhostInfo = $dbinfo['dsn'];
        $dbusername = $dbinfo['user'];
        $dbpassword = $dbinfo['pass'];

        $arr = explode(";", $dbhostInfo);
        $servername = substr($arr[0], strpos($arr[0], "=")+1);
        $dbname = substr($arr[1], strpos($arr[1], "=")+1);

        return ['servername' => $servername, 'dbusername' => $dbusername, 'dbpassword' => $dbpassword, 'dbname' => $dbname];
    }


    // 获取所有的数据库列表  \ar\core\service('arcz.DBModel')->getDbLists();
    public function getDbLists()
    {
        $dbReadConfig = \ar\core\cfg('components.db.mysql.config.read');
        $dbNames = array_keys($dbReadConfig);
        array_shift($dbNames);
        return $dbNames;
    }

    // 生成模型  \ar\core\service('arcz.DBModel')->addModel($data, $uk, $loginip);
    public function addModel($data, $uk, $loginip)
    {
        // 当前登录用户详情
        $userDetail = \ar\core\service('arcz.User')->getLoginUser($uk);
        $nowid = $userDetail['id'];

        $errCode = 1000;
        $errMsg = '';
        // 判断当前管理员是否为开发者
        $isDev = $userDetail['isDev'];
        if($isDev==1){
            $modelRow = $this->arczdb->table(self::MODELLIST_TABLENAME)
                ->where(['modelname' => $data['modelname']])
                ->queryRow();

            if($modelRow){
                // 如果数据存在则返回false
                $errCode = 3001;
                $errMsg = '数据存在';
            } else {
                // 是否存在文件
                $filePath = COOP_SYSTEM."/server/lib/model/" . $data['modelname'] . ".php"; // 路径
                $hasFile = is_file($filePath);

                $add = $this->arczdb->table(self::MODELLIST_TABLENAME)->insert($data, 1);
                if($add) {
                    if(!$hasFile){
                        // 创建文件
                        $this->changeModelFile($data['modelname'], $data['tablename']);
                    }

                    // 修改状态
                    $update = $this->arczdb->table(self::MODELLIST_TABLENAME)
                        ->where(['tablename' => $data['tablename']])
                        ->update(['status' => 1]);
                    if($update){
                        // return $update;
                        // cz_admin_model_detail表中记录新生成的模型数据表字段信息
                        // 查询新生成模型的数据表的字段
                        $modelTableCols = $this->viewField($data);
                        $totalCols = count($modelTableCols['fileds']);
                        for ($i=0; $i < $totalCols-1; $i++) { // modelTableCols数组中增加了一个数据表名信息，所以需要长度减一
                            if($modelTableCols['fileds'][$i]=='id'){
                                $insertCon = [
                                    'tablename' => $data['tablename'],
                                    'colname' => $modelTableCols['fileds'][$i],
                                    'isshow' => 1,
                                    'isedit' => 0,
                                    'ordernum' => $i+1
                                ];
                            } else {
                                $insertCon = [
                                    'tablename' => $data['tablename'],
                                    'colname' => $modelTableCols['fileds'][$i],
                                    'isshow' => 1,
                                    'isedit' => 1,
                                    'ordernum' => $i+1
                                ];
                            }
                            // cz_admin_model_detail表中插入字段信息
                            $insertModelTableCols = $this->arczdb->table(self::MODEL_DETAIL_TABLENAME)->insert($insertCon,1);

                        }

                        // cz_admin_model_menufunc插入默认功能数据 1添加 2编辑 3删除 4显示详情 5搜索 6自定义显示列 7导出Excel 8打印列表
                        $menufunc_datas = [
                            ['mid' => $add, 'title' => '添加', 'name' => 'add', 'type' => 1, 'status' => 1, 'updatetime' => time(), 'type_button' => 1],
                            ['mid' => $add, 'title' => '编辑', 'name' => 'edit', 'type' => 2, 'status' => 1, 'updatetime' => time()],
                            ['mid' => $add, 'title' => '删除', 'name' => 'del', 'type' => 3, 'status' => 1, 'updatetime' => time()],
                            ['mid' => $add, 'title' => '显示详情', 'name' => 'view', 'type' => 4, 'status' => 1, 'updatetime' => time()],
                            ['mid' => $add, 'title' => '搜索', 'name' => 'search', 'type' => 5, 'status' => 1, 'updatetime' => time(), 'type_button' => 1],
                            ['mid' => $add, 'title' => '自定义显示列', 'name' => 'costom', 'type' => 6, 'status' => 1, 'updatetime' => time(), 'type_button' => 1],
                            ['mid' => $add, 'title' => '导出Excel', 'name' => 'loadexcel', 'type' => 7, 'status' => 1, 'updatetime' => time(), 'type_button' => 1],
                            ['mid' => $add, 'title' => '打印列表', 'name' => 'print', 'type' => 8, 'status' => 1, 'updatetime' => time(), 'type_button' => 1]
                        ];
                        foreach($menufunc_datas as &$md){
                            // 循环向cz_admin_model_menufunc插入默认功能数据
                            $fid = $this->arczdb->table(self::MODEL_MENUFUNC_TABLENAME)->insert($md);
                            if($fid){
                                // cz_admin_group_func插入值  默认为超级管理员开通功能type1-9
                                $groupfunc_data = [
                                    'gid' => 1,
                                    'mid' => $add,
                                    'fid' => $fid
                                ];
                                $this->arczdb->table(self::GROUP_FUNC_TABLENAME)->insert($groupfunc_data);
                            }
                        }

                        // cz_admin_model_detail 表中，查询刚刚插入的值
                        $newInsertCols = $this->arczdb->table(self::MODEL_DETAIL_TABLENAME)->where(['tablename' => $data['tablename']])->count();
                        if ($newInsertCols == $totalCols-1) { // modelTableCols数组中增加了一个数据表名信息，所以需要长度减一
                            // 日志记录
                            $title = '创建模型';
                            $content = '创建模型 ' . $data['modelname'];
                            \ar\core\service('arcz.Specialized')->addAdminLog($nowid, $title, $content, $loginip);
                            $errMsg = '创建模型成功';
                        } else {
                            $errCode = 2001;
                            $errMsg = '创建模型失败';
                        }
                    }

                }
            }
        } else {
            $errCode = 2550;
            $errMsg = '非法操作！';
        }

        return ['errCode' => $errCode, 'errMsg' => $errMsg];

    }

    // 添加模型字段  \ar\core\service('arcz.DBModel')->addModelCol($data, $colname, $uk, $loginip);
    public function addModelCol($data, $colname, $uk, $loginip)
    {
        // 当前登录用户详情
        $userDetail = \ar\core\service('arcz.User')->getLoginUser($uk);
        $nowid = $userDetail['id'];

        $errCode = 1000;
        $errMsg = '';
        // 判断当前管理员是否为开发者
        $isDev = $userDetail['isDev'];
        if($isDev==1){
            // 所有表字段
            $modelTableCols = $this->viewField($data);
            $hasCol = 0;
            foreach($modelTableCols['fileds'] as $col){
                if($col==$colname){
                    $hasCol = 1;
                }
            }
            if($hasCol==1){
                $rCol = 0;
                // 模型详细信息
                $modelDetails = $this->arczdb->table(self::MODEL_DETAIL_TABLENAME)->where(['tablename' => $data['tablename']])->queryAll();
                foreach($modelDetails as $m){
                    if($m['colname']==$colname){
                        $rCol = 1;
                    }
                }
                if($rCol==1){
                    $errCode = 3001;
                    $errMsg = '数据表' . $data['tablename'] . '已存在"' . $colname . '"字段！请勿添加重复字段';
                } else {
                    $modelCount = $this->arczdb->table(self::MODEL_DETAIL_TABLENAME)->where(['tablename' => $data['tablename']])->count();
                    $insertData = [
                        'tablename' => $data['tablename'],
                        'colname' => $colname,
                        'isshow' => 1,
                        'isedit' => 1,
                        'ordernum' => $modelCount+1
                    ];
                    // cz_admin_model_detail表中插入字段信息
                    $insertModelTableCols = $this->arczdb->table(self::MODEL_DETAIL_TABLENAME)->insert($insertData,1);
                    if($insertModelTableCols){
                        // 日志记录
                        $title = '新增模型字段';
                        $content = '新增模型 ' . $data['modelname'] . '字段' . $colname;
                        \ar\core\service('arcz.Specialized')->addAdminLog($nowid, $title, $content, $loginip);
                        $errMsg = '新增模型字段成功';
                    } else {
                        $errCode = 1001;
                        $errMsg = '新增模型字段失败';
                    }
                }
            } else {
                $errCode = 2001;
                $errMsg = '数据表' . $data['tablename'] . '不存在"' . $colname . '"字段！请先在数据库表中添加字段';
            }
        } else {
            $errCode = 2550;
            $errMsg = '非法操作！';
        }

        return ['errCode' => $errCode, 'errMsg' => $errMsg];
    }

    // 查看数据表字段
    public function viewField($tableDetail)
    {
        list($dbConfig, $tableName) = explode('.', $tableDetail['tablename']);
        $fileds = \ar\core\comp('db.mysql')->read($dbConfig)->table($tableName)->getColumns();
        $fileds['tablename'] = $tableDetail['tablename'];
        return ['fileds' => $fileds];
    }

    // 生成模型文件
    public function changeModelFile($modelname, $tableLongName)
    {
        list($dbConfig, $tableName) = explode('.', $tableLongName);
        // 路径
        $system_model = COOP_SYSTEM."/server/lib/model/" . $dbConfig;

        if (!is_dir($system_model)) {
            mkdir($system_model, 0755, true);
        }

        list($db, $modleFileClassName) = explode('/', $modelname);
        // 创建文件
        $myfile = fopen($system_model."/".$modleFileClassName.".php", "w") or die("Unable to open file!");

        // 文件内容
        $txt = "<?php\n" .
            '/* this file is auto generated by coop cz system */'. "\n".
            "namespace server\lib\model\\" . $dbConfig . ";\n" .
            "class ". $modleFileClassName ." extends \ar\core\Model\n" .
            "{\n" .
            "    public "."$"."tableName = '" . $tableName . "';\n" .

            '    public function getDb($dbType = "mysql", $dbString = "' . $dbConfig . '", $read = true)
            {
                return parent::getDb($dbType, $dbString, $read);
            }
            '. "\n" .
            "}\n";

        // 写入文件内容
        fwrite($myfile, $txt);
        fclose($myfile);

    }

    // 查看模型列表  \ar\core\service('arcz.DBModel')->getModelList($uk, $count, $page, $search_col, $keyword, $sort_col, $sort_type);
    public function getModelList($uk, $count, $page, $search_col, $key, $sort_col, $sort_type)
    {
        // 登录用户详情
        $userDetail = \ar\core\service('arcz.User')->getLoginUser($uk);

        $condition = [];

        // 搜索
        $keyword = !empty($key) ? $key : '';
        if ($keyword) {
            $like = $search_col . ' like';
            $condition[$like] = '%'. $keyword . '%';
        }
        // 排序
        $sort_con = $sort_col . " " . $sort_type;

        $totalCount =  $this->arczdb->table(self::MODELLIST_TABLENAME)->where($condition)->count();
        $pageObj = new \server\lib\ext\Page($totalCount, $count, $page);

        $modelLists = $this->arczdb->table(self::MODELLIST_TABLENAME)
            ->where($condition)
            ->limit($pageObj->limit())
            ->order($sort_con)
            ->queryAll();

        $arr = get_object_vars($pageObj);
        $totalPages = $arr['totalPages'];
        if ($page > $totalPages) {
            $modelLists = [];
        }

        return [
            'modelLists' => $modelLists,
            'totalCount' => $totalCount,
            'totalPages' => $totalPages
        ];

    }

    // 模型详情  \ar\core\service('arcz.DBModel')->modellistRow($id);
    public function modellistRow($id)
    {
        $condition = ['id' => $id];

        $modelData = $this->arczdb->table(self::MODELLIST_TABLENAME)->where($condition)->queryRow();

        return $modelData;
    }

    // 根据tname查看模型详情  \ar\core\service('arcz.DBModel')->modellistRowByTname($tname);
    public function modellistRowByTname($tname)
    {
        $condition = ['tablename' => $tname];

        $modelData = $this->arczdb->table(self::MODELLIST_TABLENAME)->where($condition)->queryRow();

        return $modelData;
    }

    // 模型字段详情  \ar\core\service('arcz.DBModel')->colRow($id);
    public function colRow($id)
    {
        $condition = ['id' => $id];

        $modelData = $this->arczdb->table(self::MODEL_DETAIL_TABLENAME)->where($condition)->queryRow();

        return $modelData;
    }

    // 数据表模型字段  \ar\core\service('arcz.DBModel')->tableCols($tname);
    public function tableCols($tname)
    {
        $condition = ['tablename' => $tname];

        $tableCols = $this->arczdb->table(self::MODEL_DETAIL_TABLENAME)
            ->where($condition)
            ->order('ordernum')
            ->queryAll();

        foreach($tableCols as &$tc){
            // 字段说明编辑按钮
            if($tc['explain']==''){
                $tc['explainbtn'] = '<button type="button" id="explain_'.$tc['id'].'" class="btn btn-white btn-primary btn-xs" data-toggle="modal" data-target="#explainbtn">编辑说明</button>';
            } else {
                $tc['explainbtn'] = '<button type="button" id="explain_'.$tc['id'].'" class="btn btn-white btn-warning btn-xs" data-toggle="modal" data-target="#explainbtn">'.$tc['explain'].'</button>';
            }
            // 字段类型说明编辑按钮
            if($tc['type']==1){
                if($tc['typeexplain']==''){
                    $tc['typeexplainbtn'] = '<button type="button" id="typeexplain_'.$tc['id'].'" class="btn btn-white btn-primary btn-xs" data-toggle="modal" data-target="#typeexplainbtn">编辑说明</button>';
                } else {
                    $tc['typeexplain'] = "查看设置";
                    $tc['typeexplainbtn'] = '<button type="button" id="typeexplain_'.$tc['id'].'" class="btn btn-white btn-primary btn-xs" data-toggle="modal" data-target="#typeexplainbtn">'.$tc['typeexplain'].'</button>';
                }
            } else if($tc['type']==5){
                if($tc['typeexplain']==''){
                    $tc['typeexplainbtn'] = '<button type="button" id="typeexplain_'.$tc['id'].'" class="btn btn-white btn-primary btn-xs" data-toggle="modal" data-target="#typeexplainbtn">编辑说明</button>';
                } else {
                    $tc['typeexplainbtn'] = '<button type="button" id="typeexplain_'.$tc['id'].'" class="btn btn-white btn-primary btn-xs" data-toggle="modal" data-target="#typeexplainbtn">'.$tc['typeexplain'].'</button>';
                }
            } else if($tc['type']==8){
                $tc['typeexplainbtn'] = '<button type="button" id="addFk_'.$tc['id'].'" class="btn btn-white btn-primary btn-xs" data-toggle="modal" data-target="#addFk">生成外键模型</button>';
                $mtname = $tc['tablename'];
                $mcname = $tc['colname'];
                $con = ['mtablename' => $mtname, 'mcolname' => $mcname];
                $hasFk = $this->arczdb->table(self::MODEL_FK_TABLENAME)->where($con)->queryRow();
                if($hasFk){
                    $tc['typeexplainbtn'] = '<button type="button" id="queryFk_'.$tc['id'].'" class="btn btn-white btn-info btn-xs" data-toggle="modal" data-target="#queryFkbtn">查看外键</button>
                                             <button type="button" id="editFk_'.$tc['id'].'" class="btn btn-white btn-warning btn-xs" data-toggle="modal" data-target="#editFkbtn">编辑外键</button>';
                }

            } else {
                $tc['typeexplainbtn'] = '';
            }
            // 排序按钮
            $tc['ordernumbtn'] = '<button type="button" id="ordernum_'.$tc['id'].'" class="btn btn-white btn-primary btn-xs" data-toggle="modal" data-target="#ordernumbtn">'.$tc['ordernum'].'</button>';
            // 字段类型编辑按钮
            if($tc['type']==0){
                $tc['typebtn'] = '<button type="button" id="type_'.$tc['id'].'" class="btn btn-white btn-primary btn-xs" data-toggle="modal" data-target="#typebtn">字符串</button>';
            } else if($tc['type']==1){
                $tc['typebtn'] = '<button type="button" id="type_'.$tc['id'].'" class="btn btn-white btn-primary btn-xs" data-toggle="modal" data-target="#typebtn">多个状态值</button>';
            } else if($tc['type']==2){
                $tc['typebtn'] = '<button type="button" id="type_'.$tc['id'].'" class="btn btn-white btn-primary btn-xs" data-toggle="modal" data-target="#typebtn">开关状态值（×/√）</button>';
            } else if($tc['type']==3){
                $tc['typebtn'] = '<button type="button" id="type_'.$tc['id'].'" class="btn btn-white btn-primary btn-xs" data-toggle="modal" data-target="#typebtn">文章（富文本编辑器内容）</button>';
            } else if($tc['type']==4){
                $tc['typebtn'] = '<button type="button" id="type_'.$tc['id'].'" class="btn btn-white btn-primary btn-xs" data-toggle="modal" data-target="#typebtn">图片</button>';
            } else if($tc['type']==5){
                $tc['typebtn'] = '<button type="button" id="type_'.$tc['id'].'" class="btn btn-white btn-primary btn-xs" data-toggle="modal" data-target="#typebtn">时间戳</button>';
            } else if($tc['type']==6){
                $tc['typebtn'] = '<button type="button" id="type_'.$tc['id'].'" class="btn btn-white btn-primary btn-xs" data-toggle="modal" data-target="#typebtn">整数</button>';
            } else if($tc['type']==7){
                $tc['typebtn'] = '<button type="button" id="type_'.$tc['id'].'" class="btn btn-white btn-primary btn-xs" data-toggle="modal" data-target="#typebtn">浮点数</button>';
            } else if($tc['type']==8){
                $tc['typebtn'] = '<button type="button" id="type_'.$tc['id'].'" class="btn btn-white btn-primary btn-xs" data-toggle="modal" data-target="#typebtn">外键</button>';
            } else if($tc['type']==9){
                $tc['typebtn'] = '<button type="button" id="type_'.$tc['id'].'" class="btn btn-white btn-primary btn-xs" data-toggle="modal" data-target="#typebtn">视频</button>';
            }
            $check1 = '';
            // 判断是否显示
            $isshow = $tc['isshow'];
            if($isshow==1){
                $check1 = 'checked';
            }
            $tc['isshowswitch'] = '<input type="checkbox" class="ace ace-switch ace-switch-6 switch_check" value="'.$tc['id'].'" name="isshow" '.$check1.'><span class="lbl middle"></span>';
            $check2 = '';
            // 判断是否唯一键
            $isunique = $tc['isunique'];
            if($isunique==1){
                $check2 = 'checked';
            }
            $tc['isuniqueswitch'] = '<input type="checkbox" class="ace ace-switch ace-switch-6 switch_check" value="'.$tc['id'].'" name="isunique" '.$check2.'><span class="lbl middle"></span>';
            $check3 = '';
            // 判断是否可编辑
            $isedit = $tc['isedit'];
            if($isedit==1){
                $check3 = 'checked';
            }
            $tc['iseditswitch'] = '<input type="checkbox" class="ace ace-switch ace-switch-6 switch_check" value="'.$tc['id'].'" name="isedit" '.$check3.'><span class="lbl middle"></span>';
            $check4 = '';
            // 判断是否在详情页显示
            $isview = $tc['isview'];
            if($isview==1){
                $check4 = 'checked';
            }
            $tc['isviewswitch'] = '<input type="checkbox" class="ace ace-switch ace-switch-6 switch_check" value="'.$tc['id'].'" name="isview" '.$check4.'><span class="lbl middle"></span>';
            $check5 = '';
            // 判断字段是否支持排序
            $issort = $tc['issort'];
            if($issort==1){
                $check5 = 'checked';
            }
            $tc['issortswitch'] = '<input type="checkbox" class="ace ace-switch ace-switch-6 switch_check" value="'.$tc['id'].'" name="issort" '.$check5.'><span class="lbl middle"></span>';
            $check6 = '';
            // 判断字段是否为必填项
            $isrequire = $tc['isrequire'];
            if($isrequire==1){
                $check6 = 'checked';
            }
            $tc['isrequireswitch'] = '<input type="checkbox" class="ace ace-switch ace-switch-6 switch_check" value="'.$tc['id'].'" name="isrequire" '.$check6.'><span class="lbl middle"></span>';
        }

        return [
            'tableCols' => $tableCols,
        ];
    }

    // 设置模型字段属性开关  \ar\core\service('arcz.DBModel')->modelSetSwitch($id, $value, $name, $uk, $loginip);
    public function modelSetSwitch($id, $value, $name, $uk, $loginip)
    {
        // 当前登录用户详情
        $userDetail = \ar\core\service('arcz.User')->getLoginUser($uk);

        $errCode = 1000;
        $errMsg = '';

        $uid = $userDetail['id'];
        // 判断当前管理员是否为开发者
        $isDev = $userDetail['isDev'];
        if($isDev==1){
            $isunique = 0;
            // 字段详情
            $colDetail = $this->arczdb->table(self::MODEL_DETAIL_TABLENAME)->where(['id' => $id])->queryRow();
            if($colDetail['isunique']==1||$colDetail['colname']=='id'){
                if($value==0&&$name=='isshow'){
                    $isunique = 1;
                } else {
                    $isunique = 0;
                }
            }
            if($isunique==0){
                // 日志记录参数
                $title = '设置模型字段';
                $content = '管理员 ' . $userDetail['username'] . ' 设置模型 ' . $colDetail['tablename'] . ' 字段 ' . $colDetail['colname'];
                $tname = $colDetail['tablename'];
                if($name=='isunique' && $value==1){
                    $colUnique = $this->arczdb->table(self::MODEL_DETAIL_TABLENAME)->where(['tablename' => $tname, 'isunique' => 1])->count();
                    if($colUnique>0){
                        $errCode = 6003;
                        $errMsg = '只允许一个字段设置唯一键';
                    } else {
                        $setResult = \ar\core\service('arcz.DBModel')->setSwitchNow($id, $value, $name);
                        if ($setResult) {
                            // 日志记录
                            \ar\core\service('arcz.Specialized')->addAdminLog($uid, $title, $content, $loginip);
                            $errMsg = '操作成功';
                        } else {
                            $errCode = 6004;
                            $errMsg = '操作失败';
                        }
                    }
                } else {
                    $setResult = \ar\core\service('arcz.DBModel')->setSwitchNow($id, $value, $name);
                    if ($setResult) {
                        // 日志记录
                        \ar\core\service('arcz.Specialized')->addAdminLog($uid, $title, $content, $loginip);
                        $errMsg = '操作成功';
                    } else {
                        $errCode = 6004;
                        $errMsg = '操作失败';
                    }
                }
            } else if($isunique==1){
                $errCode = 6005;
                $errMsg = '唯一键必需在列表显示';
            }
        } else {
            $errCode = 2550;
            $errMsg = '非法操作！';
        }

        return ['errCode' => $errCode, 'errMsg' => $errMsg];

    }

    // 设置模型字段属性开关操作  \ar\core\service('arcz.DBModel')->setSwitchNow($id, $value, $name);
    public function setSwitchNow($id, $value, $name)
    {
        $data = [$name => $value];
        return $this->arczdb->table(self::MODEL_DETAIL_TABLENAME)->where(['id' => $id])->update($data);
    }

    // 设置模型字段属性值  \ar\core\service('arcz.DBModel')->setColValNow($id, $value, $name, $uk, $loginip);
    public function setColValNow($id, $value, $name, $uk, $loginip)
    {
        // 当前登录用户详情
        $userDetail = \ar\core\service('arcz.User')->getLoginUser($uk);

        $errCode = 1000;
        $errMsg = '';

        $uid = $userDetail['id'];
        // 判断当前管理员是否为开发者
        $isDev = $userDetail['isDev'];
        if($isDev==1){
            // 字段详情
            $colDetail = $this->arczdb->table(self::MODEL_DETAIL_TABLENAME)->where(['id' => $id])->queryRow();

            // 日志记录参数
            $title = '设置模型字段';
            $content = '管理员 ' . $userDetail['username'] . ' 设置模型 ' . $colDetail['tablename'] . ' 字段 ' . $colDetail['colname'];

            $data = [$name => $value];
            // 是否将类型设为时间戳
            if($name=='type' && $value==5){
                $data = ['type' => 5, 'typeexplain' => 'Y-m-d H:i:s'];
            }
            // 是否将类型设为文章
            $hasType3 = false;
            if($name=='type' && $value==3){
                $row = $this->arczdb->table(self::MODEL_DETAIL_TABLENAME)->where(['tablename' => $colDetail['tablename'], 'type' => 3])->queryRow();
                if($row){
                    $hasType3 = true;
                }
            }
            if($hasType3){
                $errCode = 1003;
                $errMsg = '只允许一个字段为富文本编辑器内容';
            } else {
                $setCol = $this->arczdb->table(self::MODEL_DETAIL_TABLENAME)->where(['id' => $id])->update($data, 1);
                if($setCol){
                    // 是否外键
                    if($colDetail['type']==8){
                        // 是否存在主表外键模型
                        $mtname = $colDetail['tablename'];
                        $mcname = $colDetail['colname'];
                        $conm = ['mtablename' => $mtname, 'mcolname' => $mcname];
                        $hasFkm = $this->arczdb->table(self::MODEL_FK_TABLENAME)->where($conm)->queryRow();
                        if($hasFkm){
                            $this->arczdb->table(self::MODEL_FK_TABLENAME)->where($conm)->update(['mexplain' => $value]);
                        }
                    } else {
                        // 是否存在关联表外键模型
                        $ftname = $colDetail['tablename'];
                        $fcname = $colDetail['colname'];
                        $conf = ['ftablename' => $ftname, 'fcolname' => $fcname];
                        $hasFkf = $this->arczdb->table(self::MODEL_FK_TABLENAME)->where($conf)->queryRow();
                        if($hasFkf){
                            $this->arczdb->table(self::MODEL_FK_TABLENAME)->where($conf)->update(['fexplain' => $value]);
                        }
                    }
                    // 日志记录
                    \ar\core\service('arcz.Specialized')->addAdminLog($uid, $title, $content, $loginip);
                    $errMsg = '操作成功';
                } else {
                    $errCode = 1001;
                    $errMsg = '未更改任何参数';
                }
            }
        } else {
            $errCode = 2550;
            $errMsg = '非法操作！';
        }

        return ['errCode' => $errCode, 'errMsg' => $errMsg];

    }

    // 删除模型  \ar\core\service('arcz.DBModel')->delModel($id, $uk, $loginip);
    public function delModel($id, $uk, $loginip)
    {
        // 当前登录用户详情
        $userDetail = \ar\core\service('arcz.User')->getLoginUser($uk);

        $errCode = 1000;
        $errMsg = '';

        $uid = $userDetail['id'];
        // 判断当前管理员是否为开发者
        $isDev = $userDetail['isDev'];
        if($isDev==1){
            // 模型详情
            $data = $this->arczdb->table(self::MODELLIST_TABLENAME)->where(['id' => $id])->queryRow();
            // 菜单
            $nav = $this->arczdb->table(self::NAV_TABLENAME)->where(['mid' => $id])->queryRow();
            if($nav){
                $errCode = 1002;
                $errMsg = '删除失败，请先删除相关菜单';
            } else {
                // 删除模型字段
                $this->arczdb->table(self::MODEL_DETAIL_TABLENAME)->where(['tablename' => $data['tablename']])->delete();
                // 删除模型功能
                $this->arczdb->table(self::MODEL_MENUFUNC_TABLENAME)->where(['mid' => $id])->delete();
                // 删除模型外键
                $this->arczdb->table(self::MODEL_FK_TABLENAME)->where(['mid' => $id])->delete();
                // 删除模型功能权限
                $this->arczdb->table(self::GROUP_FUNC_TABLENAME)->where(['mid' => $id])->delete();
                // 删除模型
                $del = $this->arczdb->table(self::MODELLIST_TABLENAME)->where(['id' => $id])->delete();
                if($del){
                    // 日志记录参数
                    $title = '删除模型';
                    $content = '管理员 ' . $userDetail['username'] . ' 删除模型 ' . $data['modelname'];
                    // 日志记录
                    \ar\core\service('arcz.Specialized')->addAdminLog($uid, $title, $content, $loginip);
                    $errMsg = '删除成功';
                } else {
                    $errCode = 1001;
                    $errMsg = '删除失败';
                }
            }

        } else {
            $errCode = 2550;
            $errMsg = '非法操作！';
        }

        return ['errCode' => $errCode, 'errMsg' => $errMsg];
    }

    // 添加外键模型  \ar\core\service('arcz.DBModel')->addFkModel($id, $uk, $loginip);
    public function addFkModel($id, $uk, $loginip)
    {
        // 当前登录用户详情
        $userDetail = \ar\core\service('arcz.User')->getLoginUser($uk);

        $errCode = 1000;
        $errMsg = '';

        $uid = $userDetail['id'];
        // 判断当前管理员是否为开发者
        $isDev = $userDetail['isDev'];
        if($isDev==1){
            // 模型字段详情
            $colDetail = $this->arczdb->table(self::MODEL_DETAIL_TABLENAME)->where(['id' => $id])->queryRow();
            // 模型详情
            $modelDetail = $this->arczdb->table(self::MODELLIST_TABLENAME)->where(['tablename' => $colDetail['tablename']])->queryRow();
            // 插入数据
            $data = [
                'mid' => $modelDetail['id'],
                'mtablename' => $modelDetail['tablename'],
                'mmodelname' => $modelDetail['modelname'],
                'mcolname' => $colDetail['colname'],
                'mexplain' => $colDetail['explain']
            ];
            $add = $this->arczdb->table(self::MODEL_FK_TABLENAME)->insert($data);
            if($add){
                // 日志记录参数
                $title = '添加外键模型';
                $content = '管理员 ' . $userDetail['username'] . ' 添加外键模型 模型名 ' . $modelDetail['tablename'] . ' 字段名 ' . $colDetail['colname'];
                // 日志记录
                \ar\core\service('arcz.Specialized')->addAdminLog($uid, $title, $content, $loginip);
                $errMsg = '添加成功';
            } else {
                $errCode = 1001;
                $errMsg = '添加失败';
            }

        } else {
            $errCode = 2550;
            $errMsg = '非法操作！';
        }

        return ['errCode' => $errCode, 'errMsg' => $errMsg];
    }

    // 查看外键模型  \ar\core\service('arcz.DBModel')->getFkModel($id);
    public function getFkModel($id)
    {
        // 模型字段详情
        $colDetail = $this->arczdb->table(self::MODEL_DETAIL_TABLENAME)->where(['id' => $id])->queryRow();
        $con = [
            'mtablename' => $colDetail['tablename'],
            'mcolname'   => $colDetail['colname']
        ];
        $fk = $this->arczdb->table(self::MODEL_FK_TABLENAME)->where($con)->queryRow();
        return $fk;
    }

    // 查找所有模型  \ar\core\service('arcz.DBModel')->getAllModel();
    public function getAllModel()
    {
        $modelLists = $this->arczdb->table(self::MODELLIST_TABLENAME)->queryAll();
        return $modelLists;
    }

    // 获取外键模型字段  \ar\core\service('arcz.DBModel')->getCol($id);
    public function getCol($id)
    {
        // 模型详情
        $modelDetail = $this->arczdb->table(self::MODELLIST_TABLENAME)->where(['id' => $id])->queryRow();
        $tablename = $modelDetail['tablename'];
        $colLists = $this->arczdb->table(self::MODEL_DETAIL_TABLENAME)->where(['tablename' => $tablename])->queryAll();
        return ['modelDetail' => $modelDetail, 'colLists' => $colLists];
    }

    // 编辑关联外键  \ar\core\service('arcz.DBModel')->updateFkCol($fkid, $fmodelid, $funivalid, $fcolnameid, $uk, $loginip);
    public function updateFkCol($fkid, $fmodelid, $funivalid, $fcolnameid, $uk, $loginip)
    {
        // 当前登录用户详情
        $userDetail = \ar\core\service('arcz.User')->getLoginUser($uk);

        $errCode = 1000;
        $errMsg = '';

        $uid = $userDetail['id'];
        // 判断当前管理员是否为开发者
        $isDev = $userDetail['isDev'];
        if($isDev==1){
            // 外键模型详情
            $fkDetail = $this->arczdb->table(self::MODEL_FK_TABLENAME)->where(['id' => $fkid])->queryRow();
            // 关联模型详情
            $fmodelDetail = $this->arczdb->table(self::MODELLIST_TABLENAME)->where(['id' => $fmodelid])->queryRow();
            // 映射字段详情
            $funiDetail = $this->arczdb->table(self::MODEL_DETAIL_TABLENAME)->where(['id' => $funivalid])->queryRow();
            // 关联字段详情
            $fcolDetail = $this->arczdb->table(self::MODEL_DETAIL_TABLENAME)->where(['id' => $fcolnameid])->queryRow();

            // 主模型名
            $mmodelname = $fkDetail['mmodelname'];
            // 关联模型id
            $fid = $fmodelDetail['id'];
            // 关联数据表名
            $ftablename = $fmodelDetail['tablename'];
            // 关联模型名
            $fmodelname = $fmodelDetail['modelname'];
            // 关联映射字段
            $funival = $funiDetail['colname'];
            // 关联字段
            $fcolname = $fcolDetail['colname'];
            // 关联字段说明
            $fexplain = $fcolDetail['explain'];

            // 更新数据
            $data = [
                'fid' => $fid,
                'ftablename' => $ftablename,
                'fmodelname' => $fmodelname,
                'funival' => $funival,
                'fcolname' => $fcolname,
                'fexplain' => $fexplain,
                'updatetime' => time()
            ];
            $update = $this->arczdb->table(self::MODEL_FK_TABLENAME)->where(['id' => $fkid])->update($data);
            if($update){
                // 日志记录参数
                $title = '编辑外键模型关联模型字段';
                $content = '管理员' . $userDetail['username'] . ' 编辑外键模型 ' . $mmodelname . ' 关联模型 ' . $fmodelname . ' 关联映射字段 ' . $funival . ' 关联字段 ' . $fcolname . ' 关联字段说明 ' . $fexplain;
                // 日志记录
                \ar\core\service('arcz.Specialized')->addAdminLog($uid, $title, $content, $loginip);
                $errMsg = '编辑成功';
            } else {
                $errCode = 1001;
                $errMsg = '编辑失败';
            }

        } else {
            $errCode = 2550;
            $errMsg = '非法操作！';
        }

        return ['errCode' => $errCode, 'errMsg' => $errMsg];
    }

    // 查找模型定制功能  \ar\core\service('arcz.DBModel')->getFuncList($id);
    public function getFuncList($id)
    {
        $con = ['mid' => $id, 'type' => 0, 'type_multi' => 0];
        $funcList = $this->arczdb->table(self::MODEL_MENUFUNC_TABLENAME)
            ->where($con)
            ->queryAll();
        foreach($funcList as &$f){
            $check1 = '';
            // 判断是否开启
            $status = $f['status'];
            if($status==1){
                $check1 = 'checked';
            }
            $f['switchstatus'] = '<input type="checkbox" class="ace ace-switch ace-switch-6 switch_check" value="'.$f['id'].'" name="status" '.$check1.'><span class="lbl middle"></span>';
            $check2 = '';
            // 判断打开方式(×新页面 √弹窗)
            $type_window = $f['type_window'];
            if($type_window==1){
                $check2 = 'checked';
            }
            $f['switchtype_window'] = '<input type="checkbox" class="ace ace-switch ace-switch-6 switch_check" value="'.$f['id'].'" name="type_window" '.$check2.'><span class="lbl middle"></span>';
            $check3 = '';
            // 判断按钮位置(×列表 √顶端)
            $type_button = $f['type_button'];
            if($type_button==1){
                $check3 = 'checked';
            }
            $f['switchtype_button'] = '<input type="checkbox" class="ace ace-switch ace-switch-6 switch_check" value="'.$f['id'].'" name="type_button" '.$check3.'><span class="lbl middle"></span>';
        }
        return $funcList;
    }

    // 添加自定义功能  \ar\core\service('arcz.DBModel')->addFunc($mid, $menuid, $title, $name, $apiaddr, $uk, $loginip);
    public function addFunc($mid, $menuid, $title, $name, $apiaddr, $uk, $loginip)
    {
        // 当前登录用户详情
        $userDetail = \ar\core\service('arcz.User')->getLoginUser($uk);

        $errCode = 1000;
        $errMsg = '';

        $uid = $userDetail['id'];
        // 判断当前管理员是否为开发者
        $isDev = $userDetail['isDev'];
        if($isDev==1){
            // 自定义功能是否存在重复接口地址
            $has = $this->arczdb->table(self::MODEL_MENUFUNC_TABLENAME)->where(['apiaddr' => $apiaddr, 'type' => 0])->queryRow();
            if(!$has){
                if(preg_match('/_/',$apiaddr)){
                    $errCode = 6003;
                    $errMsg = '接口地址名称不能有下划线';
                } else {
                    // 添加数据
                    $data = [
                        'mid' => $mid,
                        'menuid' => $menuid,
                        'title' => $title,
                        'name' => $name,
                        'type' => 0,
                        'apiaddr' => $apiaddr,
                        'status' => 1,
                        'updatetime' => time(),
                        'type_window' => 0,
                        'type_button' => 0
                    ];
                    $insert = $this->arczdb->table(self::MODEL_MENUFUNC_TABLENAME)->insert($data, 1);
                    if($insert){
                        $groupfunc_data = [
                            'gid' => 1,
                            'mid' => $data['mid'],
                            'fid' => $insert
                        ];
                        $this->arczdb->table(self::GROUP_FUNC_TABLENAME)->insert($groupfunc_data);
                        // 日志记录
                        $title = '添加自定义功能';
                        $content = '添加自定义功能 ' . $data['title'];
                        \ar\core\service('arcz.Specialized')->addAdminLog($uid, $title, $content, $loginip);
                        $errMsg = '添加成功';
                    } else {
                        $errCode = 1001;
                        $errMsg = '添加功能失败';
                    }
                }
            } else {
                $errCode = 6002;
                $errMsg = '接口地址名称“'.$apiaddr.'”已存在，添加功能失败';
            }

        } else {
            $errCode = 2550;
            $errMsg = '非法操作！';
        }

        return ['errCode' => $errCode, 'errMsg' => $errMsg];
    }

    // 设置功能字段属性开关  \ar\core\service('arcz.DBModel')->funcSetSwitch($id, $value, $name, $uk, $loginip);
    public function funcSetSwitch($id, $value, $name, $uk, $loginip)
    {
        // 当前登录用户详情
        $userDetail = \ar\core\service('arcz.User')->getLoginUser($uk);

        $errCode = 1000;
        $errMsg = '';

        $uid = $userDetail['id'];
        // 判断当前管理员是否为开发者
        $isDev = $userDetail['isDev'];
        if($isDev==1){
            // 功能详情
            $funcDetail = $this->arczdb->table(self::MODEL_MENUFUNC_TABLENAME)->where(['id' => $id])->queryRow();
            // 日志记录参数
            $title = '设置模型功能';
            $content = '管理员 ' . $userDetail['username'] . ' 设置模型id ' . $funcDetail['mid'] . ' 功能 ' . $funcDetail['title'];

            $setResult = \ar\core\service('arcz.DBModel')->setSwitchFunc($id, $value, $name);
            if ($setResult) {
                // 日志记录
                \ar\core\service('arcz.Specialized')->addAdminLog($uid, $title, $content, $loginip);
                $errMsg = '操作成功';
            } else {
                $errCode = 6004;
                $errMsg = '操作失败';
            }
        } else {
            $errCode = 2550;
            $errMsg = '非法操作！';
        }

        return ['errCode' => $errCode, 'errMsg' => $errMsg];

    }

    // 设置功能字段属性开关操作  \ar\core\service('arcz.DBModel')->setSwitchFunc($id, $value, $name);
    public function setSwitchFunc($id, $value, $name)
    {
        $data = [$name => $value];
        return $this->arczdb->table(self::MODEL_MENUFUNC_TABLENAME)->where(['id' => $id])->update($data);
    }

    // 查询单个自定义功能  \ar\core\service('arcz.DBModel')->getFuncRow($id);
    public function getFuncRow($id)
    {
        return $this->arczdb->table(self::MODEL_MENUFUNC_TABLENAME)->where(['id' => $id])->queryRow();
    }

    // 编辑自定义功能  \ar\core\service('arcz.DBModel')->editFunc($id, $title, $apiaddr, $uk, $loginip);
    public function editFunc($id, $title, $apiaddr, $uk, $loginip)
    {
        // 当前登录用户详情
        $userDetail = \ar\core\service('arcz.User')->getLoginUser($uk);

        $errCode = 1000;
        $errMsg = '';

        $uid = $userDetail['id'];
        // 判断当前管理员是否为开发者
        $isDev = $userDetail['isDev'];
        if($isDev==1){
            // 编辑数据
            $data = [
                'title' => $title,
                'apiaddr' => $apiaddr,
                'updatetime' => time()
            ];
            $update = $this->arczdb->table(self::MODEL_MENUFUNC_TABLENAME)->where(['id' => $id])->update($data);
            if($update){
                // 日志记录
                $title = '编辑自定义功能';
                $content = '编辑自定义功能 ' . $data['title'];
                \ar\core\service('arcz.Specialized')->addAdminLog($uid, $title, $content, $loginip);
                $errMsg = '编辑成功';
            } else {
                $errCode = 1001;
                $errMsg = '编辑功能失败';
            }

        } else {
            $errCode = 2550;
            $errMsg = '非法操作！';
        }

        return ['errCode' => $errCode, 'errMsg' => $errMsg];
    }

    // 删除自定义功能  \ar\core\service('arcz.DBModel')->delFunc($id, $uk, $loginip);
    public function delFunc($id, $uk, $loginip)
    {
        // 当前登录用户详情
        $userDetail = \ar\core\service('arcz.User')->getLoginUser($uk);

        $errCode = 1000;
        $errMsg = '';

        $uid = $userDetail['id'];
        // 判断当前管理员是否为开发者
        $isDev = $userDetail['isDev'];
        if($isDev==1){
            // 功能详情
            $funcDetail = $this->arczdb->table(self::MODEL_MENUFUNC_TABLENAME)->where(['id' => $id])->queryRow();
            if($funcDetail){
                $del = $this->arczdb->table(self::MODEL_MENUFUNC_TABLENAME)->where(['id' => $id])->delete();
                if($del){
                    $this->arczdb->table(self::GROUP_FUNC_TABLENAME)->where(['fid' => $id])->delete();
                    // 日志记录
                    $title = '删除模型功能';
                    $content = '管理员 ' . $userDetail['username'] . ' 删除功能 ' . $funcDetail['title'];
                    \ar\core\service('arcz.Specialized')->addAdminLog($uid, $title, $content, $loginip);
                    $errMsg = '删除成功';
                } else {
                    $errCode = 1001;
                    $errMsg = '删除功能失败';
                }
            } else {
                $errCode = 1002;
                $errMsg = '删除失败，未找到功能';
            }

        } else {
            $errCode = 2550;
            $errMsg = '非法操作！';
        }

        return ['errCode' => $errCode, 'errMsg' => $errMsg];
    }


}

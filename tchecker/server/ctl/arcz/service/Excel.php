<?php
/**
 * Powerd by ArPHP.
 *
 * Index service.
 *
 */
namespace server\ctl\arcz\service;

class Excel extends Base
{

    public function visit_host()
    {
        // 当前访问方式是http://或者https://
        $http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';

        // 当前域名，如本地是localhost或127.0.0.1，线上是 www.xzgk.net
        $visit_host = $_SERVER['HTTP_HOST'];    // 127.0.0.1
        $full_visit_host = $http_type . $visit_host;   // http://127.0.0.1
        return ['http_type' => $http_type, 'visit_host' => $visit_host, 'full_visit_host' => $full_visit_host];
    }

    // 导出成 Excel 格式  \ar\core\service('arcz.Excel')->downAsExcel($mid);
    public function downAsExcel($mid)
    {
        $modelInfo = \ar\core\service('arcz.Data')->getModel($mid);

        $modelInfo['modelname'] = str_replace("/","\\",$modelInfo['modelname']);

        $modelName = '\server\lib\model\\'.$modelInfo['modelname'];

        $tableName = $modelInfo['tablename'];

        if(!empty($modelInfo['explain']))
        {
            $fileName = $modelInfo['explain'];
        } else {
            $fileName = $modelInfo['tablename'];
        }

        // 获取显示的字段名，用作 Excel 表的列名
        $columnIsshows = \ar\core\service('arcz.Data')->getModelColumnsIsShow($mid);


        foreach ($columnIsshows as &$column) {
            $showColumn[] = $column['colname'];  // 字段名
            // 导出的 Excel 的列名
            $downTitle[] = $column['explain'] ? $column['explain'] : $column['colname'];
        }

        $downInfos = $modelName::model()->getDb()->select($showColumn)->queryAll();

        foreach ($downInfos as $downInfos_key => &$downInfo) {
            foreach ($downInfo as $downInfo_key => &$downInfo_value) {
                // 在 modeldetail 表中查询当前字段类型
                $columnType = $this->arczdb->table(self::MODEL_DETAIL_TABLENAME)
                    ->where(['tablename' => $tableName, 'colname' => $downInfo_key])
                    ->queryRow();
                switch ($columnType['type']) {
                    case '0':   // 当前字段类型为0，是字符串
                        # code...
                        break;
                    case '1':   // 当前字段类型为1，是多个状态值
                        $typeexplain = explode('|', $columnType['typeexplain']);
                        foreach ($typeexplain as $typeexplain_key => $typeexplain_value) {
                            $tmp = explode(':', $typeexplain_value);
                            for ($i=0; $i < count($tmp); $i++) {
                                $tmp2[$tmp[0]] = $tmp[1];
                            }
                        }
                        foreach ($tmp2 as $tmp2_key => $tmp2_value) {
                            if ($downInfo_value == $tmp2_key) {
                                $downInfo_value = $tmp2_value;
                            }
                        }
                        break;
                    case '2':   // 当前字段类型为2，是两个状态值
                        if($downInfo_value==0){
                            $downInfo_value = '否';
                        } else if($downInfo_value==1){
                            $downInfo_value = '是';
                        }
                        break;
                    case '3':
                        $downInfo_value = '不支持显示富文本编辑器内容';
                        break;
                    case '4':
                        $downInfo_value = '图片地址：' . $downInfo_value;
                        break;
                    case '5':   // 当前字段类型为，是时间戳
                        $dateTypeExplain = $columnType['typeexplain'];
                        $downInfo_value = date($dateTypeExplain, $downInfo_value);
                        break;
                    case '6':
                        break;
                    case '7':
                        break;
                    case '8':   // 当前字段类型为8，是外键
                        // 查询外键关联的数据信息
                        $linkTable = $this->arczdb->table(self::MODEL_FK_TABLENAME)
                            ->where(['mid' => $mid, 'mcolname' => $downInfo_key])
                            ->queryRow();
                        // 关联模型名
                        $strFmodelname = $linkTable['fmodelname'];
                        // 截取'/'前面的内容
                        $sForder = substr($strFmodelname,0,strpos($strFmodelname, '/'));
                        // 截取'/'后面的内容
                        $sModelname = substr($strFmodelname,strpos($strFmodelname, '/')+1);
                        $linkTableModelName = '\server\lib\model\\' . $sForder . '\\' . $sModelname;

                        $linkTableInfos = $linkTableModelName::model()->getDb()
                            ->where([$linkTable['funival'] => $downInfo_value])
                            ->queryRow();
                        // 将原值替换成外键对应边里的字段值
                        $downInfo_value = $linkTableInfos[$linkTable['fcolname']];
                        break;
                    default:
                        # code...
                        break;
                }
            }

        }

        return [
            'title' => $downTitle,
            'data' => $downInfos,
            'fileName' => $fileName,
            'savePath' => './',
            'isDown' => true
        ];

    }

}

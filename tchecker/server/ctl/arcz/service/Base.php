<?php

namespace server\ctl\arcz\service;
require_once(AR_ROOT_PATH.'/server/lib/ext/PHPMailer/PHPMailerAutoload.php');

/**
 * Default Controller of webapp.
 */
class Base
{
    public $arczdb;
    
    // 开发者表
    const DEVELOPER_TABLENAME = 'cz_admin_developer';
    // 管理员组表
    const GROUP_TABLENAME = 'cz_admin_group';
    // 管理员组-功能权限中间表
    const GROUP_FUNC_TABLENAME = 'cz_admin_group_func';
    // 后台管理员分组-后台菜单中间表
    const GROUP_NAV_TABLENAME = 'cz_admin_group_nav';
    // 管理员操作日志表
    const LOG_TABLENAME = 'cz_admin_log';
    // 模型详情表
    const MODEL_DETAIL_TABLENAME = 'cz_admin_model_detail';
    // 模型外键关联表
    const MODEL_FK_TABLENAME = 'cz_admin_model_fk';
    // 模型菜单功能表
    const MODEL_MENUFUNC_TABLENAME = 'cz_admin_model_menufunc';
    // 模型表
    const MODELLIST_TABLENAME = 'cz_admin_modellist';
    // 后台菜单表
    const NAV_TABLENAME = 'cz_admin_nav';
    // 后台菜单配置表
    const SYSTEM_SETTING_TABLENAME = 'cz_admin_system_setting';
    // 管理员表
    const USER_TABLENAME = 'cz_admin_user';
    // 后台管理员-管理员分组中间表
    const USER_GROUP_TABLENAME = 'cz_admin_user_group';

    // 连接Db
    public function init()
    {
        ini_set('date.timezone','Asia/Shanghai'); // 'Asia/Shanghai' 为上海时区

        // 初始化连接
        $this->arczdb = \ar\core\comp('db.mysql')->read('default');
    }

    // 获取表创建说明
    public function getTableInfo(&$db, $tables = [])
    {
        $tablesInfo = '';
        foreach ($tables as $table) {
            $tableObj = $db->sqlQuery('show create table ' . $table);
            $tableObj = $tableObj[0];
            $tablesInfo .= "\n\n" . $tableObj['Create Table'];
        }
       
        if (!$tablesInfo) {
            $tablesInfo = '该服务尚未注册数据表';
        }
        return $tablesInfo;
    }

    // 加密方式
    public function pwd($str = 'hello,arphp')
    {
        return md5(substr(md5(md5($str) . 'arcz'), 6, 6));
    }


    /**
     * 查询当前访问路径
    <pre>
        使用方法：
        $res = \ar\core\service('applets.Base')->visit_host();
    </pre>
     *
     * @param string    $http_type          http://或https://
     * @param string    $visit_host         当前域名，如 127.0.0.1
     * @param string    $full_visit_host    完整路径，如：http://127.0.0.1
     *
     * @author yaoxf <810922381@qq.com>
     *
     * @apiname 查询当前访问路径
     *
     * @return array
     */
    public function visit_host()
    {
        // 当前访问方式是http://或者https://
        $http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';

        // 当前域名，如本地是localhost或127.0.0.1，线上是 www.xzgk.net
        $visit_host = $_SERVER['HTTP_HOST'];    // 127.0.0.1
        $full_visit_host = $http_type . $visit_host;   // http://127.0.0.1
        return ['http_type' => $http_type, 'visit_host' => $visit_host, 'full_visit_host' => $full_visit_host];
    }

    
     /**
     * 将变量设置为指定长度
    <pre>
        使用方法：
        $res = \ar\core\service('applets.Base')->setLen($param, $len);
    </pre>
     *
     * @param string    $param  参数
     * @param int       $len    长度
     *
     * @author yaoxf <810922381@qq.com>
     *
     * @apiname 将变量设置为指定长度
     *
     * @return array
     */
    public function setLen($param, $len)
    {
        $param = (string)$param;
        if (strlen($param) >= $len) {
            return substr($param, 0, $len);
        }else{
            $temp = '';
            for ($i=0; $i < $len - strlen($param); $i++) { 
                $temp .= '0';
            }
            return $temp.$param;
        } 
    }

    // 时间戳转换
    public function getDateDiff($stamptime)
    {
        $current_time = time();
        $diff = $current_time - $stamptime;

        $agoAt = '刚刚';
        $timePoints = [
            ['value' => intval(60 * 60 * 24 * 365), 'suffix' => '年前', 'max' => intval(2)],
            ['value' => intval(60 * 60 * 24 * 30), 'suffix' => '月前', 'max' => intval(11)],
            ['value' => intval(60 * 60 * 24 * 7), 'suffix' => '周前', 'max' => intval(4)],
            ['value' => intval(60 * 60 * 24), 'suffix' => '天前', 'max' => intval(6)],
            ['value' => intval(60 * 60), 'suffix' => '小时前', 'max' => intval(23)],
            ['value' => intval(60 * 10), 'suffix' => '0分钟前', 'max' => intval(5)]
        ];

        for ($i = 0; $i < count($timePoints); $i++) {
            $point = $timePoints[$i];
            $mode = floor(intval($diff) / intval($point['value']));
            if ($mode > 1) {
                $agoAt = min(intval($mode), intval($point['max'])) . $point['suffix'];
                break;
            }
        }
        return $agoAt;
    }




}
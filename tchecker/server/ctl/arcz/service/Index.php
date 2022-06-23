<?php
/**
 * Powerd by ArPHP.
 *
 * Index service.
 *
 */
namespace server\ctl\arcz\service;

class Index extends Base
{
    // 读取系统基本信息  \ar\core\service('arcz.Index')->systemSetting();
    public function systemSetting()
    {
        $systemInfo = $this->arczdb->table(self::SYSTEM_SETTING_TABLENAME)->queryRow();

        // 网站首页
        $systemInfo['homepage'] = $_SERVER['HTTP_HOST'];
        // 服务器ip
        $systemInfo['addr'] = $_SERVER['SERVER_ADDR'];
        // 服务器环境
        $systemInfo['server'] = php_uname();
        // 服务器端口
        $systemInfo['port'] = $_SERVER['SERVER_PORT'];
        // php版本
        $systemInfo['phpv'] = PHP_VERSION;
        // 数据库版本
        // $systemInfo['database'] = mysql_get_server_info();
        // 最大上传限制
        $systemInfo['maxupload'] = get_cfg_var ("upload_max_filesize") ? get_cfg_var ("upload_max_filesize") : "不允许";
        return $systemInfo; 
    }

    // 更改系统参数  \ar\core\service('arcz.Index')->systemSettingEdit($data, $uk, $ip);
    public function systemSettingEdit($data, $uk, $ip)
    {
        // 当前登录用户详情
        $userDetail = \ar\core\service('arcz.User')->getLoginUser($uk);
        $nowid = $userDetail['id'];

        $errCode = 1000;
        $errMsg = '';

        $updateData = [];

        foreach($data as &$d){
            $key = $d['key'];
            $value = $d['value'];
            $updateData[$key] = $value;
        }

        $update = $this->arczdb->table(self::SYSTEM_SETTING_TABLENAME)->update($updateData);

        if($update){
            // 日志记录
            $title = '设置系统参数';
            $content = '管理员 ' . $userDetail['username'] .' 设置系统参数成功 ';
            \ar\core\service('arcz.Specialized')->addAdminLog($nowid, $title, $content, $ip);
            $errMsg = '编辑成功';
        } else {
            $errCode = 1001;
            $errMsg = '编辑失败';
        }

        return ['errCode' => $errCode, 'errMsg' => $errMsg];
    }


}

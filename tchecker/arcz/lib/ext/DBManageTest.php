<?php
/**
 * Powerd by ArPHP.
 *
 */
namespace arcz\lib\ext;

/**
 * 数据库DBManage服务测试组件
 */
class DBManageTest
{

    public function test(){
        include 'DBManage.php';
        // ------1. 数据库备份（导出）------------------------------------------------------------
        // 分别是主机，用户名，密码，数据库名，数据库编码
        $db = new DBManage ( 'localhost', 'root', 'pwd','databasename', 'utf8' );
        // 参数：备份哪个表(可选),备份目录(可选，默认为backup),分卷大小(可选,默认2000，即2M)
        $db->backup('',"backup/",2000);
        // ------2. 数据库恢复（导入）------------------------------------------------------------
        // 参数：sql文件
        // $db->restore ( 'backup/20120914122939_all_v1.sql');  include 'dbclass.php';
        // ------1. 数据库备份（导出）------------------------------------------------------------
        // 分别是主机，用户名，密码，数据库名，数据库编码
        $db = new DBManage ( 'localhost', 'root', 'pwd','databasename', 'utf8' );
        // 参数：备份哪个表(可选),备份目录(可选，默认为backup),分卷大小(可选,默认2000，即2M)
        $db->backup('',"backup/",2000);
        // ------2. 数据库恢复（导入）------------------------------------------------------------
        // 参数：sql文件
        // $db->restore ( 'backup/20120914122939_all_v1.sql');
    }



}

<?php
/**
 * Ar default public config file.
 *
 */
return array(
    // 组件配置
    'components' => array(
        // 依赖懒加载组件
       'lazy' => true,
       // db 组件配置
       'db' => array(
            // 定义组件名称mysql
           'mysql' => array(
                // 通用配置格式
               'config' => array(
                   'read' => array(
                       'default' => array(
                           'dsn' => 'mysql:host=localhost;dbname=test;port=3306',
                            // 用户名
                           'user' => 'root',
                            // 密码
                           'pass' => 'root',
                           // 表前缀 建议为空
                           'prefix' => '',

                           // 连接选项 数据库需要支持PDO扩展 PDO开启后请取消注释下面行，否则看不到SQL报错或者编码错误
                           'option' => array(
                                // PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                                // PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
                                // PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);
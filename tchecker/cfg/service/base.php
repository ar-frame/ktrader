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
       'rpc' => array(
            'service' => array(
                'config' => array(
                    // 服务地址 改为自己的地址
                    // 'wsFile' => 'http://localhost/task/server/arws.php',
                    'wsFile' => 'http://192.168.101.177:19008',
                    // 服务端验证KEY
                    'authSign' => array(
                        'AUTH_SERVER_OPKEY' => 'AABBCCKTRADER2022',
                    )
                ),
            ),
        ),
       // db 组件配置
       'db' => array(
            // 定义组件名称mysql
           'mysql' => array(
                // 通用配置格式
               'config' => array(
                   'read' => array(
                        'tchecker' => array(
                            'dsn' => 'mysql:host=127.0.0.1;dbname=tchecker;port=3306',
                            // 用户名
                            'user' => 'root',
                            // 密码
                            'pass' => '123456',
                            // 表前缀 建议为空
                            'prefix' => '',

                            // 连接选项 数据库需要支持PDO扩展 PDO开启后请取消注释下面行，否则看不到SQL报错或者编码错误
                            'option' => array(
                                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                                PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
                                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'',
                            ),
                        ),

                        // paint
                        'tchecker_paint' => array(
                            'dsn' => 'mysql:host=localhost;dbname=tchecker_paint;port=19002',
                            // 用户名
                            'user' => 'root',
                            // 密码
                            'pass' => '123456',
                            // 表前缀 建议为空
                            'prefix' => '',
                            // 连接选项 数据库需要支持PDO扩展 PDO开启后请取消注释下面行，否则看不到SQL报错或者编码错误
                            'option' => array(
                                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                                PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
                                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'',
                            ),
                        ),
                    ),
                ),
            ),
        ),
        // db 配置结束
    ),

);

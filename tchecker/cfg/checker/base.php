<?php
/**
 * Ar default public config file.
 *
 */
return array(
    // 用户登陆有效时长 一个月
    'USER_VALID_TIME' => 60 * 60 * 24 * 30,
    
    // 组件配置
    'components' => array(
        // 依赖懒加载组件
       'lazy' => true,
       'rpc' => array(
            'service' => array(
                'config' => array(
                    // 服务地址 改为自己的地址
                    //'wsFile' => 'http://127.0.0.1/task/server/arws.php',
                    // 使用线上的API
                    'wsFile' => 'http://127.0.0.1:8082',
                    'authSign' => array(
                        'AUTH_SERVER_OPKEY' => 'seraagaldnialaldshgadl12312lasdfaaa',
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
                            'dsn' => 'mysql:host=127.0.0.1;dbname=tchecker;port=19002',
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
                        'trader' => array(
                            'dsn' => 'mysql:host=127.0.0.1;dbname=trader;port=19002',
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

    'pairMap' => [
        '10805' => 'ETH-USDT',
        '10806' => 'EOS-USDT',
        '10807' => 'BTC-USDT',
        '10808' => 'LTC-USDT',
        '10809' => 'GT-USDT',
        '10800' => 'ETC-USDT',
        '10802' => 'BCH-USDT',
        '10803' => 'ONT-USDT',
        '10804' => 'XRP-USDT',
        '12325' => 'HT-USDT',
    ],
);

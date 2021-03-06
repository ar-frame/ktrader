<?php
/**
 * Ar default public config file.
 *
 */
return array(
    // git 前缀
    'GIT_ADDRESS_PREFIX' => 'https://abc.com/',
    // git 物理地址 加/
    'GIT_DIR_PREFIX' => '/repo/repos/',

    // 组件配置
    'components' => array(
        // 依赖懒加载组件
        'lazy' => true,
        'rpc' => array(
            'service' => array(
                'config' => array(
                    // 服务地址 改为自己的地址
                    'wsFile' => 'http://192.168.101.177:19007/arws.php',
                    // 服务端验证KEY
                    'authSign' => array(
                        'AUTH_SERVER_OPKEY' => 'aaaaaaaabbbialasdddggSG2022ldshgaccccc',
                        'AUTH_SERVER_TOOLKEY' => 'tseraagaldnialAuthTkey12hhhasdfaaa',
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
                        'default' => array(
                            'dsn' => 'mysql:host=localhost;dbname=tchecker_admin;port=19002',
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
                        // trader
                        'trader' => array(
                            'dsn' => 'mysql:host=localhost;dbname=trader;port=19002',
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

                        // tchecker
                        'tchecker' => array(
                            'dsn' => 'mysql:host=localhost;dbname=tchecker;port=19002',
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

    // 用户登陆有效时长 一个月
    'USER_VALID_TIME' => 60 * 60 * 24 * 365,
    // 上传video地址
    'UPLOAD_VIDEO_PATH' => AR_ROOT_PATH . '/arcz/assets/upload/video',
    // 上传video地址
    'UPLOAD_IMG_PATH' => AR_ROOT_PATH . '/arcz/assets/upload/img',
    // 上传地址
    'UPLOAD_VIDEO_PREFIX' => '/assets/upload/video',
    // 上传地址 (图片)
    'UPLOAD_IMG_URL_PREFIX' => '/assets/upload/img',

    'CZ_PUB_SERVER_PATH' => 'http://192.168.101.177:19006',

);
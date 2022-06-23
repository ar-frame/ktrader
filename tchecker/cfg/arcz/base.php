<?php
/**
 * 数据库配置文件
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
                    'wsFile' => 'http://192.168.101.177:19007/arws.php',
                    'authSign' => array(
                        'AUTH_SERVER_OPKEY' => 'aaaaaaaabbbialasdddggSG2022ldshgaccccc',
                    )
                ),
            ),
        ),
    ),
    
    'SDK_ONLINE_SERVER' => 'http://192.168.101.177:19007/arws.php',
    'CZ_PUB_SERVER_PATH' => 'http://192.168.101.177:19006',
);

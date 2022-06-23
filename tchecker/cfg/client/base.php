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
                    //'wsFile' => 'http://localhost/task/server/arws.php',
                    'wsFile' => 'http://bestplan.coopcoder.com/service',
                    'wsFile' => 'http://bestplan-dev.coopcoder.com/service',
                    // 'wsFile' => 'https://www.coopcoder.com/coop_server',
                    'authSign' => array(
                        'AUTH_SERVER_OPKEY' => 'seraagaldnialaldshgadl12312lasdfaaa',
                    )
                ),
            ),
       ),
       // db 组件配置
    ),
);

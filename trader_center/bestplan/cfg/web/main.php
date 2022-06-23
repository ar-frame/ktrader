<?php
/**
 * Ar default app config file.
 *
 * @author ycassnr <ycassnr@gmail.com>
 */
return array(
     // 路由
    'URL_ROUTE_RULES' => array(
        // 首页
        'Index/home' => array(
            'mode' => array(
                '/',
            ),
        ),
        // 价格
        'Index/price' => array(
            'mode' => array(
                'price'
            ),
        ),

         // 下载
        'Index/download' => array(
            'mode' => array(
                'download'
            ),
        ),

        // 帮助
        'Index/readhelp' => array(
            'mode' => array(
                'readhelp.html'
            ),
        ),
        // 股票
           'Index/shares' => array(
               'mode' => array(
                  'shares'
                ),
        ),
         // 科研详情
            'Index/reportDetails' => array(
                 'mode' => array(
                     'reportDetails'
                  ),
         ),
         // 科研详情
            'Index/history' => array(
                 'mode' => array(
                     'history'
                   ),
          ),
    )
);
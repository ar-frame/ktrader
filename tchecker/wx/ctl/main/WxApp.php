<?php
/**
 * Coop-Task 靠谱云WEB用户中心.
 *
 * 靠谱云开发 Coop api
 *
 * 成达传网络科技旗下[靠谱云开发]版权所有2019/05
 *
 * PHP version 7.3.22
 *
 * @category PHP
 * @package  CDC-COOP_TASK-WEB
 * @author   assnr <ycassnr@gmail.com>
 * @license  https://www.coopcoder.com/licence COOP-3
 * @version  GIT: COOP-7.3.0
 * @link     https://www.coopcoder.com
 */
namespace wx\ctl\main;

/**
 * 靠谱云用户控制类
 *
 * @category  PHP
 * @package   CDC-COOP_TASK-WEB
 * @author    assnr <ycassnr@gmail.com>
 * @copyright 2012-2019 成都成达传网络科技-COOP Technology GP
 * @license   http://www.coopcoder.com/licence ar licence 7.1
 * @version   Release: @靠谱云开发@
 * @link      https://www.coopcoder.com
 */
class WxApp extends Base
{
    /**
    * 初始化方法
    *
    * @param array $notCheckAction 不需要check的方法
    *
    * @author assnr <ycassnr@gmail.com>
    *
    * @apiname 初始化
    *
    * @return void
    */
    public function init($notCheckAction = ['man'])
    {
        parent::init();

        $action = \ar\core\cfg('requestRoute.a_a');
        if (in_array($action, $notCheckAction)) {
            // return;
        } else {
            // check
            // echo 'check some';
        }
    }

    /**
     * 微信小程序上传
     *
     * @param string  $opt 操作模式
     *
     * @author assn <ycassnr@gmail.com>
     *
     * @apiname man
     *
     * @return string
    */
    public function man($opt)
    {
        // var_dump($opt);
        \ar\core\comp('tools.log')->record(\ar\core\request(), 'man');

        \ar\core\comp('tools.log')->record($_SERVER, 'server');

        // echo exec('cli login');

        $file = 'C:/Users/Administrator/AppData/Local/微信开发者工具/User Data/Default/.ide';

        if (is_file($file)) {
            $contentPort = file_get_contents($file);
        } else {
            $contentPort = false;
        }
        
        $authData = \ar\core\request();
        if (!isset($authData['opt']) || !isset($authData['appid'])|| !isset($authData['api_root']) ) {
            exit('服务接口未授权');
        }


        if (!isset($authData['opt'])) {
            exit('opt服务接口未授权');
        }

        $opt = $authData['opt'];

        if (!$contentPort) {
            exit('微信服务未启动');
        }

        // $dir = 'g:/nodejs/hj-4.2.37';
        $dir = 'D:/wx/hjwx';
        // $opt = 'preview';
        $appid = $authData['appid'];
        $api_root = $authData['api_root'];

        switch ($opt) {
            case 'login':
                $code = 0;
                $url = 'http://127.0.0.1:' . $contentPort . '/v2/login?qr-format=base64';

                $bankstr = \ar\core\comp('rpc.source')->remoteCall($url);
                $bankstrObject = json_decode($bankstr, 1);

                if (isset($bankstrObject['code']) && $bankstrObject['code'] > 0 && $bankstrObject['message']) {
                    $data = [
                        'msg' => $bankstrObject['message'],
                        'code' => $bankstrObject['code'],
                    ];

                } else {
                    
                    if (strpos($authData['options'], 'live-player-plugin') !== false) {
                        $live_player_plugin = '"live-player-plugin": {
                          "version": "1.0.3",
                          "provider": "wx2b03c6e691cd7370"
                        }';
                    } else {
                        $live_player_plugin = '';
                    }

                    $appJsonInfo =<<<str
{
  "pages": [
    "pages/index/index",
    "pages/favorite/favorite",
    "pages/cart/cart",
    "pages/article/article-list/article-list",
    "pages/article/article-detail/article-detail",
    "pages/binding/binding",
    "pages/store/store",
    "pages/store/detail",
    "pages/search/search",
    "pages/video/video",
    "pages/web/web",
    "pages/comments/comments",
    "pages/disabled/disabled",
    "pages/template/template"
  ],
  "subPackages": [
    {
      "root": "pages/foot",
      "pages": [
        "index/index",
        "summary/summary"
      ]
    },
    {
      "root": "pages/coupon",
      "pages": [
        "list/list",
        "details/details",
        "index/index"
      ]
    },
    {
      "root": "pages/cats",
      "pages": [
        "cats"
      ]
    },
    {
      "root": "pages/card",
      "pages": [
        "index/index",
        "details/details",
        "clerk/clerk"
      ]
    },
    {
      "root": "pages/balance",
      "pages": [
        "recharge",
        "balance",
        "rules",
        "detail"
      ]
    },
    {
      "root": "pages/topic",
      "pages": [
        "list",
        "topic"
      ]
    },
    {
      "root": "pages/goods",
      "pages": [
        "list",
        "goods",
        "video"
      ]
    },
    {
      "root": "pages/member",
      "pages": [
        "index/index",
        "rules/rules",
        "upgrade/upgrade",
        "detail/detail"
      ]
    },
    {
      "root": "pages/user-center",
      "pages": [
        "user-center",
        "integral-detail/integral-detail"
      ]
    },
    {
      "root": "pages/address",
      "pages": [
        "address",
        "address-edit"
      ]
    },
    {
      "root": "pages/share",
      "pages": [
        "index/index",
        "add/add",
        "cash/cash",
        "money/money",
        "order/order",
        "cash-detail/cash-detail",
        "team/team",
        "qrcode/qrcode",
        "level/level"
      ]
    },
    {
      "root": "pages/order-submit",
      "pages": [
        "order-submit",
        "address-pick",
        "store-pick",
        "coupon-pick",
        "pay-result",
        "map"
      ]
    },
    {
      "root": "plugins/pond",
      "pages": [
        "index/index",
        "rule/rule",
        "prize/prize"
      ]
    },
    {
      "root": "plugins/scratch",
      "pages": [
        "index/index",
        "rule/rule",
        "prize/prize"
      ]
    },
    {
      "root": "plugins/bonus",
      "pages": [
        "index/index",
        "about/about",
        "cash/cash",
        "cash-detail/cash-detail",
        "order/order",
        "memeber/memeber",
        "statics/statics"
      ]
    },
    {
      "root": "plugins/stock",
      "pages": [
        "index/index",
        "update/update",
        "cash/cash",
        "bonus/bonus",
        "cash-detail/cash-detail",
        "balance/balance",
        "about/about"
      ]
    },
    {
      "root": "plugins/lottery",
      "pages": [
        "index/index",
        "detail/detail",
        "goods/goods",
        "lucky-code/lucky-code",
        "prize/prize",
        "rule/rule",
        "qrcode/qrcode"
      ]
    },
    {
      "root": "plugins/check_in",
      "pages": [
        "index/index",
        "rules/rules"
      ]
    },
    {
      "root": "plugins/step",
      "pages": [
        "index/index",
        "rules/rules",
        "dare/dare",
        "join/join",
        "log/log",
        "share/share",
        "detail/detail",
        "friend/friend",
        "top/top",
        "goods/goods"
      ]
    },
    {
      "root": "plugins/fxhb",
      "pages": [
        "detail/detail",
        "rule/rule"
      ]
    },
    {
      "root": "plugins/scan_code",
      "pages": [
        "index/index",
        "index/coupon"
      ]
    },
    {
      "root": "plugins/bargain",
      "pages": [
        "index/index",
        "goods/goods",
        "order-list/order-list",
        "activity/activity",
        "rule/rule"
      ]
    },
    {
      "root": "plugins/integral_mall",
      "pages": [
        "index/index",
        "goods/goods",
        "about/about",
        "coupon/coupon",
        "exchange/exchange"
      ]
    },
    {
      "root": "plugins/clerk",
      "pages": [
        "index/index",
        "statics/statics",
        "order/order",
        "detail/detail"
      ]
    },
    {
      "root": "pages/app_admin",
      "pages": [
        "index/index",
        "order-message/order-message",
        "order/order",
        "change-add/change-add",
        "express/express",
        "send/send",
        "order-detail/order-detail",
        "user/user",
        "goods/goods",
        "add-goods/add-goods",
        "goods-attr/goods-attr",
        "goods-attr-edit/goods-attr-edit",
        "goods-attr-info/goods-attr-info",
        "goods-detail/goods-detail",
        "goods-card/goods-card",
        "goods-cat/goods-cat",
        "comment-detail/comment-detail",
        "comment/comment",
        "setting/setting",
        "cash/cash",
        "review-message/review-message",
        "mch-detail/mch-detail",
        "payment-code/payment-code"
      ]
    },
    {
      "root": "plugins/mch",
      "pages": [
        "apply/apply",
        "apply_rules/apply_rules",
        "cat/cat",
        "goods/goods",
        "list/list",
        "shop/shop",
        "summary/summary",
        "mch/login/login",
        "mch/myshop/myshop",
        "mch/account/account",
        "mch/account-log/account-log",
        "mch/settle-detail/settle-detail",
        "mch/cash-log/cash-log",
        "mch/cash/cash",
        "mch/count/count",
        "mch/config/config",
        "mch/password/password",
        "mch/web-login/web-login",
        "mch/qrcode/qrcode",
        "mch/goods/goods",
        "mch/add-goods/add-goods",
        "mch/goods-detail/goods-detail",
        "mch/order/order",
        "mch/order-detail/order-detail",
        "mch/send/send",
        "mch/express/express"
      ]
    },
    {
      "root": "plugins/pt",
      "pages": [
        "order/order",
        "detail/detail",
        "specification/specification",
        "goods/goods",
        "index/index"
      ]
    },
    {
      "root": "plugins/book",
      "pages": [
        "index/index",
        "goods/goods",
        "orderDetails/orderDetails",
        "order/order",
        "reservationList/reservationList"
      ]
    },
    {
      "root": "plugins/miaosha",
      "pages": [
        "goods/goods",
        "advance/advance"
      ]
    },
    {
      "root": "plugins/vip_card",
      "pages": [
        "index/index",
        "buy/buy",
        "rules/rules",
        "rights/rights"
      ]
    },
    {
      "root": "pages/order",
      "pages": [
        "index/index",
        "order-detail/order-detail",
        "express-detail/express-detail",
        "refund/refund",
        "refund/index",
        "refund-detail/refund-detail",
        "clerk/clerk",
        "appraise/appraise",
        "appraise-finish/index",
        "express-list/express-list"
      ]
    },
    {
      "root": "plugins/advance",
      "pages": [
        "index/index",
        "detail/detail",
        "order/order",
        "search/search",
        "order-detail/order-detail"
      ]
    },
    {
      "root": "plugins/quick_share",
      "pages": [
        "index/index"
      ]
    },
    {
      "root": "plugins/gift",
      "pages": [
        "index/index",
        "goods/goods",
        "list/list",
        "rule/rule",
        "share/share",
        "order/order",
        "address/address",
        "detail/detail",
        "receive/receive",
        "search/search"
      ]
    },
    {
      "root": "pages/quick-shop",
      "pages": [
        "quick-shop"
      ]
    },
    {
      "root": "plugins/pick",
      "pages": [
        "index/index",
        "pond/pond",
        "detail/detail",
        "search/search",
        "rule/rule"
      ]
    },
    {
      "root": "pages/live",
      "pages": [
        "index",
        "playback"
      ],
      "plugins": {
        $live_player_plugin
      }
    }
  ],
  "window": {
    "navigationBarTextStyle": "black",
    "navigationBarTitleText": "",
    "navigationBarBackgroundColor": "#F8F8F8",
    "backgroundColor": "#F8F8F8"
  },
  "permission": {
    "scope.userLocation": {
      "desc": "请求获取您的位置信息"
    }
  },
  "uniStatistics": {
    "enable": false
  },
  "usingComponents": {
    "app-button": "/components/basic-component/app-button/app-button",
    "app-form-id": "/components/basic-component/app-form-id/app-form-id",
    "app-layout": "/components/basic-component/app-layout/app-layout",
    "app-input": "/components/basic-component/app-input/app-input",
    "app-jump-button": "/components/basic-component/app-jump-button/app-jump-button",
    "app-load-text": "/components/basic-component/app-load-text/app-load-text",
    "app-image": "/components/basic-component/app-image/app-image"
  },
  "sitemapLocation": "sitemap18.json"
}


str;

                    $needUpdateFile1 = $dir . '/' . 'project.config.json';

                    $needUpdateFile2 = $dir . '/' . 'siteinfo.js';
                    $needUpdateFile3 = $dir . '/' . 'app.json';

                    $c1 = file_get_contents($needUpdateFile1);
                    $c1 = preg_replace('/"appid": "(\w+)"/i', '"appid": "'. $appid . '"', $c1);

                    $cremoteurl = $authData['cremoteurl'];

                    $serverUrl = $cremoteurl . $api_root;

                    $siteinfo=<<<str
var siteinfo = {
    'acid': -1,
    'version': '1.0.0',
    'siteroot': 'https://www.baidu.com/app/index.php',
    "apiroot": "{$serverUrl}",
};
module.exports = siteinfo;
str;
                    $c2 = file_get_contents($needUpdateFile2);

                    file_put_contents($needUpdateFile1, $c1);
                    file_put_contents($needUpdateFile2, $siteinfo);
                    file_put_contents($needUpdateFile3, $appJsonInfo);

                    $data = [
                        'data' => [
                            'qrcode' => $bankstrObject['qrcode'],
                        ],
                        'code' => $code,
                    ];

                    \ar\core\comp('cache.file')->set('acache' . $appid, $bankstrObject['qrcode']);
                }

                echo json_encode($data);
                break;

            case 'preview':
                $code = 0;
                $retry = 0;

                $url = 'http://127.0.0.1:' . $contentPort . '/v2/preview?qr-format=base64&project=' . urlencode($dir);

                if (false && isset($bankstrObject['code']) && $bankstrObject['code'] > 0 && $bankstrObject['message']) {
                    $data = [
                        'msg' => $bankstrObject['message'],
                        'code' => $bankstrObject['code'],
                        'data' => [
                            'retry' => 1,
                        ]
                    ];

                } else {
                    // 太卡直接返回
                    $bankstr = 'aa';
                    $qrcode = \ar\core\comp('cache.file')->get('acache' . $appid);
                    // $qrcode = 'data:image/jpeg;base64,' . $bankstr;
                    $data = [
                        'data' => [
                            'qrcode' => $qrcode,
                            'retry' => $retry,
                        ],
                        'code' => $code,
                    ];
                }
    

                echo json_encode($data);
                break;

            case 'upload':
                $version = $authData['version'];
                $version = 'cshop2.0.1';

                $urlUpload = 'http://127.0.0.1:' . $contentPort . '/v2/upload?project='. urlencode($dir) . '&version=' . $version . '&desc=powerd.by.cdc.' . time();

                // 执行上传
                $uploadBackString = \ar\core\comp('rpc.source')->remoteCall($urlUpload);
                echo $uploadBackString;

                break;
            default:
                # code...
                echo 'api error';
                break;
        }
    }
}
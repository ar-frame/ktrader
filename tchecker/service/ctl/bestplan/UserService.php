<?php
/**
 * OpenService.
 *
 * 靠谱云开发 Coop OpenService
 *
 * 成达传网络科技旗下[靠谱云开发]版权所有2019/05
 *
 * PHP version 7.3.22
 *
 * @category PHP
 * @package  CDC-SERVER
 * @author   ycassnr <ycassnr@gmail.com>
 * @license  https://www.coopcoder.com/licence COOP-3
 * @version  GIT: COOP-7.3.0
 * @link     https://www.coopcoder.com
 */
namespace service\ctl\bestplan;

/**
 * OpenService
 *
 * @category  PHP
 * @package   CDC-SERVER
 * @author    ycassnr <ycassnr@gmail.com>
 * @copyright 2012-2019 成都成达传网络科技-COOP Technology GP
 * @license   http://www.coopcoder.com/licence ar licence 7.1
 * @version   Release: @靠谱云开发@
 * @link      https://www.coopcoder.com
 */
class UserService extends BaseService
{
    // 新接口，从这里开始写

    /**
     * 1 激活
     *
     * 客户端调用方式
        try {
            $response = \ar\core\comp('rpc.service')
                ->call('Ws.service.ctl.bestplan.user', "activation", [$activationCode]);
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param string $activationCode 激活码
     * @param string $mac            唯一标识
     * 
     * @author assn <ycassnr@gmail.com>
     *
     * @apiname 激活
     *
     * @return object
     */
    public function activationWorker($activationCode, $mac)
    {
        $pm = '';
        $osversion = '';
        $uid = '';
        $registerCode = $activationCode;
        $errMsg = \ar\core\service('checker.main.Auth')->registerCodeUser($registerCode, $mac, $pm, $uid, $osversion);

        $retMsg = '';
        $retCode = 1000;
        if ($errMsg['errMsg']) {
            $retMsg = $errMsg['errMsg'];
            $retCode = 1001;
        }

        $obj = [
            'retCode' => $retCode,
            'retMsg' => $retMsg,
            'phoneId' => $errMsg['uid']
        ];
        $this->response($obj);
    }

    /**
     * 2 获取推荐股票列表
     *
     * 客户端调用方式
        try {
            $response = \ar\core\comp('rpc.service')
                ->call('Ws.service.ctl.bestplan.user', "getShareslist", [$KeyWord, $pageRow, $page, $phoneId, $collection]);
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param string $activationCode 激活码
     * 
     * @author assn <ycassnr@gmail.com>
     *
     * @apiname 获取推荐股票列表
     *
     * @return object
     */
    public function getShareslistWorker($KeyWord, $pageRow, $page, $phoneId, $collection, $filterString = '')
    {
        $data = \ar\core\service("Stock")->getShareslist($KeyWord, $pageRow, $page, $phoneId, $collection, $filterString);

        if ($data && trim($KeyWord)) {
            \ar\core\service("bestplan.Stock")->addSearchHistory($KeyWord, $phoneId);
        }
        $this->response($data);
    }

    /**
     * 3.获取搜索历史1-2
     *
     * 客户端调用方式
        try {
            $response = \ar\core\comp('rpc.service')
                ->call('Ws.service.ctl.bestplan.user', "getSearchlist", [$KeyWord, $pageRow, $page, $phoneId, $collection]);
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param string $activationCode 激活码
     * 
     * @author assn <ycassnr@gmail.com>
     *
     * @apiname 3.获取搜索历史1-2
     *
     * @return array
     */
    public function getSearchlistWorker($phoneId)
    {
        $data = \ar\core\service("bestplan.Stock")->getSearchHistory($phoneId);
        $this->response($data);
    }

    /**
     * 4.清除搜索历史1-2
     *
     * 客户端调用方式
        try {
            $response = \ar\core\comp('rpc.service')
                ->call('Ws.service.ctl.bestplan.user', "cleanSearch", [$phoneId]);
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param string $phoneId phoneId
     * 
     * @author assn <ycassnr@gmail.com>
     *
     * @apiname 4.清除搜索历史1-2
     *
     * @return object
     */
    public function cleanSearchWorker($phoneId)
    {
        \ar\core\service("bestplan.Stock")->cleanSearchHistory($phoneId);
        $obj = [
            'retCode' => 1000,
            'retMsg' => ''
        ];
        $this->response($obj);
    }

    /**
     * 5.收藏股票1-1、1-3~1-5
     *
     * 客户端调用方式
        try {
            $response = \ar\core\comp('rpc.service')
                ->call('Ws.service.ctl.bestplan.user', "collection", [$phoneId, $sharesCode, $mode]);
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param string $phoneId phoneId
     * 
     * @author assn <ycassnr@gmail.com>
     *
     * @apiname 5.收藏股票1-1、1-3~1-5
     *
     * @return object
     */
    public function collectionWorker($phoneId, $sharesCode, $mode)
    {
        \ar\core\service("bestplan.Stock")->collection($phoneId, $sharesCode, $mode);
        $obj = [
            'retCode' => 1000,
            'retMsg' => ''
        ];
        $this->response($obj);
    }

    /**
     * 6.获取推荐中股票信息1-4、1-5
     *
     * 客户端调用方式
        try {
            $response = \ar\core\comp('rpc.service')
                ->call('Ws.service.ctl.bestplan.user', "getShares", [$phoneId, $sharesCode, $mode]);
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param string $phoneId phoneId
     * 
     * @author assn <ycassnr@gmail.com>
     *
     * @apiname 6.获取推荐中股票信息1-4、1-5
     *
     * @return object
     */
    public function getSharesWorker($sharesCode, $phoneId = '')
    {
        // $obj = [
        //     'sharesName' => "金种子酒",
        //     'sharesCode' => 600199,
        //     'sharesTime' => '今天 14:25',
        //     'direction' => 0,
        //     'nPrice' => '9.97',
        //     'fprice' => '15.89',
        //     'rPrice' => '8.77',
        //     'accuracy' => '67',
        //     'collection' => 1,
        //     'profit' => "35.9",
        //     'recommendNo' => '',
        //     'retCode' => 3,
        //     'retMsg' => '',
        // ];
        $obj = \ar\core\service("bestplan.Stock")->getSummary($sharesCode, $phoneId);
        $this->response($obj);
    }

    /**
     * 7.获取历史股票列表1-4、1-5
     *
     * 客户端调用方式
        try {
            $response = \ar\core\comp('rpc.service')
                ->call('Ws.service.ctl.bestplan.user', "getShares", [$phoneId, $sharesCode, $mode]);
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param string $phoneId phoneId
     * 
     * @author assn <ycassnr@gmail.com>
     *
     * @apiname 7.获取历史股票列表1-4、1-5
     *
     * @return object
     */
    public function getShareslistHistoryWorker($pageRow, $page, $sharesCode)
    {
        $dataobj = \ar\core\service("bestplan.Stock")->getRecords($pageRow, $page, $sharesCode);
        // $data = [];
        // for ($i = 0; $i < 10; $i++) {
        //     $data[] = [
        //         'sharesName' => '金种子酒' . $i,
        //         'sharesCode' => '600199',
        //         'direction' => 1,
        //         'sharesTime' => '昨天 13:56',
        //         'endTime' => '今天 09:52',
        //         'fprice' => '9.77',
        //         'rPrice' => '8.88',
        //         'ePrice' => "9.67",
        //         'result' => 1,
        //     ];
        // }

        // $dataobj = [
        //     'data' => $data,
        //     'page_obj' => [
        //         'totalPage' => 2,
        //         'totalRecord' => 10,
        //         'currentPage' => $page,
        //     ]
        // ];
        $this->response($dataobj);
    }

    /**
     * 8.获取资讯列表2-1
     *
     * 客户端调用方式
        try {
            $response = \ar\core\comp('rpc.service')
                ->call('Ws.service.ctl.bestplan.user', "getNewslist", [$pageRow, $page]);
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param string $phoneId phoneId
     * 
     * @author assn <ycassnr@gmail.com>
     *
     * @apiname 8.获取资讯列表2-1
     *
     * @return object
     */
    public function getNewslistWorker($pageRow, $page)
    {
        $dataobj = \ar\core\service("bestplan.Stock")->getNewslist($pageRow, $page);
        // $data = [];
        // for ($i = 0; $i < 10; $i++) {
        //     $data[] = [
        //         'newsId' => '1' . $i,
        //         'newsTime' => '2020/10/22 18:56',
        //         'newsTitle' => '金种子酒荣登酒类排行第一名' . $i,
        //         'cover1' => 'https://www.coopcoder.com/themes/main/def/img/logo_1.png',
        //         'cover2' => 'https://www.coopcoder.com/themes/main/def/img/logo_1.png',
        //         'cover3' => 'https://www.coopcoder.com/themes/main/def/img/logo_1.png',
        //     ];
        // }
        // $dataobj = [
        //     'data' => $data,
        //     'page_obj' => [
        //         'totalPage' => 2,
        //         'totalRecord' => 10,
        //         'currentPage' => $page,
        //     ]
        // ];
        $this->response($dataobj);
    }

    /**
     * 9.获取资讯详情2-2
     *
     * 客户端调用方式
        try {
            $response = \ar\core\comp('rpc.service')
                ->call('Ws.service.ctl.bestplan.user', "getNewsdetail", [$newsId]);
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param string $phoneId phoneId
     * 
     * @author assn <ycassnr@gmail.com>
     *
     * @apiname 9.获取资讯详情2-2
     *
     * @return object
     */
    public function getNewsdetailWorker($newsId)
    {
        $obj = \ar\core\service("bestplan.Stock")->getNewsdetail($newsId);
        // $obj = [
        //     'newsTime' => "金种子酒喜获腾讯5.2亿美金投资",
        //     'newsTitle' => 600199,
        //     'newsDetail' => '今天 14:25, 交易正式完成，股价顺势涨停666',
        //     'retCode' => 1000,
        //     'retMsg' => '',
        // ];
        $this->response($obj);
    }

    /**
     * 10.获取剩余时间3-1
     *
     * 客户端调用方式
        try {
            $response = \ar\core\comp('rpc.service')
                ->call('Ws.service.ctl.bestplan.user', "getTime", [$phoneId]);
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param string $phoneId phoneId
     * 
     * @author assn <ycassnr@gmail.com>
     *
     * @apiname 10.获取剩余时间3-1
     *
     * @return object
     */
    public function getTimeWorker($phoneId)
    {
        $pm = '';
        $uid = $phoneId;
        $lastRegisterCode = '';
        $mac = '';
        $errMsg = \ar\core\service('checker.main.Auth')->authUser($mac, $lastRegisterCode, $uid, $pm);

        $obj = [
            'useTime' => $errMsg['can_use_dayoff'],
            'unit' => '天',
            'retCode' => 1000,
            'retMsg' => $errMsg['err_msg'],
        ];

        $this->response($obj);
    }

    /**
     * 11.获取客服信息3-3
     *
     * 客户端调用方式
        try {
            $response = \ar\core\comp('rpc.service')
                ->call('Ws.service.ctl.bestplan.user', "getService", []);
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param string $phoneId phoneId
     * 
     * @author assn <ycassnr@gmail.com>
     *
     * @apiname 11.获取客服信息3-3
     *
     * @return object
     */
    public function getServiceWorker()
    {
        $data = \ar\core\service("bestplan.Stock")->getService();
        // $data = [];
        // for ($i = 0; $i < 10; $i++) {
        //     $data[] = [
        //         'serviceId' => '1' . $i,
        //         'serviceTitle' => '微信' . $i,
        //         'serviceDetail' => 'www8888' . $i,
        //     ];
        // }
        $this->response($data);
    }

    /**
     * 12.获取意见反馈列表3-4
     *
     * 客户端调用方式
        try {
            $response = \ar\core\comp('rpc.service')
                ->call('Ws.service.ctl.bestplan.user', "getShares", [$phoneId, $sharesCode, $mode]);
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param string $phoneId phoneId
     * 
     * @author assn <ycassnr@gmail.com>
     *
     * @apiname 12.获取意见反馈列表3-4
     *
     * @return object
     */
    public function getFeedbackListWorker($pageRow, $page, $phoneId)
    {
        $dataobj = \ar\core\service("bestplan.Stock")->getFeedbackList($pageRow, $page, $phoneId);
        // $data = [];
        // for ($i = 0; $i < 10; $i++) {
        //     $data[] = [
        //         'feedbackId' => '1' . $i,
        //         'fbContent' => '怎么购买激活码',
        //         'fbTime' => '2020/10/22 19:56',
        //         'reply' => 0,
        //     ];
        // }
        // $dataobj = [
        //     'data' => $data,
        //     'page_obj' => [
        //         'totalPage' => 2,
        //         'totalRecord' => 10,
        //         'currentPage' => $page,
        //     ]
        // ];
        $this->response($dataobj);
    }

    /**
     * 13.获取意见反馈详情3-5
     *
     * 客户端调用方式
        try {
            $response = \ar\core\comp('rpc.service')
                ->call('Ws.service.ctl.bestplan.user', "getReply", [$phoneId]);
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param string $phoneId phoneId
     * 
     * @author assn <ycassnr@gmail.com>
     *
     * @apiname 13.获取意见反馈详情3-5
     *
     * @return object
     */
    public function getReplyWorker($phoneId, $feedbackId)
    {
        $obj = \ar\core\service("bestplan.Stock")->getReply($phoneId, $feedbackId);
        // $obj = [
        //     'fbContent' => "怎么购买激活码",
        //     'replyDetail' => '激活码目前处于测试阶段，可以找客服免费领取一个月使用码',
        //     'retCode' => 1000,
        //     'retMsg' => '',
        // ];
        $this->response($obj);
    }

    /**
     * 14.提交意见反馈3-6
     *
     * 客户端调用方式
        try {
            $response = \ar\core\comp('rpc.service')
                ->call('Ws.service.ctl.bestplan.user', "submitFeedback", [$phoneId, $fbContent]);
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param string $phoneId phoneId
     * 
     * @author assn <ycassnr@gmail.com>
     *
     * @apiname 14.提交意见反馈3-6
     *
     * @return object
     */
    public function submitFeedbackWorker($phoneId, $fbContent)
    {
        $obj = \ar\core\service("bestplan.Stock")->submitFeedback($phoneId, $fbContent);
        $this->response($obj);
    }

    /**
     * 15.获取更新日志列表3-7
     *
     * 客户端调用方式
        try {
            $response = \ar\core\comp('rpc.service')
                ->call('Ws.service.ctl.bestplan.user', "getUprecordList", [$phoneId, $fbContent]);
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param string $phoneId phoneId
     * 
     * @author assn <ycassnr@gmail.com>
     *
     * @apiname 15.获取更新日志列表3-7
     *
     * @return object
     */
    public function getUprecordListWorker($pageRow, $page)
    {
        $dataobj = \ar\core\service("bestplan.Stock")->getUprecordList($pageRow, $page);
        $this->response($dataobj);
    }

    /**
     * 16.获取更新日志详情3-8
     *
     * 客户端调用方式
        try {
            $response = \ar\core\comp('rpc.service')
                ->call('Ws.service.ctl.bestplan.user', "getUprecordDetail", [$upId]);
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param string $phoneId phoneId
     * 
     * @author assn <ycassnr@gmail.com>
     *
     * @apiname 16.获取更新日志详情3-8
     *
     * @return object
     */
    public function getUprecordDetailWorker($upId)
    {
        $obj = \ar\core\service("bestplan.Stock")->getUprecordDetail($upId);
        // $obj = [
        //     'upTitle' => '升级显示配置' . $upId,
        //     'upDetail' => '升级显示配置， 性能提高，优化传输速度',
        //     'upTime' => '2020-10-28 17:58',
        //     'retCode' => 1000,
        //     'retMsg' => '',
        // ];
        $this->response($obj);
    }

    /**
     * 17.获取更新3-9
     *
     * 客户端调用方式
        try {
            $response = \ar\core\comp('rpc.service')
                ->call('Ws.service.ctl.bestplan.user', "getUp", []);
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param string $phoneId phoneId
     * 
     * @author assn <ycassnr@gmail.com>
     *
     * @apiname 17.获取更新3-9
     *
     * @return object
     */
    public function getUpWorker($version = '')
    {
        $appDownInfo = \ar\core\service("bestplan.Stock")->getAppDownVersion();

        $ignore = $appDownInfo['ignore']; // 0 可忽略 1 强制
        $useClientVersion = $appDownInfo['is_use_version_compare'];
        $newVersion = $appDownInfo['new_version']; //"v3.1.6";

        if ($version) {
            if ($useClientVersion) {
                $version = 'v' . str_replace("v", "", $version);
                if (version_compare($newVersion, $version) > 0) {
                    // 强制更新
                    $ignore = 1;
                } else {
                    $ignore = 0;
                }
            }
        } else {
            // 强制更新
            $ignore = 1;
        }

        $obj = [
            'version' => $newVersion,
            'upTitle' => $appDownInfo['title'],
            'upDetail' => $appDownInfo['detail'],
            'ignore' => $ignore,
            'upUrl' => $appDownInfo['app_down_url'], // 'http://bestplan.coopcoder.com/data/app/app-release.apk',
            'retCode' => 1000,
            'retMsg' => '',
        ];
        $this->response($obj);
    }

    /**
     * 18.获取更新3-9
     *
     * 客户端调用方式
        try {
            $response = \ar\core\comp('rpc.service')
                ->call('Ws.service.ctl.bestplan.user', "getUser", []);
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }

     * @param string $mac     mac
     * @param string $phoneId phoneId
     * 
     * @author assn <ycassnr@gmail.com>
     *
     * @apiname 17.获取更新3-9
     *
     * @return object
     */
    public function getUserWorker($mac = '', $phoneId = '', $pm = '', $osversion = '')
    {
        $vip = 0;
        $msg = '';
        $ret_code = 1000;

        if ($phoneId) {
            // 注册一个临时账号
            $uid = $phoneId;
            $registerCode = '';
            // 主要去获取VIP信息
            $errMsg = \ar\core\service('checker.main.Auth')->registerCodeUser('', $mac, $pm, $uid, $osversion, true);
            // var_dump($errMsg);
            if ($errMsg && $errMsg['errMsg']) {
                $ret_code = 1001;
                $msg = $errMsg['errMsg'];
            } else {
                $phoneId = $errMsg['uid'];
                $vip = $errMsg['is_vip'];
            }
            
        } else {
            // 注册一个临时账号/游客通道
            $uid = '';
            $registerCode = 'TEMP_'. strtoupper(md5($mac));

            $errMsg = \ar\core\service('checker.main.Auth')->registerCodeUser($registerCode, $mac, $pm, $uid, $osversion, true);

            $phoneId = $errMsg['uid'];
            $vip = $errMsg['is_vip'];
            
            $msg = '';
        }

        $obj = [
            'vip' => $vip,
            'phoneId' => $phoneId,
            'retCode' => $ret_code,
            'retMsg' => $msg,
        ];
        $this->response($obj);
    }

    /**
     * 19.获取搜索联想（1-2）
     *
     * 客户端调用方式
        try {
            $response = \ar\core\comp('rpc.service')
                ->call('Ws.service.ctl.bestplan.user', "getUser", []);
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }

     * @param string $mac     mac
     * @param string $phoneId phoneId
     * 
     * @author assn <ycassnr@gmail.com>
     *
     * @apiname 19.获取搜索联想（1-2）
     *
     * @return object
     */
    public function getAssociationWorker($KeyWord)
    {

        $list = [];
        for ($i = 0 ; $i < 10; $i++) {
            $list[] = ['no' => $i + 1 , 'association' => 'a' . $i];
        }
        $this->response($list);
    }

    /**
     * 20.获取热门搜索（1-2）
     *
     * 客户端调用方式
        try {
            $response = \ar\core\comp('rpc.service')
                ->call('Ws.service.ctl.bestplan.user', "getRank", []);
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }

     * @param string $mac     mac
     * @param string $phoneId phoneId
     * 
     * @author assn <ycassnr@gmail.com>
     *
     * @apiname 20.获取热门搜索（1-2）
     *
     * @return object
     */
    public function getRankWorker()
    {

        $list = \ar\core\service("bestplan.Stock")->getRank();
        // $list = [];
        // for ($i = 0 ; $i < 10; $i++) {
        //     $list[] = ['rank' => $i + 1 , 'search' => 's' . $i];
        // }
        $this->response($list);
    }
    
    /**
     * 21.获取今日概率1-4-1
     *
     * 客户端调用方式
        try {
            $response = \ar\core\comp('rpc.service')
                ->call('Ws.service.ctl.bestplan.user', "getChance", []);
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }

     * @param string $sharesCode     sharesCode
     * 
     * @author assn <ycassnr@gmail.com>
     *
     * @apiname 21.获取今日概率1-4-1
     *
     * @return object
     */
    public function getChanceWorker($sharesCode)
    {

        $obj = \ar\core\service("bestplan.Stock")->getChance($sharesCode);
        // $obj = [
        //     'upChance' => '15',
        //     'downChance' => '20',
        //     'keepChance' => '65',
        //     'updateTime' => '2020/12/23 13:16:25',
        //     'retCode' => '1000',
        //     'retMsg' => '获取成功',
        // ];
        $this->response($obj);
    }

    /**
     * 22.获取回测概览1-4-1
     *
     * 客户端调用方式
        try {
            $response = \ar\core\comp('rpc.service')
                ->call('Ws.service.ctl.bestplan.user', "getBack", []);
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }

     * @param string $sharesCode     sharesCode
     * 
     * @author assn <ycassnr@gmail.com>
     *
     principal  string  保留2位小数
        result  int 结果，0=亏损，1=盈利

        amount  string  盈利或亏损的金额，保留2位小数

        percent string  盈利或亏损的百分比，保留2位小数

        buyNo   int 买入次数
        sellNo  int 卖出次数
        nPrice  string  当前价格，跟之前的今日最新价相同
        costPrice   string  成本价格，保留2位小数
        position    string  当前持仓，保留2位小数
        surplus string  剩余资金，保留2位小数
        retCode int 1000成功，1001失败
        retMsg  string  失败返回信息
     * @apiname 22.获取回测概览1-4-1
     *
     * @return object
     */
    public function getBackWorker($sharesCode)
    {

        // $obj = [
        //     'principal' => '15',
        //     'result' => '0',
        //     'amount' => '65',
        //     'percent' => '2020/12/23 13:16:25',
        //     'buyNo' => '66',
        //     'sellNo' => '57',
        //     'nPrice' => '12.78',
        //     'costPrice' => '11.78',
        //     'position' => '35678',
        //     'surplus' => '123456',
        //     'retCode' => '1000',
        //     'retMsg' => '获取成功',
        // ];

        $obj = \ar\core\service("bestplan.Stock")->getBack($sharesCode);
        $this->response($obj);
    }

    /**
     * 23.获取30TD（1-4-2）
     *
     * 客户端调用方式
        try {
            $response = \ar\core\comp('rpc.service')
                ->call('Ws.service.ctl.bestplan.user', "getTd", []);
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }

     * @param int $sharesCode     sharesCode
     * @param int $sort sort
     * int

     sharesCode int 股票代码    是
        sort    int 排序方式，0=倒序，1=正序  是

        2）输出
        属性  类型  注释
        [0].sort    int 序号
        [0].direction   int 方向，0=买入，1=卖出
        [0].price   string  价格，保留2位小数
        [0].chance  string  概率，保留2位小数，带上百分号
        [0].tdTime  string  获取时间，格式：
        1.一般只显示月日
        2.入股是去年的，则显示：去年12-25


     * @author assn <ycassnr@gmail.com>
     *
     * @apiname 23.获取30TD（1-4-2）
     *
     * @return object
     */
    public function getTdWorker($sharesCode, $sort)
    {

        $list = \ar\core\service("bestplan.Stock")->getTd($sharesCode, $sort);
        // for ($i = 0 ; $i < 219; $i++) {
        //     $list[] = [
        //         'sort' => $i + 1 ,
        //         'direction' => '0',
        //         'price' => '26.78',
        //         'chance' => '90%',
        //         'tdTime' => date('Y-m-d H:i:s', time()),
        //     ];
        // }
        $this->response($list);
    }

    /**
     * 24.getNkLines-4-2）
     *
     * 客户端调用方式
        try {
            $response = \ar\core\comp('rpc.service')
                ->call('Ws.service.ctl.bestplan.user', "getNkLines", [$sharesCode]);
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }

     * @param int $sharesCode     sharesCode
     * int

     sharesCode int 股票代码    是

     * @author assn <ycassnr@gmail.com>
     *
     * @apiname 24.getNkLines-4-2）
     *
     * @return array
     */
    public function getNkLinesWorker($sharesCode)
    {
        $list = \ar\core\service("bestplan.Stock")->getNkLines($sharesCode);
        $this->response($list);
    }

    /**
     * 24.getNkLines-4-2）
     *
     * 客户端调用方式
        try {
            $response = \ar\core\comp('rpc.service')
                ->call('Ws.service.ctl.bestplan.user', "getNkLines", [$sharesCode]);
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }

     * @param int $sharesCode     sharesCode
     * int

     sharesCode int 股票代码    是

     * @author assn <ycassnr@gmail.com>
     *
     * @apiname 24.getNkLines-4-2）
     *
     * @return array
     */
    public function getNkLines2Worker($sharesCode)
    {
        $list = \ar\core\service("bestplan.Stock")->getNkLines($sharesCode);
        $this->response($list);
    }

    /**
     * getOverall
     *
     * 客户端调用方式
        try {
            $response = \ar\core\comp('rpc.service')
                ->call('Ws.service.ctl.bestplan.user', "getNewsdetail", [$newsId]);
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
        profitNo int盈利股票数量
        lossNo int亏损股票数量
        overallTime string更新时间
        profitPer string净盈利百分比
        lossPer string净亏损百分比
        averagePer string平均盈利百分比
        retCode int1000成功，1001失败
        retMsg string失败返回信息
     *
     * @param string $phoneId phoneId
     * 
     * @author assn <ycassnr@gmail.com>
     *
     * @apiname getOverall
     *
     * @return object
     */
    public function getOverallWorker()
    {
        // $obj = \ar\core\service("bestplan.Stock")->getOverall();
        $obj = [
            'profitNo' => 1688,
            'lossNo' => 1280,
            'overallTime' => '2021/01/19 14:25',
            'profitPer' => '12333',
            'lossPer' => '13344',
            'averagePer' => '666',
            'retCode' => 1000,
            'retMsg' => '',
        ];
        $this->response($obj);
    }

}
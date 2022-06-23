<?php
/**
 * Coop-Trader service.
 *
 * 靠谱云开发 Coop api
 *
 * 成达传网络科技旗下[靠谱云开发]版权所有2018/03
 *
 * PHP version 7.0.22
 *
 * @category PHP
 * @package  CDC-ORI
 * @author   ycassnr <ycassnr@gmail.com>
 * @license  http://www.coopcoder.com/licence COOP-3
 * @version  GIT: COOP-3.1.0
 * @link     http://www.coopcoder.com
 */
namespace checker\ctl\main\service;

/**
 * 申请模块
 *
 * @category  PHP
 * @package   CDC-ORI-SERVICE
 * @author    ycassnr <ycassnr@gmail.com>
 * @copyright 2012-2018 成都成达传网络科技-COOP Technology GP
 * @license   http://www.coopcoder.com/licence ar licence 5.1
 * @version   Release: @靠谱云开发@
 * @link      http://www.coopcoder.com
 */
class PushLogs
{
    // 主表名称
    const MAIN_TABLENAME = 'tchecker_user';
    // 注册码表
    const REGISTER_CODE_TABLENAME = 'tchecker_registercode';
    // 服务商
    const SERVICE_TABLENAME = 'tchecker_service';
    // 事件日志
    const EVENT_LOG_TABLENAME = 'tchecker_eventlog';
    // 事件通知日志
    const EVENT_PUSH_LOG_TABLENAME = 'tchecker_pushlog';
    // wxbind
    const MAIN_WX_TABLENAME = 'tchecker_user_wx';

    // 事件等级
    const AT_LEAST_PUSH_LOG_LEVEL = 1;

    // 数据库句柄
    protected $db_trader;

    // trade_pairs
    const TRADE_PAIRS = [
        'BTC-USDT', 'EOS-USDT', 'ETH-USDT'
    ];

    /**
     * 初始化
     *
     * @author assnr <ycassnr@gmail.com>
     *
     * @apiname 初始化
     *
     * @return string
    */
    public function init()
    {
        date_default_timezone_set('PRC'); //设置中国时区 
        $this->db_trader = \ar\core\comp('db.mysql')->read('trader');
        $this->db_checker = \ar\core\comp('db.mysql')->read('tchecker');
    }

    /**
     * doPushJob
     *
     * useage \ar\core\service('PushLogs')->doPushJob();
     *
     * @author assnr <ycassnr@gmail.com>
     *
     * @apiname doPushJob
     *
     * @return void
    */
    public function doPushJob()
    {
        foreach (self::TRADE_PAIRS as $pair) {
            $records = \ar\core\service('Trader')->records($pair, 10);

            $allUserTokens = $this->db_checker->table(self::MAIN_WX_TABLENAME)->where(['wx_token != ' => ''])->queryAll();
    
            if ($records) {
                $recordsLength = count($records);
                $lastRow = $records[$recordsLength - 1];
                $lastRow['price'] = sprintf('%.4f', $lastRow['price']);
    
                if ($lastRow['level'] >= self::AT_LEAST_PUSH_LOG_LEVEL) {
    
                    foreach ($allUserTokens as $user) {
                        $wxUserToken = $user['wx_token'];
                        $getLastRowPushLog = $this->db_checker->table(self::EVENT_PUSH_LOG_TABLENAME)
                            ->order('id desc')
                            ->where(['wx_token' => $wxUserToken, 'pair' => $pair])
                            ->queryRow();
    
                        if ($getLastRowPushLog) {
                            $getLastRowPushLog['price'] = sprintf('%.4f', $getLastRowPushLog['price']);

                            if ($getLastRowPushLog['type'] == $lastRow['type']) {
                                if ($getLastRowPushLog['level'] < $lastRow['level']) {
                                    unset($lastRow['id']);
                                    $log = $lastRow;
                                    $log['wx_token'] = $wxUserToken;
                                    $log['pair'] = $pair;
                                    $this->db_checker->table(self::EVENT_PUSH_LOG_TABLENAME)->insert($log);
                                } else {
                                    $shouldPush = false;
                                    if ($lastRow['type'] == 'buy') {
                                        if ($lastRow['price'] < $getLastRowPushLog['price']) {
                                            $shouldPush = true;
                                        }
                                    } else {
                                        if ($lastRow['price'] > $getLastRowPushLog['price']) {
                                            $shouldPush = true;
                                        }
                                    }
                                    if ($shouldPush) {
                                        unset($lastRow['id']);
                                        $log = $lastRow;
                                        $log['wx_token'] = $wxUserToken;
                                        $log['pair'] = $pair;
                                        $this->db_checker->table(self::EVENT_PUSH_LOG_TABLENAME)->insert($log);
                                    }
                                }
                            } else {
                                unset($lastRow['id']);
                                $log = $lastRow;
                                $log['wx_token'] = $wxUserToken;
                                $log['pair'] = $pair;
                                $this->db_checker->table(self::EVENT_PUSH_LOG_TABLENAME)->insert($log);
                            }
                            
                        } else {
                            unset($lastRow['id']);
                            $log = $lastRow;
                            $log['wx_token'] = $wxUserToken;
                            $log['pair'] = $pair;
                            $this->db_checker->table(self::EVENT_PUSH_LOG_TABLENAME)->insert($log);
                        }
                    }
                }
            }
        }
        
    }

    /**
     * sendPushWechatMsg
     *
     * useage \ar\core\service('PushLogs')->sendPushWechatMsg();
     *
     * @author assnr <ycassnr@gmail.com>
     *
     * @apiname sendPushWechatMsg
     *
     * @return void
    */
    public function sendPushWechatMsg() 
    {
        $getPushLogs = $this->db_checker->table(self::EVENT_PUSH_LOG_TABLENAME)
            ->order('id desc')
            ->where(['status' => 0])
            ->queryAll();

        if ($getPushLogs) {
            foreach ($getPushLogs as $log) {
                // $apiResult = [
                //     'msg' => 'send ok',
                // ];
                try {
                    // 接口名称
                    $apiname = 'Ws'.'server.ctl.main.Wechat';
                    $apiResult = \ar\core\comp('rpc.service')
                        ->$apiname("wxTaderPush",
                            array ($log['wx_token'], $log['pair'], $log['price'], $log['type'], $log['level'], $log['timedate'])
                        );

                    if ($apiResult) {
                        $log['status'] = 1;
                        $log['msg'] = $apiResult['msg'];
                        $this->db_checker->table(self::EVENT_PUSH_LOG_TABLENAME)->where(['id' => $log['id']])->update($log);
                    }
                    // todo $res
                } catch (\ar\core\Exception $e) {
                    // todos 异常处理
                    echo $e->getMessage();
                }
            }
        }
    }
}
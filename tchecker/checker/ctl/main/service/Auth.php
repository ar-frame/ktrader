<?php
/**
 * Coop-Auth service.
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
class Auth
{
    protected $db_checker;

    // 主表名称
    const MAIN_TABLENAME = 'tchecker_user';
    // 注册码表
    const REGISTER_CODE_TABLENAME = 'tchecker_registercode';
    // 服务商
    const SERVICE_TABLENAME = 'tchecker_service';
    // 事件日志
    const EVENT_LOG_TABLENAME = 'tchecker_eventlog';

    // 状态
    const REGISTER_CODE_STATUS_MAP = [
        0 => '未使用', 
        1 => '已使用', 
        2 => '作废', 
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
        $this->db_checker = \ar\core\comp('db.mysql')->read('tchecker');
    }

    /**
     * 注册用户
     *
     * @param string  $registerCode 注册码
     * @param string  $mac          mac地址
     * @param string  $pm           手机型号
     * @param string  $uid          uni id
     *
     * @author assnr <ycassnr@gmail.com>
     *
     * @apiname 注册用户
     *
     * @return string
    */
    public function registerCodeUser($registerCode = '', $mac, $pm, $uid = '', $os = '', $isGet = false)
    {
        $errMsg = [
            'errMsg' => '',
        ];
        $mac = strtoupper($mac);

        if (!$registerCode && !$uid) {
            $errMsg = [
                'errMsg' => 'not register for this',
            ];
            return $errMsg;
        }

        if ($uid) {
            $user = $this->db_checker->table(self::MAIN_TABLENAME)->where(['uid' => $uid])->queryRow();
            if (!$user) {
                //$errMsg = [
                    //'errMsg' => '登录信息已失效，请重新激活',
                //];
                //return $errMsg;
                $user = false;
            }
        } else {
            $user = false;
        }

        if (!$user) {
            $user = $this->db_checker->table(self::MAIN_TABLENAME)->where(['mac' => $mac])->queryRow();
        }

        if (!$user) {
            // 注册一个临时用户
            if (strpos($registerCode, "TEMP_") !== false) {
                if ($this->db_checker->table(self::REGISTER_CODE_TABLENAME)->where(['rcode' => $registerCode])->count() == 0) {
                    // 增加一个临时用户
                    $rcode = [
                        'rcode' => $registerCode,
                        'service_name' => 'system',
                        'day' => '888',
                        'status' => 0,
                        'is_vip' => 0,
                        'create_date' => date('Y-m-d H:i:s', time()),
                    ];
                    $this->db_checker->table(self::REGISTER_CODE_TABLENAME)->insert($rcode);
                }
            }
        }
        

        $rcode = $this->db_checker->table(self::REGISTER_CODE_TABLENAME)->where(['rcode' => $registerCode])->queryRow();

        if (!$rcode) {
            // 获取用户信息
            if ($isGet) {
                if ($user) {
                    $rcode = $this->db_checker->table(self::REGISTER_CODE_TABLENAME)->where(['rcode' => $user['last_register_code']])->queryRow();
                }
            }
        }

        if ($registerCode && !$rcode) {
            $errMsg['errMsg'] = 'aa激活码不存在2';
        } else {
            if ($rcode['status'] == 0) {
               
                $expireTimeSec = $rcode['day'] * 24 * 3600;
                
                if (!$user) {
                    # 重新生成用户/mac激活
                    $uid = 'TD2020' . strtoupper(md5(\ar\core\comp('tools.util')->randpw(9, 'CHAR') . $registerCode . md5(time())));

                    $expireTime = time() + $expireTimeSec;
                    $expireDate = date('Y-m-d H:i:s', $expireTime);
                    $addUser = [
                        'mac' => $mac,
                        'service_name' => $rcode['service_name'],
                        'expire_time' => $expireTime,
                        'expire_date' => $expireDate,
                        'last_register_code' => $registerCode,
                        'register_time' => time(),
                        'register_date' => date('Y-m-d H:i:s', time()),
                        'last_login_ip' => \ar\core\comp('tools.util')->getClientIp(),
                        'status' => 1,
                        'pm' => $pm,
                        'os' => $os,
                        'is_vip' => $rcode['is_vip'],
                        'uid' => $uid
                    ];
                    $changeResult = $this->db_checker->table(self::MAIN_TABLENAME)->insert($addUser);
                    $user = $this->db_checker->table(self::MAIN_TABLENAME)->where(['uid' => $uid])->queryRow();
                } else {
                    # 后边升级情况
                    $uid = $user['uid'];

                    $updateUser = [
                        'service_name' => $rcode['service_name'],
                        'last_register_code' => $registerCode,
                        'pm' => $pm,
                        'os' => $os,
                        'last_login_ip' => \ar\core\comp('tools.util')->getClientIp(),
                    ];

                    // 需要升级
                    if ($rcode['is_vip'] == 1) {
                        $updateUser['is_vip'] = 1;
                        // 删除免费用户 
                        $this->db_checker->table(self::REGISTER_CODE_TABLENAME)
                            ->where(['bind_mac' => $user['mac'], 'service_name' => 'system'])
                            ->delete();

                        if ($registerCode != $user['last_register_code']) {
                            if (time() > $user['expire_time'] || $user['is_vip'] == 0) {
                                // 过期，或者未激活/或者免费用户
                                $expireTime = time() + $expireTimeSec;
                            } else {
                                // 新激活
                                $expireTime = $user['expire_time'] + $expireTimeSec;
                            }
                            $expireDate = date('Y-m-d H:i:s', $expireTime);

                            // 增加激活时间
                            $updateUser['expire_time'] = $expireTime;
                            $updateUser['last_register_code'] = $registerCode;
                            $updateUser['expire_date'] = $expireDate;
                        }
                    }

                    if ($user['uid'] != $uid) {
                        $this->addEventLog($pm . $mac . $uid, $pm . $mac . $uid . 'uid比对失败通过mac激活');
                    }

                    $changeResult = $this->db_checker->table(self::MAIN_TABLENAME)->where(['id' => $user['id']])->update($updateUser);
                }

                # 仅激活一次OK
                if ($changeResult || true) {
                    $updateCode = [
                        'status' => 1,
                        'bind_mac' => $mac,
                        'bind_pm' => $pm,
                        'bind_uid' => $uid,
                        'used_time' => time(),
                        'used_date' => date('Y-m-d H:i:s', time()),
                    ];
                    $chargeResult = $this->db_checker->table(self::REGISTER_CODE_TABLENAME)->where(['rcode' => $registerCode])->update($updateCode);
                    if ($chargeResult) {
                        // success
                    } else {
                        $errMsg['errMsg'] = '更新CODE失败';
                    }
                } else {
                    $errMsg['errMsg'] = '更新用户失败';
                }

            } else if ($rcode['status'] == 1) {
                if ($rcode['bind_mac'] == $mac) {
                    // 重装OK 返回客户端使用
                    $uid = $user['uid'];

                    $updateUser = [
                        'service_name' => $rcode['service_name'],
                        'pm' => $pm,
                        'os' => $os,
                        'last_login_ip' => \ar\core\comp('tools.util')->getClientIp(),
                    ];

                    $this->db_checker->table(self::MAIN_TABLENAME)->where(['id' => $user['id']])->update($updateUser);

                } else {
                    if ($isGet == false) {
                        $errMsg['errMsg'] = '激活码已经使用a1';
                    }
                }
                
            } else if ($rcode['status'] == 2) {
                $errMsg['errMsg'] = '激活码已废弃';
            }
        }
        $errMsg['uid'] = isset($user['uid']) ? $user['uid'] : 0;
        if (!$user) {
            $errMsg['is_vip'] = 0;
        } else {
            $errMsg['is_vip'] = $user['is_vip'];
        }
        return $errMsg;
    }

    /**
     * authUser
     *
     * @param string  $mac              mac地址
     * @param string  $lastRegisterCode 最后一次充值码
     *
     * @author assnr <ycassnr@gmail.com>
     *
     * @apiname authUser
     *
     * @return []
    */
    public function authUser($mac, $lastRegisterCode, $uid, $pm)
    {
        $errMsg = [
            'err_msg' => '',
            'check_result' => false,
            'can_use_dayoff' => 0,
            'service_call' => '18502878090',
            'service_info' =>'请先验证激活码',
            'version_name' => '上上策V2',
            'isvip' => 0,
        ];
        
        // 试用
        if ($lastRegisterCode == 'RSJEACVFTMRMJHUC') {
            if ($this->checkIsBrower($pm)) {
                $user = $this->db_checker->table(self::MAIN_TABLENAME)->where(['last_register_code' => $lastRegisterCode])->queryRow();
            } else {
                $errMsg['err_msg'] = 'register_code is not support for this plantform';
                return $errMsg;
            }
        } else {
            $user = $this->db_checker->table(self::MAIN_TABLENAME)->where(['pm' => $pm, 'last_register_code' => $lastRegisterCode])->queryRow();
        }

        if (!$user) {
            $user = $this->db_checker->table(self::MAIN_TABLENAME)->where(['uid' => $uid])->queryRow();
        }
       
        if ($user) {
            if ($user['status'] == 0) {
                $errMsg['err_msg'] = '用户服务已到期';
            } else {
                if ($user['expire_time'] < time()) {
                    $errMsg['err_msg'] = '软件已过期';
                } else {
                    $updateuser = $this->db_checker->table(self::MAIN_TABLENAME)
                        ->where(['id' => $user['id']])
                        ->update([
                                'last_login_date' => date('Y-m-d H:i:s', time()),
                                'last_login_time' => time(),
                                'last_login_ip' => \ar\core\comp('tools.util')->getClientIp(),
                            ]
                        );
                    
                    if ($user['mac'] != strtoupper($mac)) {
                        $this->addEventLog($pm . $mac . $uid, $pm . $mac . $uid . 'mac比对失败通过PM登录');
                    }

                    if ($user['uid'] != $uid) {
                        $this->addEventLog($pm . $mac . $uid, $pm . $mac . $uid . 'uid比对失败通过PM登录');
                    }

                    $service = $this->db_checker->table(self::SERVICE_TABLENAME)->where(['name' => $user['service_name']])->queryRow();

                    $errMsg['service_call'] = $service['phone'];
                    $errMsg['service_info'] = $service['info'];
                    $errMsg['version_name'] = $service['version_name'];

                    $errMsg['check_result'] = true;
                    if ($user['expire_time'] < time()) {
                        $errMsg['can_use_dayoff'] = 0;
                    } else {
                        $haveDay = (int) ( ($user['expire_time'] - time()) / (24 * 3600) );
                        $errMsg['can_use_dayoff'] = $haveDay + 1;
                    }
                }
            }
        } else {
            $errMsg['err_msg'] = '不存在的用户';
        }
        return $errMsg;
    }

     /**
     * checkIsBrower
     *
     * @param string  $pm
     *
     * @author assnr <ycassnr@gmail.com>
     *
     * @apiname checkIsBrower
     *
     * @return string
    */
    public function checkIsBrower($pm)
    {
        $barr = [
            'Chrome', 'Safari', 'KHTML', 'AppleWebKit', 'Mozilla', 'Windows'
        ];
        $isBrower = false;
        foreach ($barr as $bmark) {
            if (strrpos($pm, $bmark) !== false) {
                $isBrower = true;
                break;
            }
        }
        return $isBrower;
    }

    /**
     * genCode
     *
     * @param string  $mac              mac地址
     * @param string  $lastRegisterCode 最后一次充值码
     *
     * @author assnr <ycassnr@gmail.com>
     *
     * @apiname authUser
     *
     * @return string
    */
    public function genCode($count, $serviceName, $day)
    {

        $service = $this->db_checker->table(self::SERVICE_TABLENAME)->where(['name' => $serviceName])->queryRow();
        if (!$service) {
            return 'not found service name';
        } else {
            $hasCount = $this->db_checker->table(self::REGISTER_CODE_TABLENAME)->where(['status' => 0, 'service_name' => $serviceName])->count();
            if ($hasCount >= $count) {
                return 'code enough';
            } else {
                $count = $count - $hasCount;
                $rcodes = [];
                for ($i = 0; $i < $count; $i++) {
                    $rcodes[] = [
                        'rcode' => $this->genCodeNumber(),
                        'service_name' => $serviceName,
                        'day' => $day,
                        'status' => 0,
                        'is_vip' => 1,
                        'create_date' => date('Y-m-d H:i:s', time()),
                    ];
                }
                $this->db_checker->table(self::REGISTER_CODE_TABLENAME)->batchInsert($rcodes);
                return 'exec succ count ' . $count;
            }
        }
    }

    /**
     * genCodeNumber
     *
     * @author assnr <ycassnr@gmail.com>
     *
     * @apiname authUser
     *
     * @return string
    */
    public function genCodeNumber()
    {
        return strtoupper(\ar\core\comp('tools.util')->randpw(16, 'CHAR'));
    }

    /**
     * updateService
     *
     * @author assnr <ycassnr@gmail.com>
     *
     * @apiname authUser
     *
     * @return string
    */
    public function updateService($serviceName, $phone, $info, $versionName)
    {
        $service = $this->db_checker->table(self::SERVICE_TABLENAME)->where(['name' => $serviceName])->queryRow();

        if ($service) {
            $updateService = [
                'phone' => $phone,
                'info' => $info,
                'version_name' => $versionName
            ];
            $this->db_checker->table(self::SERVICE_TABLENAME)->where(['name' => $serviceName])->update($updateService);
        } else {
            $addService = [
                'name' => $serviceName,
                'phone' => $phone,
                'info' => $info,
                'create_date' => date('Y-m-d H:i:s', time()),
                'version_name' => $versionName
            ];
            $this->db_checker->table(self::SERVICE_TABLENAME)->insert($addService);
        }
        return 'updateService success';
    }

    /**
     * addEventLog
     *
     * @author assnr <ycassnr@gmail.com>
     *
     * @apiname addEventLog
     *
     * @return string
    */
    public function addEventLog($bindMark, $content)
    {
        $log = [
            'bind_mark' => $bindMark,
            'content' => $content,
            'add_date' => date('Y-m-d H:i:s', time()),
        ];
        return $this->db_checker->table(self::EVENT_LOG_TABLENAME)->insert($log);
    }
}

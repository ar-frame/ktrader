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
namespace checker\ctl\main;

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
class Checker extends Base
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
    public function init($notCheckAction = ['gateway', 'postReceive'])
    {
        parent::init();

        $action = \ar\core\cfg('requestRoute.a_a');
        if (in_array($action, $notCheckAction)) {
            return;
        } else {
            // check
            // echo 'check some';
        }
        
    }

    /**
     * authUser
     *
     * @param string  $mac mac地址
     * @param string  $lastRegisterCode 最后一次充值码
     * @param string  $uid              uniid
     * @param string  $pm               pm
     *
     * @author assnr <ycassnr@gmail.com>
     *
     * @apiname authUser
     *
     * @return string
    */
    public function authUser($mac, $lastRegisterCode, $uid, $pm)
    {
        \ar\core\service('Auth')->addEventLog($pm . $uid . $mac . $lastRegisterCode, 'authLogin');
        $errMsg = \ar\core\service('Auth')->authUser($mac, $lastRegisterCode, $uid, $pm);
        \ar\core\service('Auth')->addEventLog($pm . $uid . $mac . $lastRegisterCode, 'authLoginResult' . var_export($errMsg, 1));
        $this->showJson($errMsg, ['data' => true]);
    }

    /**
     * 注册用户
     *
     * @param string  $registerCode 注册码
     * @param string  $mac          mac地址
     * @param string  $pm           手机型号
     *
     * @author assnr <ycassnr@gmail.com>
     *
     * @apiname 注册用户
     *
     * @return string
    */
    public function registerCodeUser($registerCode, $mac, $pm, $uid)
    {
\ar\core\comp('tools.log')->record([$registerCode, $mac, $pm, $uid], 'rlog');
        $errMsg = \ar\core\service('Auth')->registerCodeUser($registerCode, $mac, $pm, $uid);
        if ($errMsg['errMsg']) {
            $this->showJsonError($errMsg['errMsg']);
        } else {
            $this->showJsonSuccess('激活成功，请直接登录');
        }
    }
}

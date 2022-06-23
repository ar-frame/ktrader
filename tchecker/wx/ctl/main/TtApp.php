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
class TtApp extends Base
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

    // bytecli -u 1.2.9@d:/hjwx_tt --upload-desc 'upload new release'

    
    /**
     * 抖音上传
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

        $data = [
            'msg' => '',
            'code' => 0,
        ];

        // exec('bytecli -l 18502878090', $output, $return_val); 
        $mobile = \ar\core\request('mobile');
        $code = \ar\core\request('code');

        // $appid = \ar\core\request('code')

        $authData = \ar\core\request();
        $appid = $authData['appid'];
        $api_root = $authData['api_root'];

        \ar\core\comp('tools.log')->record(\ar\core\request(), 'man-tt');

        switch ($opt) {
            case 'login':
                # code...
                $command = 'bytecli -l ' . $mobile;
                exec($command, $return_val);
         
                $return_str = var_export($return_val, 1);
                // var_dump($return_str);
                 

                if (strpos($return_str, '获取验证码成功') !== false) {
                    $data['msg'] = '发送成功';
                } else {
                    $data['msg'] = '发送失败，重复操作或其他';
                    $data['code'] = 500;
                }
                break;
            case 'upload':
                if (\ar\core\comp('cache.file')->get('isupload') == true) {
                    $data['msg'] = '上传进程繁忙，请稍后再试';
                    $data['code'] = 500;
                } else {
                    $updata = [
                        'mobile' => $mobile,
                        'code' => $code,
                    ];
                    \ar\core\comp('cache.file')->set('updata', $updata, 600);
                    \ar\core\comp('cache.file')->set('isupload', true, 600);

                    $dir = 'd:/hjwx_tt';

                    $needUpdateFile1 = $dir . '/' . 'project.config.json';
                    $needUpdateFile2 = $dir . '/' . 'siteinfo.js';

                    $c1 = file_get_contents($needUpdateFile1);
                    $c1 = preg_replace('/"appid": "(\w+)"/i', '"appid": "'. $appid . '"', $c1);

                    $cremoteurl = $authData['cremoteurl'];

                    $c2 = file_get_contents($needUpdateFile2);
                    $c2 = preg_replace('/"apiroot": "(.+)"/i', '"apiroot": "' . $api_root . '"', $c2);

                    file_put_contents($needUpdateFile1, $c1);
                    file_put_contents($needUpdateFile2, $c2);

                    
                    // $command = "bytecli -u 1.2.9@d:/hjwx_tt --upload-desc 'upload new release' &";
                    // $command = "php aw_runner.php";
                    // system($command);
                    // exec($command, $return_val);
                    $data['msg'] = '发送成功，请耐心等待3-6分钟';
                    // if (strpos($return_str, '上传成功') !== false) {
                    //     $data['msg'] = '发送成功，请耐心等待3-6分钟';
                    // } else {
                    //     $data['msg'] = '上传失败，请稍后再试';
                    //     $data['code'] = 500;
                    // }


                    // \ar\core\comp('cache.file')->set('isupload', null);
                }
                
                break;
                
            default:
                # code...
                break;
        }
       

        echo json_encode($data);
        return;
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

        
    }
}

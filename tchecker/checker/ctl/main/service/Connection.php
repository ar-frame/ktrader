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
class Connection
{
    /**
     * 处理请求
     *
     * useage \ar\core\service('Connection')->dispatcherRequest($connection, $data);
     *
     * @param connection  $connection clientConnection
     * @param string      $data       clientData
     *
     * @author assnr <ycassnr@gmail.com>
     *
     * @apiname 处理请求
     *
     * @return void
    */
    public function dispatcherRequest($connection, $data, $pair)
    {
        var_dump('message ', $connection->id . $data);
       
        $jsonData = json_decode($data, 1);
        if (!$jsonData) {
            $loginString = '{"code":"login", "errmsg":"login failed"}';
            $connection->send($loginString);
            $connection->close();
        } else {
            

            switch ($jsonData['code']) {
                case 'login':
                    $loginString = '{"code":"login", "errmsg":""}';
                    $connection->send($loginString);

                    break;
                case 'get_list':
                    $currency = $jsonData['currency'];
                    $records = \ar\core\service('Trader')->records($pair, $currency);
                    $clientData = [
                        'code' => 'get_list',
                        'data' => $records,
                    ];
                    $responseString = json_encode($clientData, 1);
                    $connection->send($responseString);
                    break;

                case 'get_summary':
                    $currency = $jsonData['currency'];
                    $summarys = \ar\core\service('Trader')->getSummary($pair, $currency);
                    $clientData = [
                        'code' => 'get_summary',
                        'data' => $summarys,
                    ];
                    $responseString = json_encode($clientData, 1);
                    $connection->send($responseString);
                break;
            }
          
        }

    }

}
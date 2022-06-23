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
class SyncService extends BaseService
{
    /**
     * 1 summary
     *
     * 客户端调用方式
        try {
            $response = \ar\core\comp('rpc.service')
                ->call('Ws.service.ctl.bestplan.Sync', "summary", [$summary]);
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param string $summary 激活码
     * 
     * @author assn <ycassnr@gmail.com>
     *
     * @apiname summary
     *
     * @return object
     */
    public function summaryWorker($summarys)
    {
        $res = \ar\core\service('service.bestplan.Data')->syncSummery($summarys);
        $this->response($res);
    }

    /**
     * 1 syncRecords
     *
     * 客户端调用方式
        try {
            $response = \ar\core\comp('rpc.service')
                ->call('Ws.service.ctl.bestplan.Sync', "records", [$records]);
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param string $records 
     * 
     * @author assn <ycassnr@gmail.com>
     *
     * @apiname syncRecords
     *
     * @return object
     */
    public function recordsWorker($records)
    {
        $res = \ar\core\service('service.bestplan.Data')->syncRecords($records);
        $this->response($res);
    }

}
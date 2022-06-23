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
class DataService extends BaseService
{

    /**
     * register
     *
     * 客户端调用方式
        try {
            $response = \ar\core\comp('rpc.service')
                ->call('Ws.service.ctl.bestplan.data', "test", [$p1]);
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param string $p1 p1
     *
     * @author assn <ycassnr@gmail.com>
     *
     * @apiname register
     *
     * @return array
     */
    public function addStockWorker($stockName, $stockString)
    {
        $res = \ar\core\service('bestplan.Data')->addStock($stockName, $stockString);
        $this->response($res);
    }

    /**
     * register
     *
     * 客户端调用方式
        try {
            $response = \ar\core\comp('rpc.service')
                ->call('Ws.service.ctl.bestplan.data', "test", [$p1]);
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param string $p1 p1
     *
     * @author assn <ycassnr@gmail.com>
     *
     * @apiname register
     *
     * @return array
     */
    public function addStockBatchWorker($stockName, $stockStringBatch)
    {
        $res = \ar\core\service('bestplan.Data')->addStockBatch($stockName, $stockStringBatch);
        $this->response($res);
    }

    /**
     * getRangedata
     *
     * 客户端调用方式
        try {
            $response = \ar\core\comp('rpc.service')
                ->call('Ws.service.ctl.bestplan.data', "getRangedata", [$stockName, $keystart, $keyend]);
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param string $p1 p1
     *
     * @author assn <ycassnr@gmail.com>
     *
     * @apiname getRangedata
     *
     * @return array
     */
    public function getRangedataWorker($stockName, $keystart, $keyend)
    {
        $res = \ar\core\service('bestplan.Data')->getRangedata($stockName, $keystart, $keyend);
        $this->response($res);
    }

    /**
     * getnewestrow
     *
     * 客户端调用方式
        try {
            $response = \ar\core\comp('rpc.service')
                ->call('Ws.service.ctl.bestplan.data', "getnewestrow", [$stockName]);
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param string $p1 p1
     *
     * @author assn <ycassnr@gmail.com>
     *
     * @apiname getnewestrow
     *
     * @return array
     */
    public function getnewestrowWorker($stockName)
    {
        $res = \ar\core\service('bestplan.Data')->getnewestrow($stockName);
        $this->response($res);
    }

    /**
     * updateTuiList
     *
     * 客户端调用方式
        try {
            $response = \ar\core\comp('rpc.service')
                ->call('Ws.service.ctl.bestplan.data', "updateTuiList", [$stockName, $opt, $timesep, $kindex, $ema, $ctime]);
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param string $p1 p1
     *
     * @author assn <ycassnr@gmail.com>
     *
     * @apiname updateTuiList
     *
     * @return array
     */
    public function updateTuiListWorker($stockName, $opt, $timesep, $kindex, $ema, $ctime, $cprice)
    {
        $errMsg = [
            'errMsg' => '',
        ];
        $res = \ar\core\service('bestplan.Data')->updateTuiList($stockName, $opt, $timesep, $kindex, $ema, $ctime, $cprice);
        $errMsg['res'] = $res;
        $this->response($errMsg);
    }

    /**
     * updateStockPrice
     *
     * 客户端调用方式
        try {
            $response = \ar\core\comp('rpc.service')
                ->call('Ws.service.ctl.bestplan.data', "updateStockPrice", [$stockName, $cprice, $realname]);
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param string $stockName stockName
     * @param string $cprice    cprice
     *
     * @author assn <ycassnr@gmail.com>
     *
     * @apiname updateStockPrice
     *
     * @return array
     */
    public function updateStockPriceWorker($stockName, $cprice, $realname)
    {
        $errMsg = [
            'errMsg' => '',
        ];
        $res = \ar\core\service('bestplan.Data')->updateStockPrice($stockName, $cprice, $realname);
        $errMsg['res'] = $res;
        $this->response($errMsg);
    }

    /**
     * testClientRecv
     *
     * 客户端调用方式
        try {
            $response = \ar\core\comp('rpc.service')
                ->call('Ws.service.ctl.bestplan.data', "testClientRecv", ['haha !!']);
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param string $helloString helloString
     *
     * @author assn <ycassnr@gmail.com>
     *
     * @apiname testClientRecv
     *
     * @return string
     */
    public function testClientRecvWorker($helloString)
    {
        $this->response('string back: ' . $helloString);
    }


    /**
     * pushPaintRecord
     *
     * 客户端调用方式
        try {
            $response = \ar\core\comp('rpc.service')
                ->call('Ws.service.ctl.bestplan.data', "pushPaintRecord", [$pair, $timeSep, $commandParams, $resultStr]);
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param string $pair          pair
     * @param string $timeSep       timeSep
     * @param string $commandParams commandParams
     * @param string $resultStr     resultStr
     *
     * @author assn <ycassnr@gmail.com>
     *
     * @apiname pushPaintRecord
     *
     * @return object
     */
    public function pushPaintRecordWorker($pair, $timeSep, $commandParams, $resultStr)
    {
        $res = \ar\core\service('service.bestplan.Data')->pushPaintRecord($pair, $timeSep, $commandParams, $resultStr);
        $this->response(['resmsg' => 'add succ', 'insertid' => $res]);

    }

}
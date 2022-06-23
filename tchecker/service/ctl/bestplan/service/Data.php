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
namespace service\ctl\bestplan\service;

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
class Data
{
    /**
     * 处理请求
     *
     * useage \ar\core\service('bestplan.Data')->getDb($stockName);
     *
     * @param string $stockName stockName
     *
     * @author assnr <ycassnr@gmail.com>
     *
     * @apiname 处理请求
     *
     * @return void
    */
    public function getDb($stockName)
    {
        $res = \ar\core\comp('db.mysql')->read('stock')->sqlQuery("SHOW TABLES LIKE '%" . $stockName . "%';");
        if (!$res) {
            $createsql = "CREATE TABLE `{$stockName}` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `stock_name` varchar(255) NOT NULL,
              `em` varchar(255) NOT NULL,
              `price` varchar(255) NOT NULL,
              `cprice` decimal(10,2) NOT NULL,
              `kindex` varchar(255) NOT NULL,
              `ksep` varchar(255) NOT NULL,
              `daterange` varchar(255) NOT NULL,
              `up` varchar(255) NOT NULL,
              `type` varchar(255) NOT NULL,
              `down` bigint(255) NOT NULL,
              `fromtimedate` bigint(255) NOT NULL,
              `endtimedate` bigint(20) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8";

            \ar\core\comp('db.mysql')->read('stock')->sqlExec($createsql);

        }

        return \ar\core\comp('db.mysql')->read('stock')->table($stockName);
    }

    /**
     * 处理请求
     *
     * useage \ar\core\service('bestplan.Data')->getDb($stockName);
     *
     * @param string $stockName stockName
     *
     * @author assnr <ycassnr@gmail.com>
     *
     * @apiname 处理请求
     *
     * @return void
    */
    public function getRecordDb()
    {
        $res = \ar\core\comp('db.mysql')->read('stock_count')->sqlQuery("SHOW TABLES LIKE '%record%';");
        if (!$res) {
            $createsql = "CREATE TABLE `record` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `opt` varchar(255) NOT NULL,
  `timesep` varchar(255) NOT NULL,
  `kindex` varchar(255) NOT NULL,
  `ema` varchar(255) NOT NULL,
  `ctime` varchar(255) NOT NULL,
  `cprice` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";
            \ar\core\comp('db.mysql')->read('stock_count')->sqlExec($createsql);

        }
        return \ar\core\comp('db.mysql')->read('stock_count')->table('record');
    }


    /**
     * 处理请求
     *
     * useage \ar\core\service('bestplan.Data')->getDb($stockName);
     *
     * @param string $stockName stockName
     *
     * @author assnr <ycassnr@gmail.com>
     *
     * @apiname 处理请求
     *
     * @return void
    */
    public function getPriceDb()
    {
        $res = \ar\core\comp('db.mysql')->read('stock_count')->sqlQuery("SHOW TABLES LIKE '%price%';");
        if (!$res) {
            $createsql = "CREATE TABLE `price` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `realname` varchar(255) NOT NULL,
  `ctime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

";
            \ar\core\comp('db.mysql')->read('stock_count')->sqlExec($createsql);

        }
        return \ar\core\comp('db.mysql')->read('stock_count')->table('price');
    }





    /**
     * addStock
     *
     * 客户端调用方式
       useage \ar\core\service('bestplan.Data')->addStock($stockName, $stockString);
     *
     * @param string $stockName   stockName
     * @param string $stockString stockString
     *
     * @author assn <ycassnr@gmail.com>
     *
     * @apiname addStock
     *
     * @return array
     */
    public function addStock($stockName, $stockString, $batch = false)
    {
        $errMsg = [
            'errMsg' => '',
            'ret' => 0,
        ];
        $db = $this->getDb($stockName);
        // $stockString = '19.6818104888,6.46^6.51,2318,13,201905231326-201905231339,19.6818104888,UP,0#19.6818104888,6.46^6.51,2318,13,201905231326-201906231339,19.6818104888,UP,0';
        if ($batch == true) {

            $stockStringArr = explode("#", $stockString);
            // var_dump($stockStringArr);
            $batchInsterData = [];

            for ($i = 0; $i < count($stockStringArr); $i++) {
                $stockString = $stockStringArr[$i];

                $charr = explode(',', $stockString);
                if (count($charr) != 8) {
                    $errMsg['errMsg'] = '数据格式错误';
                } else {
                    list($em, $price, $kindex, $ksep, $daterange, $up, $type, $down) = explode(',', $stockString);
                    list($fromtimedate, $endtimedate) = explode('-', $daterange);

                    // $db->table($stockName);
                    // $db->where(['fromtimedate' => $fromtimedate, 'endtimedate' => $endtimedate])->count()
                    if (1 < 0) {
                        // $errMsg['errMsg'] = '已存在的数据';
                        continue;
                    } else {
                        if (strpos($price, "^") !== false) {
                            $cprice = substr($price, strpos($price, "^") + 1);
                        } else {
                            $cprice = substr($price, strpos($price, "v") + 1);
                        }
                        $insertData = [
                            'em' => $em,
                            'price' => $price,
                            'kindex' => $kindex,
                            'ksep' => $ksep,
                            'daterange' => $daterange,
                            'up' => $up,
                            'type' => $type,
                            'down' => $down,
                            'cprice' => $cprice,
                            'stock_name' => $stockName,
                            'fromtimedate' => $fromtimedate,
                            'endtimedate' => $endtimedate,
                        ];
                        $batchInsterData[] = $insertData;
                    }
                }
            }

            if ($batchInsterData) {
                $db->table($stockName);
                $errMsg['ret'] = $db->batchInsert($batchInsterData);
            } else {
                $errMsg['errMsg'] = '批量数据为空';
            }

        } else {
            $charr = explode(',', $stockString);
            if (count($charr) != 8) {
                $errMsg['errMsg'] = '数据格式错误';
            } else {
                list($em, $price, $kindex, $ksep, $daterange, $up, $type, $down) = explode(',', $stockString);
                list($fromtimedate, $endtimedate) = explode('-', $daterange);
                if ($db->where(['fromtimedate' => $fromtimedate, 'endtimedate' => $endtimedate])->count() > 0) {
                    $errMsg['errMsg'] = '已存在的数据';
                } else {
                    if (strpos($price, "^") !== false) {
                        $cprice = substr($price, strpos($price, "^") + 1);
                    } else {
                        $cprice = substr($price, strpos($price, "v") + 1);
                    }
                    $insertData = [
                        'em' => $em,
                        'price' => $price,
                        'kindex' => $kindex,
                        'ksep' => $ksep,
                        'daterange' => $daterange,
                        'up' => $up,
                        'type' => $type,
                        'down' => $down,
                        'cprice' => $cprice,
                        'stock_name' => $stockName,
                        'fromtimedate' => $fromtimedate,
                        'endtimedate' => $endtimedate,
                    ];
                    $db->table($stockName);
                    $errMsg['ret'] = $db->insert($insertData);
                }
            }
        }
        return $errMsg;
    }


    /**
     * addStock
     *
     * 客户端调用方式
       useage \ar\core\service('bestplan.Data')->addStockBatch($stockName, $stockString);
     *
     * @param string $stockName   stockName
     * @param string $stockString stockString
     *
     * @author assn <ycassnr@gmail.com>
     *
     * @apiname addStock
     *
     * @return array
     */
    public function addStockBatch($stockName, $stockString)
    {
        return \ar\core\service('bestplan.Data')->addStock($stockName, $stockString, true);
    }

    /**
     * getRangedata
     *
     * 客户端调用方式
        useage \ar\core\service('bestplan.Data')->getRangedata($stockName, $keystart, $keyend);
     *
     * @param string $p1 p1
     *
     * @author assn <ycassnr@gmail.com>
     *
     * @apiname getRangedata
     *
     * @return array
     */
    public function getRangedata($stockName, $keystart, $keyend)
    {
        $db = $this->getDb($stockName);
        $con = [
            'endtimedate >=' => $keystart,
            'endtimedate <=' => $keyend,
        ];
        $columns = [
            'em',
            'daterange',
            'ksep',
            'price',
            'endtimedate',
            'type'
        ];
        $res = $db->where($con)->select($columns)->order('endtimedate asc')->queryAll();
        if (!$res) {
            $res = [];
        }
        return $res;
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
    public function getnewestrow($stockName)
    {
        $db = $this->getDb($stockName);
        $res = $db->order('endtimedate desc')->queryRow();
        if (!$res) {
            $res = ['errMsg' => '数据为空'];
        }
        return $res;
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
    public function updateTuiList($stockName, $opt, $timesep, $kindex, $ema, $ctime, $cprice)
    {
        $db = $this->getRecordDb();
        $record = [
            'name' => $stockName,
            'opt' => $opt,
            'timesep' => $timesep,
            'kindex' => $kindex,
            'ema' => $ema,
            'ctime' => $ctime,
            'cprice' => $cprice
        ];

        if ($db->where($record)->count() == 0) {
            $db->table('record');
            $res = $db->insert($record);
        }

        return true;
    }

    /**
     * updateStockPrice
     *
     * 客户端调用方式
        try {
            $response = \ar\core\comp('rpc.service')
                ->call('Ws.service.ctl.bestplan.data', "updateStockPrice", [$stockName, $cprice]);
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
    public function updateStockPrice($stockName, $cprice, $realname)
    {

        $db = $this->getPriceDb();

        $wprice = [
            'name' => $stockName,
        ];
        $price = [
            'name' => $stockName,
            'price' => $cprice,
            'realname' => $realname,
            'ctime' => time(),
        ];
        if ($db->where($wprice)->count() > 0) {
            $db->table('price');
            $db->where($wprice)->update($price);
        } else {
            $db->table('price');
            $db->where($wprice)->insert($price);
        }

        return true;
    }

    public function syncSummery($summarys)
    {
        if (isset($summarys['code'])) {
            $summarys = [$summarys];
        }

        foreach ($summarys as $key => $summary) {

            $code = $summary['code'];

            $row = \service\lib\model\stock\StockSummary::model()
                ->getDb()
                ->where(['code' => $code])
                ->queryRow();
            if ($row) {
                \service\lib\model\stock\StockSummary::model()
                    ->getDb()
                    ->where(['id' => $row['id']])
                    ->update($summary, 1);
            } else {
                \service\lib\model\stock\StockSummary::model()
                    ->getDb()
                    ->insert($summary, 1);
            }
        }

        return true;
    }

    public function syncRecords($records)
    {
        \service\lib\model\stock\StockRecords::model()
            ->getDb()
            ->where(['id > ' => 0])
            ->delete();


        \service\lib\model\stock\StockRecords::model()
            ->getDb()
            ->batchInsert($records);

        return true;
    }

    /**
     * pushPaintRecord
     *
     * 客户端调用方式
       useage \ar\core\service('service.bestplan.Data')->pushPaintRecord($pair, $timeSep, $commandParams, $resultStr);
     *
     */
    public function pushPaintRecord($pair, $timeSep, $commandParams, $resultStr)
    {
        $db = \ar\core\comp('db.mysql')->read('tchecker_paint');
        $record = [
            'pair' => $pair,
            'addtime' => time(),
            'time_sep' => $timeSep,
            'command_params' => $commandParams,
            'result_str' => $resultStr,
        ];
        return $db->table('records')->insert($record);
    }

}

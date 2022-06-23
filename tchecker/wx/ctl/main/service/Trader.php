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
class Trader
{
    // 数据库句柄
    protected $db_trader;

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
    }

    /**
     * records
     *
     * useage \ar\core\service('Trader')->records('ETH-USDT', 200);
     * 
     * @param string $tradePair    交易对
     * @param float  $initUsdtUint 初识计算金额
     *
     * @author assnr <ycassnr@gmail.com>
     *
     * @apiname records
     *
     * @return []
    */
    public function records($tradePair, $initUsdtUint)
    {
        $firstGetRowCount = 128;
        $maxGetRowCount = 168;

        $lastRow = $this->db_trader->table('record_' . $tradePair)->limit(1)->order('id desc')->queryRow();

        $realGetRowCount = $firstGetRowCount;

        $cacheKey = 'lastRow' . $tradePair;
        $cacheLastRow = \ar\core\comp('cache.file')->get($cacheKey);
        if ($cacheLastRow) {
            if ($cacheLastRow['id'] == $lastRow['id']) {
                $realGetRowCount = $firstGetRowCount;
            } else if ($cacheLastRow['id'] < $lastRow['id']) {
                $realGetRowCount = $firstGetRowCount + ($lastRow['id'] - $cacheLastRow['id']);
                if ($realGetRowCount > $maxGetRowCount) {
                    $realGetRowCount = $firstGetRowCount;
                    \ar\core\comp('cache.file')->set($cacheKey, $lastRow);
                }
            }
        } else {
            \ar\core\comp('cache.file')->set($cacheKey, $lastRow);
        }

        $lists = $this->db_trader->table('record_' . $tradePair)->limit($realGetRowCount)->order('id desc')->queryAll();
        $lists = array_reverse($lists);

        foreach ($lists as $key => $list) {
            if ($key == 0) {
                $lists[$key]['level'] = 0;
            } else {
                if ($lists[$key]['type'] == $lists[$key - 1]['type']) {
                    $lists[$key]['level'] = $lists[$key - 1]['level'] + 1;
                } else {
                    $lists[$key]['level'] = 0;
                }
            }
            $lists[$key]['currency'] = \ar\core\service('Trader')->getLevelPrice($lists[$key]['level'], $initUsdtUint);
            $lists[$key]['pair'] = $tradePair;
        }
        return $lists;
    }

    /**
     * getLevelPrice
     *
     * useage \ar\core\service('Trader')->getLevelPrice(2, 100);
     * 
     * @param int   $level        级别
     * @param float $initUsdtUint 初识计算金额
     *
     * @author assnr <ycassnr@gmail.com>
     *
     * @apiname getLevelPrice
     *
     * @return float
    */
    public function getLevelPrice($level, $initUsdtUint)
    {
        $price = 0;
        if ($level == 0) {
            $price = $initUsdtUint;
        } else {
            $maxLevel = 8;
            if ($level > $maxLevel) {
                $level = 8;
            }
            $rel = 1 + ($level - 1) * ($level * 1 / $maxLevel);
            $price = $initUsdtUint + $level * ($rel * $initUsdtUint / $maxLevel);
        }
        return $price;
    }

    /**
     * getSummary
     *
     * useage \ar\core\service('Trader')->getSummary(2, 100);
     * 
     * @param string $tradePair    交易对
     * @param float  $initUsdtUint 初识计算金额
     *
     * @author assnr <ycassnr@gmail.com>
     *
     * @apiname getSummary
     *
     * @return float
    */
    public function getSummary($tradePair, $initUsdtUint)
    {
        $lists = \ar\core\service('Trader')->records($tradePair, $initUsdtUint);
        $tradeObj = [];
        $tradeObj['maxStore'] = 0;
        $tradeObj['transferRate'] = 0;
        $tradeObj['profit'] = 0;
        $tradeObj['orderCount'] = 0;
        $tradeObj['orderBuyCount'] = 0;
        $tradeObj['orderSellCount'] = 0;
        $tradeObj['cprice'] = 0;
        $tradeObj['summary'] = "";
        
        $tradeObj['unit'] = $initUsdtUint;

        $price = \ar\core\service('Trader')->getPrice($tradePair);

        $Ebpc = $Espc = $Ebc = $Esc = $orderSellCount = $orderBuyCount = 0;

        for ($i = 0; $i < count($lists); $i++) {
            $dfrow = $lists[$i];
            if ($dfrow['type'] == 'buy') {
                $orderBuyCount += 1;
                $Ebpc = $Ebpc + $dfrow['currency'] / $dfrow['price'];
                $Ebc = $Ebc + $dfrow['currency'];
            } else {
                $orderSellCount += 1;
                $Espc = $Espc + $dfrow['currency'] / $dfrow['price'];
                $Esc = $Esc + $dfrow['currency'];
            }
        }

        $Eamount = abs($Ebpc + (-$Espc));
        $Ecostusd = abs($Ebc - $Esc);

        $Eshow = '';
        if ($Ebc - $Esc > 0) {
            $Eshow = sprintf("多单:数量{%.2f}，金额{%.2f}，成本价{%.2f}", $Eamount, $Ebc - $Esc, ($Ebc - $Esc) / $Eamount);
            $pf = ($price - ($Ebc - $Esc) / $Eamount) * $Eamount;

            $r_transfer = $pf / ($Ebc - $Esc);

        } elseif ($Ebc - $Esc == 0) {
            $Eshow = "空仓:数量0，金额0，成本价0";
            $pf = 0;
            $r_transfer = 0;
        } else {
            $Eshow = sprintf("空单:数量{%.2f}，金额{%.2f}，成本价{%.2f}", $Eamount, $Esc - $Ebc, ($Esc - $Ebc) / $Eamount);
            $pf = (($Esc - $Ebc) / $Eamount - $price) * $Eamount;
            $r_transfer = $pf / ($Esc - $Ebc);
        }

        if (abs($orderBuyCount - $orderSellCount) < 4) {
            $Eshow = '已平仓:建议空仓等待机会';
            $pf = 0;
            $r_transfer = 0;
        }
        
        $tradeObj['transferRate'] = sprintf("%.2f", ($r_transfer * 100));
        $tradeObj['profit'] = sprintf("%.2f", $pf);
        $tradeObj['orderCount'] = count($lists);

        $tradeObj['orderBuyCount'] = $orderBuyCount;
        $tradeObj['orderSellCount'] = $orderSellCount;
        $tradeObj['cprice'] = $price;
        $tradeObj['summary'] = $Eshow;
        return $tradeObj;
    }

    /**
     * getPrice
     *
     * useage \ar\core\service('Trader')->getPrice($pair);
     * 
     * @param string $pair 交易对
     *
     * @author assnr <ycassnr@gmail.com>
     *
     * @apiname getSummary
     *
     * @return float
    */
    public function getPrice($pair)
    {
        $lastRow = $this->db_trader->table('price_' . $pair)->limit(1)->order('id desc')->queryRow();
        return $lastRow['price'];
    }

    /**
     * clearCache
     *
     * useage \ar\core\service('Trader')->clearAllCache();
     * 
     * @param string $pair    交易对
     *
     * @author assnr <ycassnr@gmail.com>
     *
     * @apiname getSummary
     *
     * @return float
    */
    public function clearAllCache()
    {
        \ar\core\comp('cache.file')->flush(true);
    }

}
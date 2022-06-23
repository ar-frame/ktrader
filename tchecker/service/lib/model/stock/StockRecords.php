<?php
/**
 * Coop.
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
namespace service\lib\model\stock;
/**
 * 团队
 *
 * @category  PHP
 * @package   CDC-ORI-TEAM
 * @author    ycassnr <ycassnr@gmail.com>
 * @copyright 2012-2018 成都成达传网络科技-COOP Technology GP
 * @license   http://www.coopcoder.com/licence ar licence 5.1
 * @version   Release: @靠谱云开发@
 * @link      http://www.coopcoder.com
 */
class StockRecords extends \ar\core\Model
{
    // set db
    public function getDb($dbType = 'mysql', $dbString = 'tchecker', $read = true)
    {
        return parent::getDb($dbType, $dbString, $read);
    }

    public $tableName = 'stock_records';

}

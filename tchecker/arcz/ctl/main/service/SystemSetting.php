<?php
/**
 * Powerd by ArPHP.
 *
 * SystemSetting service.
 *
 */
namespace arcz\ctl\main\service;
use arcz\lib\model\AdminGroupFunc;
use arcz\lib\model\ModelList as modelListModel;
use arcz\lib\model\ModelList;
use arcz\lib\model\ModelDetail;
use arcz\lib\model\ModelFK;
use arcz\lib\model\ModelMenuFunc;

define('COOP_SYSTEM', dirname(dirname(dirname(dirname(dirname(__FILE__))))));
/**
 * 用户服务组件
 */
class SystemSetting
{
    // seesion 组件
    protected $_seesion = null;

    function __construct() {
        $this->_session = \ar\core\comp('lists.session');
    }


}

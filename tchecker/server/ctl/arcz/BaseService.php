<?php
/**
 * Powerd by ArPHP.
 *
 * default Controller.
 *
 */
namespace server\ctl\arcz;
use \ar\core\ApiController as Controller;
/**
 * Default Controller of webapp.
 */
class BaseService extends \ar\core\HttpService
{
    protected $arczdb;
    public $connectUserAccount;

    public function init($data)
    {
        parent::init($data);
        header('Access-Control-Allow-Origin:*');
        
        // \ar\core\comp('tools.log')->record($data, 'initdata');

        // 初始化连接
        $this->arczdb = \ar\core\comp('db.mysql')->read('default');
    }

    /**
     * 获取创建表数据
     *
     * <pre>
        --主要字段说明
      
        --
    </pre>
     *
     * 客户端调用方式
        try {
            // 接口名称
            $apiname = 'Ws'.'server.ctl.arcz.Base';
            $res = \ar\core\comp('rpc.service')->$apiname("getTableInfo",array ($serverName));
            // todo $res
            // var_dump($res);
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }
     *
     * @param  string $serverName 服务名称
     * 
     * @author jkirlt <jkirlt666@gmail.com>
     *
     * @apiname 获取创建表数据
     *
     * @return void
     */
    public function getTableInfoWorker($serverName)
    {
        $info = \ar\core\service($serverName)->getTableInfo();
        $this->response($info);
    }


}
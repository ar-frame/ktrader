<?php
/**
 * Powerd by ArPHP.
 *
 * default Controller.
 *
 */
namespace service\ctl\bestplan;
use \ar\core\ApiController as Controller;
/**
 * Default Controller of webapp.
 */
class BaseService extends \ar\core\HttpService
{
    protected $coopdb;
    public $connectUserAccount;

    // 连接Db
    public function init($data)
    {
        parent::init($data);
        header('Access-Control-Allow-Origin:*');

        $this->connectUserAccount = [];
        if (isset($data['authSign']['USER_AUTH_KEY'])) {
            $uk = $data['authSign']['USER_AUTH_KEY'];
            // if (isset($data['authSign']['USER_ACCESS_TOKEN'])) {
            //     $access_token = $data['authSign']['USER_ACCESS_TOKEN'];
            //     // 保存临时认证
            //     \ar\core\service('coop.Session')->setAccessToken($access_token);
            // }
            // $this->connectUserAccount = \ar\core\service('wallet.WalletCD')->getUserAccountByUk($uk);
        }

        // 初始化连接
        // $this->coopdb = \ar\core\comp('db.mysql')->read('coop');
    }
}

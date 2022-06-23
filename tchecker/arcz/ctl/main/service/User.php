<?php
/**
 * Powerd by ArPHP.
 *
 * User service.
 *
 */
namespace arcz\ctl\main\service;
use arcz\lib\model\AdminDeveloper;
use arcz\lib\model\AdminUser as UserModel;
use arcz\lib\model\AdminGroup as RoleModel;
use arcz\lib\model\AdminNav as NavModel;
use arcz\lib\model\AdminUserGroup as UserRoleModel;
use arcz\lib\model\AdminGroupNav as RoleNavModel;

/**
 * 系统管理员服务组件
 */
class User
{
    // seesion 组件
    protected $_seesion = null;

    function __construct() {
        $this->_session = \ar\core\comp('lists.session');
    }

    // 设置uk
    public function setUK($uk)
    {
        \ar\core\comp('lists.session')->set('ukey' , $uk);
        return true;
    }

    // 获取uk
    public function getUK()
    {
        return \ar\core\comp('lists.session')->get('ukey');
    }

    // 清除uk
    public function cleanUK()
    {
        \ar\core\comp('lists.session')->set('ukey' , false);
        return true;
    }

    // 生成登陆验证码
    public function generateCode()
    {
        $_vc = new \arcz\lib\ext\ValidateCode();
        $_vc->doimg();
        $code = $_vc->getCode();// 验证码保存到SESSION中
        // $code = \ar\core\comp('tools.util')->randpw(4, 'NUMBER');
        $this->_session->set('code', $code);
    }

    // 获取验证码
    public function getCode()
    {
        return $this->_session->get('code');
    }








}

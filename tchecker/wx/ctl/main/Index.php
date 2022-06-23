<?php
/**
 * Powerd by ArPHP.
 *
 * default Controller.
 *
 */
namespace wx\ctl\main;
use \ar\core\Controller as Controller;
/**
 * Default Controller of webapp.
 */
class Index extends Controller
{
    /**
     * just the example of get contents.
     *
     * @return void
     */
    public function index()
    {
        // 调用本地服务组件
        // $this->getTestService()->myTestFunc();
        $this->assign(["welcomeTitle" => "hello arphp"]);
        $this->display();

    }

}

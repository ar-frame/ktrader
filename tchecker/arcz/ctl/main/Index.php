<?php
/**
 * 前端基于layuicms2.0 ，后端基于arphp 5.1.14
 *
 * @author assnr assnr@coopcoder.com
 *
 * 本项目仅供学习交流使用，如果用于商业请联系授权
 */
namespace arcz\ctl\main;
use \ar\core\Controller as Controller;

/**
 * 默认入口控制器
 */
class Index extends Base
{
    // 后台首页
    public function index()
    {
        $this->display('/index');
    }
}

<?php
/**
 * Powerd by ArPHP.
 *
 * default Controller.
 *
 */
namespace web\ctl\main;
use \ar\core\Controller as Controller;
/**
 * Default Controller of webapp.
 */
class Index extends Controller
{
     /**
     * 初始化方法
     *
     * @return void
     */
    public function init()
    {
        $pageinfo = [
            'download' => '软件下载',
            'readhelp' => '帮助中心',
            'home' => '产品介绍',
            'price' => '套餐价格',
            'shares' => '股票',
            'reportDetails' => '股票详情',
            'history' => '历史数据',
        ];
        $action = \ar\core\cfg('requestRoute.a_a');
        $this->assign(['action_title_page_name' => $pageinfo[$action]]);
    }

    /**
     * 下载
     *
     * @return void
     */
    public function download()
    {
        $this->display();
    }

    /**
     * 帮助
     *
     * @return void
     */
    public function readhelp()
    {
        $this->display();
    }

    /**
     * 主页
     *
     * @return void
     */
    public function home()
    {
        $this->display();
    }

    /**
     * 价格
     *
     * @return void
     */
    public function price()
    {
        $this->display();
    }
    /**
         * 股票
         *
         * @return void
         */
    public function shares()
    {
            $this->display();
    }

      /**
             * 研报详情
             *
             * @return void
             */
        public function reportDetails()
        {
                $this->display();
        }
         /**
                     *历史数据
                     *
                     * @return void
                     */
                public function history()
                {
                        $this->display();
                }

}

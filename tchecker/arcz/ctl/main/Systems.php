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
 * 控制器
 */
class Systems extends Base
{

    // 菜单列表
    public function menuList()
    {
        // 获取uk
        $uk = $this->getUserService()->getUk();
        // 判断当前管理员是否为开发者
        try {
            $apiname = 'Ws'.'server.ctl.arcz.Specialized';
            $isDev = \ar\core\comp('rpc.service')->$apiname("loginUserIsDev",array ($uk));
            if($isDev){
                $href = 'systems/menuList';
                // 标题信息
                $apinameNav = 'Ws'.'server.ctl.arcz.Nav';
                $menuTitle = \ar\core\comp('rpc.service')->$apinameNav("getNavTitle", array(2, $href));
                // 数据获取
                $navlists = \ar\core\comp('rpc.service')->$apinameNav("navslist", array());

                foreach($navlists['navs'] as &$r){
                    if($r['cate']==2){
                        $r['title'] = '-' . $r['title'];
                    } else if($r['cate']==3){
                        $r['title'] = '- -' . $r['title'];
                    }
                }

                $this->assign(['menuTitle' => $menuTitle]);
                $this->assign(['navlists' => $navlists['navs']]);
                $this->display('/systemSetting/menuList');
            } else {
                $this->display('/404');
            }
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }

    }

    // 数据库表
    public function tableList($db='')
    {
        // 获取uk
        $uk = $this->getUserService()->getUk();
        // 判断当前管理员是否为开发者
        try {
            $apiname = 'Ws'.'server.ctl.arcz.Specialized';
            $isDev = \ar\core\comp('rpc.service')->$apiname("loginUserIsDev",array ($uk));
            if($isDev){
                $href = 'systems/tableList';
                $apinameNav = 'Ws'.'server.ctl.arcz.Nav';
                $menuTitle = \ar\core\comp('rpc.service')->$apinameNav("getNavTitle", array(2, $href));

                // 数据库
                $apinameData = 'Ws'.'server.ctl.arcz.DBModel';
                $allDataBaseLists = \ar\core\comp('rpc.service')->$apinameData("getDbLists", array());
                $defaultTable = $allDataBaseLists[0];
                if($db==''){
                    $dbConfig = ['db' => $defaultTable];
                } else {
                    $dbConfig = ['db' => $db];
                }

                // 数据表
                $tableLists = \ar\core\comp('rpc.service')->$apinameData("tableLists", array($dbConfig));
                $tables = $tableLists['tableLists'];

                $this->assign(['tables' => $tables]);
                $this->assign(['menuTitle' => $menuTitle]);
                $this->assign(['db' => $db]);
                $this->assign(['allDataBaseLists' => $allDataBaseLists, 'defaultTable' => $defaultTable]);
                $this->display('/systemSetting/tableList');
            } else {
                $this->display('/404');
            }
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }

    }

    // 模型表
    public function modelList($count = 20, $page = 1, $search_col = 'modelname', $keyword = '', $sort_col = 'id', $sort_type = 'desc')
    {
        // 获取uk
        $uk = $this->getUserService()->getUk();
        // 判断当前管理员是否为开发者
        try {
            $apiname = 'Ws'.'server.ctl.arcz.Specialized';
            $isDev = \ar\core\comp('rpc.service')->$apiname("loginUserIsDev",array ($uk));
            if($isDev){
                $href = 'systems/modelList';
                $apinameNav = 'Ws'.'server.ctl.arcz.Nav';
                $menuTitle = \ar\core\comp('rpc.service')->$apinameNav("getNavTitle", array(2, $href));

                // 数据获取
                $apinameData = 'Ws'.'server.ctl.arcz.DBModel';
                $res = \ar\core\comp('rpc.service')->$apinameData("getModelList", array($uk, $count, $page, $search_col, $keyword, $sort_col, $sort_type));

                $href = AR_SERVER_PATH . $href;

                $arrSearch = [
                    'modelname' => '模型名',
                    'tablename' => '数据表名',
                    'dbname' => '数据库名',
                    'menu_name' => '菜单名称'
                ];
                $arrSort = [
                    'id' => 'id',
                    'modelname' => '模型名',
                    'tablename' => '数据表名',
                    'dbname' => '数据库名',
                    'menu_name' => '菜单名称'
                ];

                $headForm = $this->getPageService()->headForm($arrSearch, $arrSort, $search_col, $sort_col);
                $pageShow = $this->getPageService()->pageShow($res['totalPages'], $href, $count, $page, $search_col, $keyword, $sort_col, $sort_type);

                $this->assign(['menuTitle' => $menuTitle]);
                $this->assign(['modelLists' => $res['modelLists'], 'totalCount' => $res['totalCount'], 'totalPages' => $res['totalPages']]);
                $this->assign(['count' => $count, 'page' => $page, 'search_col' => $search_col, 'keyword' => $keyword, 'sort_col' => $sort_col, 'sort_type' => $sort_type]);
                $this->assign(['headForm' => $headForm, 'pageShow' => $pageShow]);
                $this->display('/systemSetting/modelList');
            } else {
                $this->display('/404');
            }
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }

    }

    // 系统参数设置
    public function setSystem()
    {
        // 获取uk
        $uk = $this->getUserService()->getUk();
        // 页面地址
        $href = "systems/setSystem";
        // 判断当前管理员是否能访问
        try {
            $apiname = 'Ws'.'server.ctl.arcz.Specialized';
            $isQuery = \ar\core\comp('rpc.service')->$apiname("queryMenuByHref",array ($href, $uk));
            if($isQuery){
                $apinameNav = 'Ws'.'server.ctl.arcz.Nav';
                $menuTitle = \ar\core\comp('rpc.service')->$apinameNav("getNavTitle", array(2, $href));
                // 系统信息
                $apinameSys = 'Ws'.'server.ctl.arcz.Index';
                $systemInfo = \ar\core\comp('rpc.service')->$apinameSys("systemSetting", array());

                $this->assign(['menuTitle' => $menuTitle]);
                $this->assign(['sysInfo' => $systemInfo]);
                $this->display('/systemSetting/setSystem');
            } else {
                $this->display('/404');
            }
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }

    }

    // 管理员操作日志列表
    public function adminLogList($count = 20, $page = 1, $search_col = '', $keyword = '', $sort_col = 'id', $sort_type = 'desc')
    {
        // 获取uk
        $uk = $this->getUserService()->getUk();
        // 页面地址
        $href = "systems/adminLogList";
        // 判断当前管理员是否能访问
        try {
            $apiname = 'Ws'.'server.ctl.arcz.Specialized';
            $isQuery = \ar\core\comp('rpc.service')->$apiname("queryMenuByHref",array ($href, $uk));
            if($isQuery){
                // 标题信息
                $apinameNav = 'Ws'.'server.ctl.arcz.Nav';
                $menuTitle = \ar\core\comp('rpc.service')->$apinameNav("getNavTitle", array(2, $href));
                // 数据获取
                $apinameData = 'Ws'.'server.ctl.arcz.Data';
                $res = \ar\core\comp('rpc.service')->$apinameData("getLogList", array($uk, $count, $page, $search_col, $keyword, $sort_col, $sort_type));

                $href = AR_SERVER_PATH . $href;

                $arrSearch = [
                    'username' => '登录账号',
                    'title' => '日志标题',
                    'content' => '日志内容',
                    'login_ip' => '登录IP'
                ];
                $arrSort = [
                    'id' => 'id',
                    'uid' => 'uid',
                    'username' => '登录账号',
                    'title' => '日志标题',
                    'login_ip' => '登录IP',
                    'log_time' => '操作时间'
                ];

                $headForm = $this->getPageService()->headForm($arrSearch, $arrSort, $search_col, $sort_col);
                $pageShow = $this->getPageService()->pageShow($res['totalPages'], $href, $count, $page, $search_col, $keyword, $sort_col, $sort_type);

                $this->assign(['menuTitle' => $menuTitle]);
                $this->assign(['logLists' => $res['logLists'], 'totalCount' => $res['totalCount'], 'totalPages' => $res['totalPages']]);
                $this->assign(['count' => $count, 'page' => $page, 'search_col' => $search_col, 'keyword' => $keyword, 'sort_col' => $sort_col, 'sort_type' => $sort_type]);
                $this->assign(['headForm' => $headForm, 'pageShow' => $pageShow]);
                $this->display('/systemSetting/adminLogList');
            } else {
                $this->display('/404');
            }
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }

    }
   
}

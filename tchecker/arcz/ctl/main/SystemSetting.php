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
class SystemSetting extends Base
{

    // 添加编辑菜单页面
    public function menuAdd()
    {
        // 获取uk
        $uk = $this->getUserService()->getUk();
        // 判断当前管理员是否为开发者
        try {
            $apiname = 'Ws'.'server.ctl.arcz.Specialized';
            $isDev = \ar\core\comp('rpc.service')->$apiname("loginUserIsDev",array ($uk));
            if($isDev){
                $issystem = \ar\core\request('issystem');
                $apinameNav = 'Ws'.'server.ctl.arcz.Nav';

                if($issystem==1){
                    // 系统菜单
                    $topNavs = \ar\core\comp('rpc.service')->$apinameNav("findTopMenuAddMenuSys", array());
                    $secondNavs = \ar\core\comp('rpc.service')->$apinameNav("findSecondMenuAddMenuSys", array());
                } else {
                    // 非系统菜单
                    $topNavs = \ar\core\comp('rpc.service')->$apinameNav("findTopMenuAddMenu", array());
                    $secondNavs = \ar\core\comp('rpc.service')->$apinameNav("findSecondMenuAddMenu", array());
                }


                $isToModel = 0;

                // 模型增加菜单
                $mid = \ar\core\request('mid');
                if ($mid) {
                    $apinameData = 'Ws'.'server.ctl.arcz.Data';
                    $model = \ar\core\comp('rpc.service')->$apinameData("getModel", array($mid));
                    $isToModel = 1;
                    $mhref = 'Data/dlist/mid/' . $mid;
                    $this->assign(['model' => $model, 'mhref' => $mhref]);
                }

                // 编辑菜单显示内容
                $id = \ar\core\request('id');
                if($id>0){
                    $data = \ar\core\comp('rpc.service')->$apinameNav("getNavById", array($id));
                    if($data['mid']>0){
                        $data['mhref'] = 'Data/dlist/mid/' . $data['mid'];
                        $this->assign(['data' => $data, 'pageTitle' => '编辑菜单']);
                    } else {
                        $this->assign(['data' => $data, 'pageTitle' => '编辑菜单']);
                    }
                } else {
                    $data = 0;
                    if($mid){
                        $this->assign(['data' => $data, 'pageTitle' => '模型生成菜单']);
                    } else {
                        $this->assign(['data' => $data, 'pageTitle' => '添加菜单']);
                    }
                }

                $topMenus = $topNavs['top'];
                $secondMenus = $secondNavs['second'];

                $this->assign(['topMenus' => $topMenus]);
                $this->assign(['secondMenus' => $secondMenus]);
                $this->assign(['isToModel' => $isToModel]);
                $this->display('/systemSetting/menuAdd');
            } else {
                $this->display('/404');
            }
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }

    }

    // 数据表字段
    public function showFields($id)
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

                $apinameModel = 'Ws'.'server.ctl.arcz.DBModel';
                $modelRow = \ar\core\comp('rpc.service')->$apinameModel("getModelRow", array($id));
                $tname = $modelRow['tablename'];
                $tableCols = \ar\core\comp('rpc.service')->$apinameModel("getTableCols", array($tname));
                $data = $tableCols['tableCols'];
                $modelList = \ar\core\comp('rpc.service')->$apinameModel("getAllModel", array());

                $this->assign(['menuTitle' => $menuTitle]);
                $this->assign(['modelId' => $id]);
                $this->assign(['modelList' => $modelList]);
                $this->assign(['data' => $data]);
                $this->assign(['tname' => $tname]);
                $this->display('/systemSetting/showFields');
            } else {
                $this->display('/404');
            }
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }

    }

    // 模型菜单自定义功能列表
    public function coustomFunc($id)
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

                $apinameModel = 'Ws'.'server.ctl.arcz.DBModel';
                // 自定义功能列表获取
                $funcList = \ar\core\comp('rpc.service')->$apinameModel("getFuncList", array($id));
                $data = $funcList;
                // 模型详情
                $modelRow = \ar\core\comp('rpc.service')->$apinameModel("getModelRow", array($id));

                $this->assign(['menuTitle' => $menuTitle]);
                $this->assign(['func_mid' => $modelRow['id'], 'func_menuid' => $modelRow['menu']]);
                $this->assign(['data' => $data]);
                $this->display('/systemSetting/coustomFunc');
            } else {
                $this->display('/404');
            }
        } catch (\ar\core\Exception $e) {
            // todos 异常处理
            echo $e->getMessage();
        }

    }


}

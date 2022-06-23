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
define('ORI_PATH_EXCEL', dirname(dirname(dirname(__FILE__))));
/**
 * 控制器
 */
class Data extends Base
{
    // 列表
    public function dlist($mid, $count = 15, $page = 1, $search_col = '', $keyword = '', $sort_col = '', $sort_type = 'desc')
    {
        // 获取uk
        $uk = $this->getUserService()->getUk();
        $apiname = 'Ws'.'server.ctl.arcz.Specialized';
        $isQuery = \ar\core\comp('rpc.service')->$apiname("queryModelByMid",array ($mid, $uk));

        if($isQuery){
            $apinameNav = 'Ws'.'server.ctl.arcz.Nav';
            $menuTitle = \ar\core\comp('rpc.service')->$apinameNav("getNavTitle", array(3, $mid));

            $apinameData = 'Ws'.'server.ctl.arcz.Data';
            // 获取模型
            $columns = \ar\core\comp('rpc.service')->$apinameData("getModelColumns", array($mid));
            // 获取模型是否有唯一键
            $hasUnique = \ar\core\comp('rpc.service')->$apinameData("modelHasUniqueKey", array($mid));
            // 获取模型的唯一键
            $uniKey = \ar\core\comp('rpc.service')->$apinameData("modelUniqueKey", array($mid));
            // 获取模型
            $modelDetail = \ar\core\comp('rpc.service')->$apinameData("getModel", array($mid));
            // 获取菜单
            $menuDetail = \ar\core\comp('rpc.service')->$apinameData("getMenuByModel", array($mid));

            // 是否开发者
            $isDev = \ar\core\comp('rpc.service')->$apiname("loginUserIsDev",array ($uk));
            // 获取能访问的功能按钮
            if($isDev > 0){
                // 是开发者
                $funcButtonsAll = \ar\core\comp('rpc.service')->$apinameData("findDevButtons", array($mid));
                $funcButtons = $funcButtonsAll['buttons'];
            } else {
                // 不是开发者
                $funcButtonsAll = \ar\core\comp('rpc.service')->$apinameData("findUserButtons", array($mid, $uk));
                $funcButtons = $funcButtonsAll['buttons'];
            }
            
            // 统计按钮数量
            $funcCount = 0;
            foreach($funcButtons as &$fb){
                if($fb['type_button']==0 && $fb['type_multi']==0){ // 单状态按钮
                    $funcCount++;
                }
            }

            // 通用功能(type = 1-9)显示设置
            $modelDetail['isadd'] = 0;
            $modelDetail['isedit'] = 0;
            $modelDetail['isdel'] = 0;
            $modelDetail['isview'] = 0;
            $modelDetail['issearch'] = 0;
            $modelDetail['iscostom'] = 0;
            $modelDetail['isloadexcel'] = 0;
            $modelDetail['isprint'] = 0;
            $modelDetail['isaddexcel'] = 0;

            // 是否有自定义功能 0为否 1为是
            $hasFunc = 0;
            // 是否有多状态自定义功能 0为否 1为是
            $hasMultiFunc = 0;
            // 准备装自定义功能的数组
            $func = [];

            foreach($funcButtons as &$f){
                if($f['type']==1){
                    $modelDetail['isadd'] = 1;
                }
                if($f['type']==2){
                    $modelDetail['isedit'] = 1;
                }
                if($f['type']==3){
                    $modelDetail['isdel'] = 1;
                }
                if($f['type']==4){
                    $modelDetail['isview'] = 1;
                }
                if($f['type']==5){
                    $modelDetail['issearch'] = 1;
                }
                if($f['type']==6){
                    $modelDetail['iscostom'] = 1;
                }
                if($f['type']==7){
                    $modelDetail['isloadexcel'] = 1;
                }
                if($f['type']==8){
                    $modelDetail['isprint'] = 1;
                }
                if($f['type']==9){
                    $modelDetail['isaddexcel'] = 1;
                }
                if($f['type']==0){
                    $hasFunc = 1;
                    array_push($func,$f);
                }
                if($f['type']==0&&$f['type_multi']==1){
                    $hasMultiFunc = 1;
                }
            }

            if($sort_col==''){
                $sort_col = $uniKey;
            }
            $href = 'Data/dlist/mid/' . $mid;

            // 获取数据
            $modelData = \ar\core\comp('rpc.service')->$apinameData("modelDataList", array($mid, $count, $page, $search_col, $keyword, $sort_col, $sort_type, $uniKey));
            $href = AR_SERVER_PATH . $href;

            // 搜索字段
            $arrSearch = [];
            // 排序字段
            $arrSort = [];

            foreach($columns as &$col){
                if($col['isshow']==1){
                    if($col['type']==0 || $col['type']==8){
                        $arrSearch[$col['colname']] = $col['colshowname'];
                    }
                    if($col['issort']==true){
                        $arrSort[$col['colname']] = $col['colshowname'];
                    }
                }
            }

            if($modelDetail['issearch']==1){
                $headForm = $this->getPageService()->headForm($arrSearch, $arrSort, $search_col, $sort_col);
            } else {
                $headForm = $this->getPageService()->sortSimple($arrSort, $sort_col);
            }
            $pageShow = $this->getPageService()->pageShow($modelData['totalPages'], $href, $count, $page, $search_col, $keyword, $sort_col, $sort_type);

            $this->assign(['menuTitle' => $menuTitle]);
            $this->assign(['columns' => $columns, 'hasUnique' => $hasUnique, 'uniKey' => $uniKey]);
            $this->assign(['hasFunc' => $hasFunc, 'modelDetail' => $modelDetail, 'funcCount' => $funcCount]);
            $this->assign(['hasMultiFunc' => $hasMultiFunc]);
            $this->assign(['func' => $func]);
            $this->assign(['menuDetail' => $menuDetail]);
            $this->assign(['modelData' => $modelData]);
            $this->assign(['mid' => $mid, 'count' => $count, 'page' => $page, 'search_col' => $search_col, 'keyword' => $keyword, 'sort_col' => $sort_col, 'sort_type' => $sort_type]);
            $this->assign(['headForm' => $headForm, 'pageShow' => $pageShow]);

            $this->display();
        } else {
            $this->display('/404');
        }


    }

    // 编辑页面
    public function edit($mid, $id)
    {
        // 获取uk
        $uk = $this->getUserService()->getUk();
        $apiname = 'Ws'.'server.ctl.arcz.Specialized';
        $isQuery = \ar\core\comp('rpc.service')->$apiname("queryModelByMid",array ($mid, $uk));

        if($isQuery){
            $apinameNav = 'Ws'.'server.ctl.arcz.Nav';
            $menuTitle = \ar\core\comp('rpc.service')->$apinameNav("getNavTitle", array(3, $mid));
            if($id>0){
                // 编辑
                $isFunc = \ar\core\comp('rpc.service')->$apiname("queryFuncByCon",array ($mid, 2, '', $uk));
                if($menuTitle['cate']==3){
                    $pageTitle = "编辑" . $menuTitle['title3'] . "数据";
                } else if($menuTitle['cate']==2) {
                    $pageTitle = "编辑" . $menuTitle['title2'] . "数据";
                }
            } else {
                // 添加
                $isFunc = \ar\core\comp('rpc.service')->$apiname("queryFuncByCon",array ($mid, 1, '', $uk));
                if($menuTitle['cate']==3){
                    $pageTitle = "添加" . $menuTitle['title3'] . "数据";
                } else if($menuTitle['cate']==2) {
                    $pageTitle = "添加" . $menuTitle['title2'] . "数据";
                }
            }

            if($isFunc){
                $apinameData = 'Ws'.'server.ctl.arcz.Data';
                $columns = \ar\core\comp('rpc.service')->$apinameData("getModelColumns", array($mid));
                $doedit = 0;
                if ($id) {
                    $row = \ar\core\comp('rpc.service')->$apinameData("getDataByUniKey", array($mid, $id, 'edit'));
                    $doedit = 1;
                    $this->assign(['row' => $row]);
                }

                $hasUnique = \ar\core\comp('rpc.service')->$apinameData("modelHasUniqueKey", array($mid));
                $uniKey = \ar\core\comp('rpc.service')->$apinameData("modelUniqueKey", array($mid));

                $this->assign(['columns' => $columns, 'hasUnique' => $hasUnique, 'uniKey' => $uniKey]);
                $this->assign(['pageTitle' => $pageTitle]);
                $this->assign(['doedit' => $doedit]);
                $this->assign(['rowId' => $id, 'rowMid' => $mid]);
                $this->display();
            } else {
                $this->display('/404');
            }
        } else {
            $this->display('/404');
        }

    }

    // 查看详情页面
    public function viewMore($mid, $id)
    {
        // 获取uk
        $uk = $this->getUserService()->getUk();
        $apiname = 'Ws'.'server.ctl.arcz.Specialized';
        $isQuery = \ar\core\comp('rpc.service')->$apiname("queryModelByMid",array ($mid, $uk));

        if($isQuery){
            $apinameNav = 'Ws'.'server.ctl.arcz.Nav';
            $menuTitle = \ar\core\comp('rpc.service')->$apinameNav("getNavTitle", array(3, $mid));

            // 查看
            $isFunc = \ar\core\comp('rpc.service')->$apiname("queryFuncByCon",array ($mid, 4, '', $uk));
            if($menuTitle['cate']==3){
                $pageTitle = "查看" . $menuTitle['title3'] . "详情";
            } else if($menuTitle['cate']==2) {
                $pageTitle = "查看" . $menuTitle['title2'] . "详情";
            }
            if($isFunc){
                $apinameData = 'Ws'.'server.ctl.arcz.Data';
                $columns = \ar\core\comp('rpc.service')->$apinameData("getModelColumns", array($mid));
                $doedit = 0;
                if ($id) {
                    $row = \ar\core\comp('rpc.service')->$apinameData("getDataByUniKey", array($mid, $id, 'view'));
                    $doedit = 1;
                    $this->assign(['row' => $row]);
                }

                $hasUnique = \ar\core\comp('rpc.service')->$apinameData("modelHasUniqueKey", array($mid));
                $uniKey = \ar\core\comp('rpc.service')->$apinameData("modelUniqueKey", array($mid));

                $this->assign(['columns' => $columns, 'hasUnique' => $hasUnique, 'uniKey' => $uniKey]);
                $this->assign(['pageTitle' => $pageTitle]);
                $this->assign(['doedit' => $doedit]);
                $this->assign(['rowId' => $id, 'rowMid' => $mid]);
                $this->display();
            } else {
                $this->display('/404');
            }
        } else {
            $this->display('/404');
        }

    }

    // 自定义显示列
    public function define_show_column($mid)
    {
        // 获取uk
        $uk = $this->getUserService()->getUk();
        $apiname = 'Ws'.'server.ctl.arcz.Specialized';
        $isQuery = \ar\core\comp('rpc.service')->$apiname("queryModelByMid",array ($mid, $uk));

        if($isQuery){
            $isFunc = \ar\core\comp('rpc.service')->$apiname("queryFuncByCon",array ($mid, 6, '', $uk));
            if($isFunc){
                $apinameData = 'Ws'.'server.ctl.arcz.Data';
                $columns = \ar\core\comp('rpc.service')->$apinameData("getModelColumns", array($mid));

                $allColName = [];
                foreach ($columns as $key => $values) {
                    if($values['isunique']!=1&&$values['colname']!='id'){
                        $allColName[$key]['tablename'] = $values['tablename'];
                        $allColName[$key]['colname'] = $values['colname'];
                        $allColName[$key]['colshowname'] = $values['colshowname'];
                        $allColName[$key]['isshow'] = $values['isshow'];
                    }
                }

                $this->assign(['allColName' => $allColName]);
                $this->display();
            } else {
                $this->display('/404');
            }
        } else {
            $this->display('/404');
        }

    }

    // 导出成 Excel 格式
    public function downAsExcel($mid)
    {
        // 获取uk
        $uk = $this->getUserService()->getUk();
        $apiname = 'Ws'.'server.ctl.arcz.Specialized';
        $isQuery = \ar\core\comp('rpc.service')->$apiname("queryModelByMid",array ($mid, $uk));
        if($isQuery){
            $apinameData = 'Ws'.'server.ctl.arcz.Data';
            // 数据获取
            $downDatas = \ar\core\comp('rpc.service')->$apinameData("downAsExcel", array($mid));
            $title = $downDatas['title'];
            $data = $downDatas['data'];
            $fileName = $downDatas['fileName'];
            $savePath = $downDatas['savePath'];
            $isDown = $downDatas['isDown'];
            $downResult = $this->getExcelService()->exportExcel($title, $data, $fileName, $savePath, $isDown);
            return true;
        } else {
            return false;
        }
    }


}

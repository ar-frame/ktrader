<?php
/**
 * Powerd by ArPHP.
 *
 * Index service.
 *
 */
namespace server\ctl\arcz\service;

class Nav extends Base
{
    // 添加菜单下拉框查找一级菜单 非系统菜单  \ar\core\service('arcz.Nav')->findTopMenuAddMenu();
    public function findTopMenuAddMenu()
    {
        $condition = [
            'cate' => 1,
            'mid <= 0',
            'issystem' => 0
        ];

        $nav = $this->arczdb->table(self::NAV_TABLENAME)
            ->where($condition)
            ->order('num')
            ->queryAll();
        $cont = $this->arczdb->table(self::NAV_TABLENAME)
            ->where($condition)
            ->count();

        return [
            'top' => $nav,
            'cont' => $cont
        ];
    }

    // 添加菜单下拉框查找一级菜单 包括系统菜单  \ar\core\service('arcz.Nav')->findTopMenuAddMenuSys();
    public function findTopMenuAddMenuSys()
    {
        $condition = [
            'cate' => 1,
            // 'mid <= 0',
        ];

        $nav = $this->arczdb->table(self::NAV_TABLENAME)
            ->where($condition)
            ->order('num')
            ->queryAll();
        $cont = $this->arczdb->table(self::NAV_TABLENAME)
            ->where($condition)
            ->count();

        return [
            'top' => $nav,
            'cont' => $cont
        ];
    }

    // 查找二级菜单  \ar\core\service('arcz.Nav')->findSecondMenu();
    public function findSecondMenu()
    {
        $condition = [
            'cate' => 2,
        ];

        $nav = $this->arczdb->table(self::NAV_TABLENAME)
            ->where($condition)
            ->queryAll();

        foreach($nav as &$n){
            $fmenu = $this->arczdb->table(self::NAV_TABLENAME)->where(['id' => $n['fid']])->queryRow();
            $n['titles'] = $fmenu['title'] . '--' . $n['title'];
        }

        return [
            'second' => $nav,
        ];
    }

    // 添加菜单下拉框查找二级菜单 非系统菜单  \ar\core\service('arcz.Nav')->findSecondMenuAddMenu();
    public function findSecondMenuAddMenu()
    {
        $condition = [
            'cate' => 2,
            'mid <= 0',
            'issystem' => 0
        ];

        $nav = $this->arczdb->table(self::NAV_TABLENAME)
            ->where($condition)
            ->queryAll();
        $cont = $this->arczdb->table(self::NAV_TABLENAME)
            ->where($condition)
            ->count();

        foreach($nav as &$n){
            $fmenu = $this->arczdb->table(self::NAV_TABLENAME)->where(['id' => $n['fid']])->queryRow();
            $n['titles'] = $fmenu['title'] . '--' . $n['title'];
        }

        return [
            'second' => $nav,
            'cont' => $cont
        ];
    }

    // 添加菜单下拉框查找二级菜单 包括系统菜单  \ar\core\service('arcz.Nav')->findSecondMenuAddMenuSys();
    public function findSecondMenuAddMenuSys()
    {
        $condition = [
            'cate' => 2,
            // 'mid <= 0',
        ];

        $nav = $this->arczdb->table(self::NAV_TABLENAME)
            ->where($condition)
            ->queryAll();
        $cont = $this->arczdb->table(self::NAV_TABLENAME)
            ->where($condition)
            ->count();

        foreach($nav as &$n){
            $fmenu = $this->arczdb->table(self::NAV_TABLENAME)->where(['id' => $n['fid']])->queryRow();
            if ($fmenu) {
                $n['titles'] = $fmenu['title'] . '--' . $n['title'];
            }
            
        }

        return [
            'second' => $nav,
            'cont' => $cont
        ];
    }

    // 查找一级菜单  \ar\core\service('arcz.Nav')->findTopMenu();
    public function findTopMenu()
    {
        $condition = [
            'cate' => 1
        ];

        $nav = $this->arczdb->table(self::NAV_TABLENAME)
            ->where($condition)
            ->order('num')
            ->queryAll();

        foreach($nav as &$n){
            if($n['children_code']==1){
                $childMenu = $this->findChildMenu($n['id']);
                $n['children'] = $childMenu;
            }
        }

        $cont = $this->arczdb->table(self::NAV_TABLENAME)
            ->where($condition)
            ->count();

        return [
            'top' => $nav,
            'cont' => $cont
        ];
    }

    // 查找子级菜单  \ar\core\service('arcz.Nav')->findChildMenu($id);
    public function findChildMenu($id)
    {
        $condition = ['fid' => $id];
        $navs = [];

        $menus = $this->arczdb->table(self::NAV_TABLENAME)
            ->where($condition)
            ->queryAll();

        foreach($menus as $k => $v){
            if($v['children_code']==0){
                array_push($navs, $v);
            } else if($v['children_code']==1){
                $ar = [];
                $ar['id'] = $v['id'];
                $ar['title'] = $v['title'];
                $ar['icon'] = $v['icon'];
                $ar['href'] = $v['href'];
                $ar['cate'] = $v['cate'];
                $ar['fid'] = $v['fid'];
                $ar['children_code'] = $v['children_code'];
                $ar['num'] = $v['num'];
                $ar['mid'] = $v['mid'];
                $ar['isdev'] = $v['isdev'];

                $menu3 = $this->arczdb->table(self::NAV_TABLENAME)
                    ->where(['fid' => $v['id']])
                    ->order('num')
                    ->queryAll();
                foreach ($menu3 as &$m3) {
                    if ($m3['mid']) {
                        $m3['href'] =  'Data/dlist/mid/' . $m3['mid'];
                    }
                }

                $ar['children'] = $menu3;
                array_push($navs, $ar);
            }
        }

        foreach ($navs as &$nav) {
            if ($nav['mid']) {
                $nav['href'] =  'Data/dlist/mid/' . $nav['mid'];
            }
        }

        // 根据num排序
        $nav2 = [];
        foreach ($navs as $n) {
            $nav2[] = $n['num'];
        }
        array_multisort($nav2, SORT_ASC, $navs);

        return ['menu' => $navs];
    }

    // 获取当前登录用户能访问的顶级菜单id并存入数组  \ar\core\service('arcz.Nav')->getUserTop($uid);
    public function getUserTop($uid)
    {
        $unav = [];
        $funav = [];
        // 根据uid获取用户所属的用户组
        $role = \ar\core\service('arcz.User')->getRidByUid($uid);
        foreach($role as $key => $value){
            $role_id = $role[$key]['gid'];
            // 根据role_id获取用户组所属的权限
            $nav = \ar\core\service('arcz.User')->getNidByRid($role_id);
            foreach($nav as $k => $v){
                // 将当前用户的权限id添加到数组
                array_push($unav,$v['nid']);
            }
        }
        // 去掉重复数据
        $unav = array_unique($unav);

        // 根据用户能访问的子菜单查到对应的顶级菜单
        foreach($unav as $un){
            // 查找子菜单详情
            $cnav = $this->getNavOne($un);
            // 子菜单是二级菜单
            // 根据fid查找顶级菜单详情
            $fnav = $this->getTopNavOne($cnav['fid']);
            // 子菜单是三级菜单
            if($cnav['cate']==3){
                // 根据fid查找二级菜单详情
                $snav = $this->getNavOne($cnav['fid']);
                // 根据fid查找顶级菜单详情
                $fnav = $this->getTopNavOne($snav['fid']);
            }

            // 添加到数组
            array_push($funav,$fnav['id']);
        }
        // 去重
        $funav = array_unique($funav);

        return $funav;
    }

    // 获取当前登录用户能访问的菜单id并存入数组  \ar\core\service('arcz.Nav')->getUserRole($uid);
    public function getUserRole($uid)
    {
        $unav = [];
        // 根据uid获取用户所属的用户组
        $role = \ar\core\service('arcz.User')->getRidByUid($uid);
        foreach($role as $key => $value){
            $role_id = $role[$key]['gid'];
            // 根据role_id获取用户组所属的权限
            $nav = \ar\core\service('arcz.User')->getNidByRid($role_id);
            foreach($nav as $k => $v){
                // 将当前用户的权限id添加到数组
                array_push($unav,$v['nid']);
            }
        }

        foreach($unav as $k1 => $v1){
            $resnav = $this->getNavOne($v1);
            // 如果是三级菜单，则查找二级菜单并存入数组
            if($resnav['cate']==3){
                $sec = $this->getNavOne($resnav['fid']);
                array_push($unav,$sec['id']);
            }
        }

        // 去掉重复数据
        $unav = array_unique($unav);

        return $unav;
    }

    // 查找用户能访问的一级菜单  \ar\core\service('arcz.Nav')->findUserTopMenu($topid, $navsid);
    public function findUserTopMenu($topid, $navsid)
    {
        $nav = [];
        $cont = 0;

        foreach($topid as $t){
            $menu = $this->arczdb->table(self::NAV_TABLENAME)
                ->where(['id' => $t, 'cate' => 1])
                ->queryRow();
            array_push($nav,$menu);
            $cont++;
        }

        // 排序
        $nav2 = array();
        foreach ($nav as $n) {
            $nav2[] = $n['num'];
        }
        array_multisort($nav2, SORT_ASC, $nav);

        foreach($nav as &$n){
            if($n['children_code']==1){
                $childMenu = $this->findChildMenuUser($n['id'],$navsid);
                $n['children'] = $childMenu;
            }
        }

        return [
            'top' => $nav,
            'cont' => $cont
        ];
    }

    // 根据用户权限查找子级菜单  \ar\core\service('arcz.Nav')->findChildMenuUser($id,$navsid);
    public function findChildMenuUser($id,$navsid)
    {
        $condition = ['fid' => $id, 'isdev' => 0];

        $navs = [];

        $menus = $this->arczdb->table(self::NAV_TABLENAME)
            ->where($condition)
            ->queryAll();

        foreach($navsid as $key => $value){
            foreach($menus as $k => $v){
                if($v['children_code']==0 && $v['id'] == $value){
                    array_push($navs, $v);
                } else if($v['children_code']==1 && $v['id'] == $value){
                    $ar = [];
                    $ar['id'] = $v['id'];
                    $ar['title'] = $v['title'];
                    $ar['icon'] = $v['icon'];
                    $ar['href'] = $v['href'];
                    $ar['cate'] = $v['cate'];
                    $ar['fid'] = $v['fid'];
                    $ar['children_code'] = $v['children_code'];
                    $ar['num'] = $v['num'];
                    $ar['mid'] = $v['mid'];
                    $ar['isdev'] = $v['isdev'];

                    $menu3 = $this->arczdb->table(self::NAV_TABLENAME)
                        ->where(['fid' => $v['id']])
                        ->order('num')
                        ->queryAll();
                    $menu3arr = [];
                    foreach($navsid as $key2 => $value2){
                        foreach($menu3 as $k3 => $v3){
                            if($v3['id'] == $value2){
                                array_push($menu3arr, $v3);
                            }
                        }
                    }

                    foreach ($menu3arr as &$m3) {
                        if ($m3['mid']) {
                            $m3['href'] =  'Data/dlist/mid/' . $m3['mid'];
                        }
                    }

                    // 根据num排序
                    $nav3 = [];
                    foreach ($menu3arr as $n) {
                        $nav3[] = $n['num'];
                    }
                    array_multisort($nav3, SORT_ASC, $menu3arr);

                    $ar['children'] = $menu3arr;
                    array_push($navs, $ar);
                }
            }
        }

        foreach ($navs as &$nav) {
            if ($nav['mid']) {
                $nav['href'] =  'Data/dlist/mid/' . $nav['mid'];
            }
        }

        // 根据num排序
        $nav2 = [];
        foreach ($navs as $n) {
            $nav2[] = $n['num'];
        }
        array_multisort($nav2, SORT_ASC, $navs);

        return [
            'menu' => $navs,
        ];

    }

    // 根据id查找单个顶级菜单  \ar\core\service('arcz.Nav')->getTopNavOne($id);
    public function getTopNavOne($id)
    {
        $condition = [
            'cate' => 1,
            'id' => $id,
            'isdev' => 0
        ];
        $menu = $this->arczdb->table(self::NAV_TABLENAME)
            ->where($condition)
            ->queryRow();
        return $menu;
    }

    // 根据id查找单个菜单  \ar\core\service('arcz.Nav')->getNavOne($id);
    public function getNavOne($id)
    {
        $condition = [
            'id' => $id,
            'isdev' => 0
        ];
        $menu = $this->arczdb->table(self::NAV_TABLENAME)
            ->where($condition)
            ->queryRow();
        return $menu;
    }

    // 根据id查找单个菜单 包括系统菜单  \ar\core\service('arcz.Nav')->getNavById($id);
    public function getNavById($id)
    {
        $condition = [
            'id' => $id,
        ];
        $menu = $this->arczdb->table(self::NAV_TABLENAME)
            ->where($condition)
            ->queryRow();
        return $menu;
    }

    // 根据id查找单个菜单并返回菜单标题  \ar\core\service('arcz.Nav')->getNavTitleById($id);
    public function getNavTitleById($id)
    {
        $data = [
            'title1' => 0,
            'title2' => 0,
            'title3' => 0,
            'cate'   => 0
        ];

        $menu1 = $this->arczdb->table(self::NAV_TABLENAME)->where(['id' => $id])->queryRow();

        if($menu1['cate'] == 1){
            $data['title1'] = $menu1['title'];
            $data['cate'] = 1;
        } else if($menu1['cate'] == 2){
            $data['title2'] = $menu1['title'];
            $menu2 = $this->arczdb->table(self::NAV_TABLENAME)->where(['id' => $menu1['fid']])->queryRow();
            $data['title1'] = $menu2['title'];
            $data['cate'] = 2;
        } else if($menu1['cate'] == 3){
            $data['title3'] = $menu1['title'];
            $menu2 = $this->arczdb->table(self::NAV_TABLENAME)->where(['id' => $menu1['fid']])->queryRow();
            $data['title2'] = $menu2['title'];
            $menu3 = $this->arczdb->table(self::NAV_TABLENAME)->where(['id' => $menu2['fid']])->queryRow();
            $data['title1'] = $menu3['title'];
            $data['cate'] = 3;
        }
        return $data;
    }

    // 根据链接查找单个菜单并返回菜单标题  \ar\core\service('arcz.Nav')->getNavTitleByHref($href);
    public function getNavTitleByHref($href)
    {
        $data = [
            'title1' => 0,
            'title2' => 0,
            'title3' => 0,
            'cate'   => 0
        ];

        $menu1 = $this->arczdb->table(self::NAV_TABLENAME)->where(['href' => $href])->queryRow();

        if($menu1['cate'] == 1){
            $data['title1'] = $menu1['title'];
            $data['cate'] = 1;
        } else if($menu1['cate'] == 2){
            $data['title2'] = $menu1['title'];
            $menu2 = $this->arczdb->table(self::NAV_TABLENAME)->where(['id' => $menu1['fid']])->queryRow();
            $data['title1'] = $menu2['title'];
            $data['cate'] = 2;
        } else if($menu1['cate'] == 3){
            $data['title3'] = $menu1['title'];
            $menu2 = $this->arczdb->table(self::NAV_TABLENAME)->where(['id' => $menu1['fid']])->queryRow();
            $data['title2'] = $menu2['title'];
            $menu3 = $this->arczdb->table(self::NAV_TABLENAME)->where(['id' => $menu2['fid']])->queryRow();
            $data['title1'] = $menu3['title'];
            $data['cate'] = 3;
        }
        return $data;
    }

    // 根据mid查找单个菜单并返回菜单标题  \ar\core\service('arcz.Nav')->getNavTitleByMid($mid);
    public function getNavTitleByMid($mid)
    {
        $data = [
            'title1' => 0,
            'title2' => 0,
            'title3' => 0,
            'cate'   => 0
        ];

        $menu1 = $this->arczdb->table(self::NAV_TABLENAME)->where(['mid' => $mid])->queryRow();

        if($menu1['cate'] == 1){
            $data['title1'] = $menu1['title'];
            $data['cate'] = 1;
        } else if($menu1['cate'] == 2){
            $data['title2'] = $menu1['title'];
            $menu2 = $this->arczdb->table(self::NAV_TABLENAME)->where(['id' => $menu1['fid']])->queryRow();
            $data['title1'] = $menu2['title'];
            $data['cate'] = 2;
        } else if($menu1['cate'] == 3){
            $data['title3'] = $menu1['title'];
            $menu2 = $this->arczdb->table(self::NAV_TABLENAME)->where(['id' => $menu1['fid']])->queryRow();
            $data['title2'] = $menu2['title'];
            $menu3 = $this->arczdb->table(self::NAV_TABLENAME)->where(['id' => $menu2['fid']])->queryRow();
            $data['title1'] = $menu3['title'];
            $data['cate'] = 3;
        }
        return $data;
    }

    // 菜单列表  \ar\core\service('arcz.Nav')->navslist();
    public function navslist()
    {
        $totalCount = $this->arczdb->table(self::NAV_TABLENAME)->count();

        // 准备装一级菜单
        $cate1 = [];
        // 准备装二级菜单
        $cate2 = [];
        // 准备装三级菜单
        $cate3 = [];

        $navs = $this->arczdb->table(self::NAV_TABLENAME)->order('num')->queryAll();

        foreach ($navs as $key => $value) {
            if($value['mid'] > 0){
                $navs[$key]['href'] = 'Data/dlist/mid/' . $value['mid'];
            }

            if($value['cate'] == 1){

            } else if($value['cate'] == 2) {
                $navs[$key]['title'] = '&nbsp;&nbsp;' . $value['title'];
            } else if($value['cate'] == 3) {
                $navs[$key]['title'] = '&nbsp;&nbsp;&nbsp;&nbsp;' . $value['title'];
            }
            if($value['fid'] > 0) {
                $row = $this->arczdb->table(self::NAV_TABLENAME)->where(['id' => $value['fid']])->queryRow();
                
                if ($row) {
                    $navs[$key]['fmenu'] = $row['title'];
                }
                
            } else if($value['fid'] == 0) {
                $navs[$key]['fmenu'] = '顶级菜单';
            }

        }

        // 往三个数组里面装
        foreach ($navs as $key => $value) {
            if($value['cate'] == 1){
                $cate1[] = $value;
            } else if($value['cate'] == 2) {
                $cate2[] = $value;
            } else if($value['cate'] == 3) {
                $cate3[] = $value;
            }

        }

        // 排序装入新数组
        $bigNavs = [];
        foreach ($cate1 as $k1 => $v1) {
            // 放入一级菜单
            $bigNavs[] = $v1;
            if($v1['children_code']==1) {
                foreach ($cate2 as $k2 => $v2) {
                    if($v2['fid'] == $v1['id']) {
                        // 放入二级菜单
                        $bigNavs[] = $v2;
                        if($v2['children_code']==1) {
                            foreach ($cate3 as $k3 => $v3) {
                                if($v3['fid'] == $v2['id']) {
                                    // 放入三级菜单
                                    $bigNavs[] = $v3;
                                }
                            }
                        }
                    }
                }
            }
        }

        foreach($bigNavs as &$bv){
            $check = '';
            // 判断是否为开发者菜单
            $isdev = $bv['isdev'];
            if($isdev==1){
                $check = 'checked';
            }
            $bv['isdevswitch'] = '<input type="checkbox" class="ace ace-switch ace-switch-6 switch_check" value="'.$bv['id'].'" name="isdev" '.$check.'><span class="lbl middle"></span>';
        }

        return [
            'navs' => $bigNavs,
            'count' => $totalCount
        ];
    }

    // 设置开发者菜单操作  \ar\core\service('arcz.Nav')->navSetDevSwitch($id, $value, $uk, $loginip);
    public function navSetDevSwitch($id, $value, $uk, $loginip){
        // 当前登录用户详情
        $userDetail = \ar\core\service('arcz.User')->getLoginUser($uk);
        $uid = $userDetail['id'];

        $errCode = 1000;
        $errMsg = '';

        // 判断当前管理员是否为开发者
        $isDev = $userDetail['isDev'];

        if($isDev==1){
            // 菜单信息
            $navRow = $this->arczdb->table(self::NAV_TABLENAME)->where(['id' => $id])->queryRow();
            if($navRow['href'] == 'systems'){
                $errCode = 2001;
                $errMsg = '不能设置该菜单！';
            } else if($navRow['href'] == 'systems/menuList'){
                $errCode = 2002;
                $errMsg = '不能设置该菜单！';
            } else if($navRow['href'] == 'systems/tableList'){
                $errCode = 2003;
                $errMsg = '不能设置该菜单！';
            } else if($navRow['href'] == 'systems/modelList'){
                $errCode = 2004;
                $errMsg = '不能设置该菜单！';
            } else {
                if($value == 1){
                    // 删除管理员组权限
                    $this->arczdb->table(self::GROUP_NAV_TABLENAME)->where(['nid' => $id])->delete();
                    $edit = $this->arczdb->table(self::NAV_TABLENAME)->where(['id' => $id])->update(['isdev' => 1]);
                    if($edit){
                        // 日志记录参数
                        $logtitle = '编辑菜单';
                        $logcontent = '管理员编辑菜单 ID: ' . $id;
                        \ar\core\service('arcz.Specialized')->addAdminLog($uid, $logtitle, $logcontent, $loginip);
                        $errMsg = '编辑菜单成功';
                    } else {
                        $errCode = 1004;
                        $errMsg = '编辑菜单失败';
                    }
                } else if($value == 0){
                    $edit = $this->arczdb->table(self::NAV_TABLENAME)->where(['id' => $id])->update(['isdev' => 0]);
                    if($edit){
                        // 日志记录参数
                        $logtitle = '编辑菜单';
                        $logcontent = '管理员编辑菜单 ID: ' . $id;
                        \ar\core\service('arcz.Specialized')->addAdminLog($uid, $logtitle, $logcontent, $loginip);
                        $errMsg = '编辑菜单成功';
                    } else {
                        $errCode = 1004;
                        $errMsg = '编辑菜单失败';
                    }
                }
            }
        } else {
            $errCode = 2550;
            $errMsg = '非法操作！';
        }

        return ['errCode' => $errCode, 'errMsg' => $errMsg];
    }

    // 添加编辑菜单  \ar\core\service('arcz.Nav')->addMenu($id, $title, $href, $info, $icon, $cate, $fid, $num, $mid, $uk, $loginip);
    public function addMenu($id, $title, $href, $info, $icon, $cate, $fid, $num, $mid, $uk, $loginip)
    {
        // 当前登录用户详情
        $userDetail = \ar\core\service('arcz.User')->getLoginUser($uk);
        $uid = $userDetail['id'];

        $errCode = 1000;
        $errMsg = '';

        // 判断当前管理员是否为开发者
        $isDev = $userDetail['isDev'];

        if($isDev==1){
            if($title==''){
                $errCode = 1001;
                $errMsg = '标题不能为空';
            } else if($cate==2 && $fid==0){
                $errCode = 1002;
                $errMsg = '请选择父级菜单';
            } else if($cate==3 && $fid==0){
                $errCode = 1003;
                $errMsg = '请选择父级菜单';
            } else {
                if ($id > 0) {
                    // 更新
                    $updateData = [
                        'title' => $title,
                        'info' => $info,
                        'href'  => $href,
                        'icon'  => $icon,
                        'cate'  => $cate,
                        'fid'   => $fid,
                        'num'   => $num
                    ];

                    $update = $this->arczdb->table(self::NAV_TABLENAME)
                        ->where(['id' => $id])
                        ->update($updateData);

                    $fmenu = $this->arczdb->table(self::NAV_TABLENAME)
                        ->where(['id' => $fid])
                        ->queryRow();
                    if($fmenu['children_code'] == 0){
                        $this->arczdb->table(self::NAV_TABLENAME)
                            ->where(['id' => $fid])
                            ->update(['children_code' => 1]);
                    }
                    // 查找children_code==1的菜单 如果没有子菜单就将children_code改为0
                    $navs = $this->arczdb->table(self::NAV_TABLENAME)
                        ->where(['children_code' => 1])
                        ->queryAll();
                    foreach($navs as $n){
                        // 判断是否有子菜单
                        $count = $this->arczdb->table(self::NAV_TABLENAME)->where(['fid' => $n['id']])->count();
                        if($count == 0){
                            $this->arczdb->table(self::NAV_TABLENAME)->where(['id' => $n['id']])->update(['children_code' => 0]);
                        }
                    }
                    // 更新的菜单详情
                    $navDetail = $this->arczdb->table(self::NAV_TABLENAME)->where(['id' => $id])->queryRow();
                    if($navDetail['mid']>0){
                        // 模型菜单名更新
                        $this->arczdb->table(self::MODELLIST_TABLENAME)->where(['menu' => $id])->update(['menu_name' => $title, 'explain' => $title]);
                    }

                    if($update){
                        // 日志记录参数
                        $logtitle = '编辑菜单';
                        $logcontent = '管理员编辑菜单 ID: ' . $id . '标题 ' . $title;
                        \ar\core\service('arcz.Specialized')->addAdminLog($uid, $logtitle, $logcontent, $loginip);
                        $errMsg = '编辑菜单成功';
                    } else {
                        $errCode = 1004;
                        $errMsg = '编辑菜单失败';
                    }

                } else {
                    // 添加
                    if ($mid) { // 模型生成
                        $issystem = 0;
                    } else {
                        $issystem = 0;
                    }
                    $data = [
                        'title' => $title,
                        'info' => $info,
                        'href'  => $href,
                        'icon'  => $icon,
                        'cate'  => $cate,
                        'fid'   => $fid,
                        'num'   => $num,
                        'issystem' => $issystem,
                        'mid' => $mid
                    ];
                    // 写入
                    $insert = $this->arczdb->table(self::NAV_TABLENAME)->insert($data);

                    // 写入模型菜单表
                    if ($data['mid'] > 0) { // 模型生成
                        // 更新model_list数据
                        $modelData = [
                            'menu' => $insert,
                            'menu_name' => $data['title'],
                            'explain' => $data['title']
                        ];
                        $this->arczdb->table(self::MODELLIST_TABLENAME)
                            ->where(['id' => $data['mid']])
                            ->update($modelData);
                        // 默认超级管理员增加权限
                        if($data['fid'] > 0){
                            // 权限数据
                            $adddata = [
                                'gid' => 1,
                                'nid' => $insert
                            ];
                            $this->arczdb->table(self::GROUP_NAV_TABLENAME)->insert($adddata);
                        }
                        // 更新cz_admin_model_menufunc数据
                        $this->arczdb->table(self::MODEL_MENUFUNC_TABLENAME)->where(['mid' => $data['mid']])->update(['menuid' => $insert]);
                        $fid = $data['fid'];
                        $fmenu = $this->arczdb->table(self::NAV_TABLENAME)
                            ->where(['id' => $fid])
                            ->queryRow();
                        if($fmenu['children_code'] == 0){
                            $this->arczdb->table(self::NAV_TABLENAME)
                                ->where(['id' => $fid])
                                ->update(['children_code' => 1]);
                        }
                    } else {
                        $fid = $data['fid'];
                        $fmenu = $this->arczdb->table(self::NAV_TABLENAME)
                            ->where(['id' => $fid])
                            ->queryRow();
                        if($fmenu['children_code'] == 0){
                            $this->arczdb->table(self::NAV_TABLENAME)
                                ->where(['id' => $fid])
                                ->update(['children_code' => 1]);
                        }
                    }

                    if($insert){
                        // 日志记录参数
                        $logtitle = '添加菜单';
                        $logcontent = '管理员添加菜单 ' . $title;
                        \ar\core\service('arcz.Specialized')->addAdminLog($uid, $logtitle, $logcontent, $loginip);
                        $errMsg = '添加菜单成功';
                    } else {
                        $errCode = 1005;
                        $errMsg = '添加菜单失败';
                    }

                }
            }
        } else {
            $errCode = 2550;
            $errMsg = '非法操作！';
        }

        return ['errCode' => $errCode, 'errMsg' => $errMsg];

    }

    // 删除菜单  \ar\core\service('arcz.Nav')->delMenu($id, $uk, $loginip);
    public function delMenu($id, $uk, $loginip)
    {
        // 当前登录用户详情
        $userDetail = \ar\core\service('arcz.User')->getLoginUser($uk);
        $uid = $userDetail['id'];

        $errCode = 1000;
        $errMsg = '';

        // 判断当前管理员是否为开发者
        $isDev = $userDetail['isDev'];

        if($isDev==1){
            $menuDef = $this->getNavOne($id);

            $childCode = $menuDef['children_code'];

            if($childCode==1){
                $errCode = 1004;
                $errMsg = '存在子级菜单，删除失败';
            } else {
                $delResult = $this->delNav($id);
                if ($delResult) {
                    // 日志记录
                    $title = '删除菜单';
                    $content = '管理员删除菜单 ID: ' . $id . ' 菜单名称: ' . $menuDef['title'];
                    \ar\core\service('arcz.Specialized')->addAdminLog($uid, $title, $content, $loginip);
                    $errMsg = '删除菜单成功';
                } else {
                    $errCode = 1003;
                    $errMsg = '删除失败';
                }
            }
        } else {
            $errCode = 2550;
            $errMsg = '非法操作！';
        }

        return ['errCode' => $errCode, 'errMsg' => $errMsg];

    }

    // 删除菜单操作
    public function delNav($id)
    {
        $nav = $this->arczdb->table(self::NAV_TABLENAME)
            ->where(['id' => $id])
            ->queryRow();
        // 判断是否为系统菜单
        if($nav['issystem'] == 1){
            return false;
        } else {
            if ($nav['mid']) {
                // 更新cz_admin_model数据
                $this->arczdb->table(self::MODELLIST_TABLENAME)
                    ->where(['id' => $nav['mid']])
                    ->update(['menu' => 0]);
                // 更新cz_admin_model_menufunc数据
                $this->arczdb->table(self::MODEL_MENUFUNC_TABLENAME)->where(['mid' => $nav['mid']])->update(['menuid' => 0]);
            }
            $del = $this->arczdb->table(self::NAV_TABLENAME)->where(['id' => $id])->delete();
            $this->arczdb->table(self::GROUP_NAV_TABLENAME)->where(['nid' => $id])->delete();
            // 查找是否有相同fid的菜单
            $navf = $this->arczdb->table(self::NAV_TABLENAME)->where(['fid' => $nav['fid']])->count();
            if($navf > 0){
                return $del;
            } else {
                $this->arczdb->table(self::NAV_TABLENAME)->where(['id' => $nav['fid']])->update(['children_code' => 0]);
                return $del;
            }
        }

    }


}

<?php
/**
 * Powerd by ArPHP.
 *
 * User service.
 *
 */
namespace server\ctl\arcz\service;

/**
 * 权限服务组件
 */
class Specialized extends Base
{

    // 管理员日志记录写入  \ar\core\service('arcz.Specialized')->addAdminLog($uid, $title, $content, $loginip);
    public function addAdminLog($uid, $title, $content, $loginip)
    {
        // 登录用户详情
        $userDetail = \ar\core\service('arcz.User')->getUserById($uid);

        $username = $userDetail['username'];
        // 是否开发者
        $isDev = $userDetail['isDev'];
        if($isDev){
            $is_dev = 1;
        } else {
            $is_dev = 0;
        }
        $addData = [
            'uid' => $uid,
            'username' => $username,
            'log_time' => time(),
            'login_ip' => $loginip,
            'title' => $title,
            'content' => $content,
            'is_dev' => $is_dev
        ];

        $this->arczdb->table(self::LOG_TABLENAME)->insert($addData);

    }


    // 直接判断当前登录用户是否为开发者  \ar\core\service('arcz.Specialized')->loginUserIsDev($uk);
    public function loginUserIsDev($uk)
    {
        $user = \ar\core\service('arcz.User')->getLoginUser($uk);

        $uid = $user['id'];

        return $this->isDev($uid);
    }

    // 判断登录用户为开发者  \ar\core\service('arcz.Specialized')->isDev($uid);
    public function isDev($uid)
    {
        return $this->arczdb->table(self::DEVELOPER_TABLENAME)->where(['uid' => $uid])->count();
    }

    // 根据系统菜单地址判断用户是否能访问该系统菜单  \ar\core\service('arcz.Specialized')->queryMenuByHref($href, $uk);
    public function queryMenuByHref($href, $uk)
    {
        $isQuery = false;

        $nav =  $this->arczdb->table(self::NAV_TABLENAME)->where(['href' => $href])->queryRow();
        if($nav){
            $nid = $nav['id'];
            $hasNav = $this->queryNavByNid($nid, $uk);
            if($hasNav){
                $isQuery = true;
            }
        }

        return $isQuery;
    }

    // 判断用户是否能访问当前菜单mid  \ar\core\service('arcz.Specialized')->queryNavByNid($nid, $uk);
    public function queryNavByNid($nid, $uk)
    {
        //  获取登录用户能访问的所有菜单id
        $allNavIds = $this->getUserAllNavId($uk);

        $isQuery = false;

        foreach($allNavIds as $anid){
            if($anid==$nid){
                $isQuery = true;
            }
        }

        return $isQuery;
    }

    // 获取登录用户能访问的所有菜单id  \ar\core\service('arcz.Specialized')->getUserAllNavId($uk);
    public function getUserAllNavId($uk)
    {
        // 用户id
        $user = \ar\core\service('arcz.User')->getLoginUser($uk);

        $uid = $user['id'];
        // 是否开发者
        $isDev = $this->isDev($uid);
        if($isDev){
            // 所有菜单id
            $usernids = $this->arczdb->table(self::NAV_TABLENAME)->queryAll();
            $allNavIds = []; // 用来装用户菜单id的数组
            foreach($usernids as &$nid){
                array_push($allNavIds,$nid['id']);
            }
            $allNavIds = array_unique($allNavIds);
        } else {
            // 用户所有角色id
            $usergids = $this->arczdb->table(self::USER_GROUP_TABLENAME)->where(['uid' => $uid])->select('gid')->queryAll();
            $gids = []; // 用来装用户角色id的数组
            foreach($usergids as &$gid){
                array_push($gids,$gid['gid']);
            }
            // 所有菜单id
            $usernids = $this->arczdb->table(self::GROUP_NAV_TABLENAME)->where(['gid' => $gids])->queryAll();
            $allNavIds = []; // 用来装用户菜单id的数组
            foreach($usernids as &$nid){
                array_push($allNavIds,$nid['nid']);
            }
            $allNavIds = array_unique($allNavIds);
        }

        return $allNavIds;
    }

    // 根据模型mid判断用户是否能访问当前模型  \ar\core\service('arcz.Specialized')->queryModelByMid($mid, $uk);
    public function queryModelByMid($mid, $uk)
    {
        //  获取登录用户能访问的所有模型id
        $allModelIds = $this->getUserAllModelId($uk);

        $isQuery = false;

        foreach($allModelIds as $amid){
            if($amid==$mid){
                $isQuery = true;
            }
        }

        return $isQuery;
    }

    // 获取登录用户能访问的所有模型id  \ar\core\service('arcz.Specialized')->getUserAllModelId($uk);
    public function getUserAllModelId($uk)
    {
        // 用户id
        $user = \ar\core\service('arcz.User')->getLoginUser($uk);
        $uid = $user['id'];
        // 是否开发者
        $isDev = $this->isDev($uid);
        if($isDev){
            $allDevModelIds = $this->arczdb->table(self::MODELLIST_TABLENAME)->select('id')->queryAll();
            $allModelIds = []; // 用来装用户模型id的数组
            foreach($allDevModelIds as &$nav){
                array_push($allModelIds,$nav['id']);
            }
        } else {
            // 用户所有角色id
            $usergids = $this->arczdb->table(self::USER_GROUP_TABLENAME)->where(['uid' => $uid])->select('gid')->queryAll();
            $gids = []; // 用来装用户角色id的数组
            foreach($usergids as &$gid){
                array_push($gids,$gid['gid']);
            }
            // 所有菜单id
            $usernids = $this->arczdb->table(self::GROUP_NAV_TABLENAME)->where(['gid' => $gids])->queryAll();
            $nids = []; // 用来装用户菜单id的数组
            foreach($usernids as &$nid){
                array_push($nids,$nid['nid']);
            }
            $nids = array_unique($nids);

            // 查找菜单
            $allnavs = $this->arczdb->table(self::NAV_TABLENAME)->where(['id' => $nids])->queryAll();
            $allModelIds = []; // 用来装用户模型id的数组
            foreach($allnavs as &$nav){
                array_push($allModelIds,$nav['mid']);
            }
        }

        return $allModelIds;
    }

    // 根据模型id获取菜单名称  \ar\core\service('arcz.Specialized')->getNavDetailByMid($mid);
    public function getNavDetailByMid($mid)
    {
        return $this->arczdb->table(self::NAV_TABLENAME)->where(['mid' => $mid])->queryRow();
    }

    // 根据功能mid,type,href判断用户是否能访问此模型当前功能  \ar\core\service('arcz.Specialized')->queryFuncByCon($mid, $type, $href, $uk);
    public function queryFuncByCon($mid, $type, $href, $uk)
    {
        // 查找功能条件
        if($type==0){
            $con = ['mid' => $mid, 'type' => $type, 'apiaddr' => $href];
        } else {
            $con = ['mid' => $mid, 'type' => $type];
        }

        // 根据条件查找功能id
        $funcRow = $this->arczdb->table(self::MODEL_MENUFUNC_TABLENAME)->where($con)->queryRow();
        $fid = $funcRow['id']; // 功能id

        // 根据模型mid获取登录用户能访问的此模型所有功能id
        $allFids = $this->getUserAllFuncIdByMid($mid, $uk);
        
        //  \ar\core\comp('tools.log')->record([$allFids, $fid, $mid, $type, $href, $uk], 'allFids');

        $isFunc = false;

        foreach($allFids as $afid){
            if($afid==$fid){
                $isFunc = true;
            }
        }

        return $isFunc;
    }

    // 根据模型mid获取登录用户能访问的此模型所有功能id  \ar\core\service('arcz.Specialized')->getUserAllFuncIdByMid($mid, $uk);
    public function getUserAllFuncIdByMid($mid, $uk)
    {
        // 用户id
        $user = \ar\core\service('arcz.User')->getLoginUser($uk);
        $uid = $user['id'];
        // 是否开发者
        $isDev = $this->isDev($uid);
        if($isDev){
            $allDevFuncIds = $this->arczdb->table(self::GROUP_FUNC_TABLENAME)->where(['mid' => $mid])->select('fid')->queryAll();
            $allFuncIds = []; // 用来装用户功能id的数组
            foreach($allDevFuncIds as &$fid){
                array_push($allFuncIds,$fid['fid']);
            }
            $allFuncIds = array_unique($allFuncIds);
        } else {
            // 用户所有角色id
            $usergids = $this->arczdb->table(self::USER_GROUP_TABLENAME)->where(['uid' => $uid])->select('gid')->queryAll();
            $gids = []; // 用来装用户角色id的数组
            foreach($usergids as &$gid){
                array_push($gids,$gid['gid']);
            }
            // 所有功能id
            $allUserFuncIds = $this->arczdb->table(self::GROUP_FUNC_TABLENAME)->where(['mid' => $mid,'gid' => $gids])->select('fid')->queryAll();
            $allFuncIds = []; // 用来装用户功能id的数组
            foreach($allUserFuncIds as &$fid){
                array_push($allFuncIds,$fid['fid']);
            }
            $allFuncIds = array_unique($allFuncIds);
        }

        return $allFuncIds;
    }




}

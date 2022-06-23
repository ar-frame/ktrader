<?php

namespace server\ctl\arcz\service;
/**
 * 用户
 */
class User extends Base
{

    // 用户登录  \ar\core\service('arcz.User')->login($username, $pass, $loginip);
    public function login($username, $pass, $loginip)
    {
        $errorMsg = '';
        $errorCode = 1000;
        $uk = '';

        if (empty($username) || empty($pass)) {
            $errorMsg = '帐号或密码不能为空';
            $errorCode = 1002;
        } else {
            // var_dump($this->pwd($pass));
            $userCondition = [
                'username' => $username,
                'password' => $this->pwd($pass),
            ];
            $userCount = $this->arczdb->table(self::USER_TABLENAME)->where($userCondition)->count();

            if ($userCount > 0) {
                $userDetail = $this->arczdb->table(self::USER_TABLENAME)->where($userCondition)->queryRow();
                // 登录用户id
                $uid = $userDetail['id'];
                // 设置登录成功
                $uk = $this->gUserkey($uid);
                $isDev = \ar\core\service('arcz.User')->isDev($uid);  // 是否开发者
                if($isDev){
                    // 登录次数
                    $loginCount = $userDetail['login_content'] + 1;
                    // 修改登录信息
                    $this->arczdb->table(self::USER_TABLENAME)
                        ->where(['id' => $uid])
                        ->update([
                            'login_content' => $loginCount,
                            'login_time' => time(),
                            'login_ip' => $loginip
                        ]);
                    // 日志记录
                    $title = '管理员登录';
                    $content = '管理员 ' . $userDetail['username'] . ' 登录成功';
                    \ar\core\service('arcz.Specialized')->addAdminLog($uid, $title, $content, $loginip);
                    $errorMsg = '登录成功！';
                } else { // 非开发者
                    $groupUser = $this->arczdb->table(self::USER_GROUP_TABLENAME)->where(['uid' => $uid])->queryRow();  // 用户组
                    if($groupUser){
                        // 登录次数
                        $loginCount = $userDetail['login_content'] + 1;
                        // 修改登录信息
                        $this->arczdb->table(self::USER_TABLENAME)
                            ->where(['id' => $uid])
                            ->update([
                                'login_content' => $loginCount,
                                'login_time' => time(),
                                'login_ip' => $loginip
                            ]);
                        // 日志记录
                        $title = '管理员登录';
                        $content = '管理员 ' . $userDetail['username'] . ' 登录成功';
                        \ar\core\service('arcz.Specialized')->addAdminLog($uid, $title, $content, $loginip);
                        $errorMsg = '登录成功！';
                    } else {
                        $errorCode = 1002;
                        $errorMsg = '无效用户！';
                    }
                }
            } else {
                $errorCode = 1001;
                $errorMsg = '帐号或者密码错误！';
            }
        }

        return ['errMsg' => $errorMsg, 'errCode' => $errorCode, 'uk' => $uk];
    }

    // 退出
    public function loginOut($uk)
    {
        // 当前登录用户详情
        $userDetail = \ar\core\service('arcz.User')->getLoginUser($uk);
        if($userDetail){
            $loginStatus = ['is_login' => 0];
            // 更改登录状态
            $this->arczdb->table(self::USER_TABLENAME)->where(['id' => $userDetail['id']])->update($loginStatus);
            return true;
        } else {
            return false;
        }
    }

    // 获取当前登录用户详情  \ar\core\service('arcz.User')->getLoginUser($uk);
    public function getLoginUser($uk)
    {
        $uid = $this->getUserId($uk);
        $userCondition = ['id' => $uid];

        $userDetail = $this->arczdb->table(self::USER_TABLENAME)->where($userCondition)->queryRow();

        $userDetail['group'] = "";
        // 默认不是超级管理员
        $userDetail['isadmin1'] = 0;
        $urs = $this->arczdb->table(self::USER_GROUP_TABLENAME)
            ->where(['uid' => $userDetail['id']])
            ->order('gid')
            ->queryAll();
        if($urs){
            $roleName = $this->arczdb->table(self::GROUP_TABLENAME)->where(['id' => $urs[0]['gid']])->queryRow();
            $userDetail['group'] = $roleName['group_name'];
        }

        foreach($urs as $ur) {
            // 判断是否为超级管理员
            if($ur['gid']==1){
                $userDetail['isadmin1'] = 1;
            }
        }

        $userDetail['isDev'] = 0;
        // 判断是否为开发者
        $dev = $this->isDev($userDetail['id']);
        if($dev){
            $userDetail['group'] = "开发者 ";
            $userDetail['isDev'] = 1;
        }

        return $userDetail;
    }

    // 获取当前登录用户详细信息  \ar\core\service('arcz.User')->getLoginUser($uk);
    public function getLoginUserInfo($uk)
    {
        $uid = $this->getUserId($uk);
        $userCondition = ['id' => $uid];

        $userDetail = $this->arczdb->table(self::USER_TABLENAME)->where($userCondition)->queryRow();

        $userDetail['group'] = "";
        // 默认不是超级管理员
        $userDetail['isadmin1'] = 0;
        $urs = $this->arczdb->table(self::USER_GROUP_TABLENAME)
            ->where(['uid' => $userDetail['id']])
            ->order('gid')
            ->queryAll();
        if($urs){
            $roleName = $this->arczdb->table(self::GROUP_TABLENAME)->where(['id' => $urs[0]['gid']])->queryRow();
            $userDetail['group'] = $roleName['group_name'];
        }

        foreach($urs as $ur) {
            // 判断是否为超级管理员
            if($ur['gid']==1){
                $userDetail['isadmin1'] = 1;
            }
        }

        $userDetail['isDev'] = 0;
        // 判断是否为开发者
        $dev = $this->isDev($userDetail['id']);
        if($dev){
            $userDetail['group'] = "开发者 ";
            $userDetail['isDev'] = 1;
        }


        $userDetail['groups'] = "";
        if($dev){
            $userDetail['groups'] = "开发者 ";
        }

        foreach($urs as $key => $value) {
            $roleName = $this->arczdb->table(self::GROUP_TABLENAME)->where(['id' => $value['gid']])->queryRow();
            $urs[$key]['rname'] = $roleName['group_name'];
            $userDetail['groups'] = $userDetail['groups'] . " " . $urs[$key]['rname'];
        }

        $userDetail['register_date'] = date('Y-m-d', $userDetail['register_time']);
        $userDetail['login_date'] = date('Y-m-d', $userDetail['login_time']);

        $userDetail['log_list'] = $this->getLogList($uk, 10, 1);
        $userDetail['log_list_1'] = $this->getLogList($uk, 6, 1);
        $userDetail['log_list_2'] = $this->getLogList($uk, 6, 2);

        $userDetail['count_log_1'] = $this->countAdminLog($userDetail['id'], '登录');
        $userDetail['count_log_2'] = $this->countAdminLog($userDetail['id'], '设置');
        $userDetail['count_log_3'] = $this->countAdminLog($userDetail['id'], '分配');
        $userDetail['count_log_4'] = $this->countAdminLog($userDetail['id'], '添加');
        $userDetail['count_log_5'] = $this->countAdminLog($userDetail['id'], '编辑');
        $userDetail['count_log_6'] = $this->countAdminLog($userDetail['id'], '删除');

        $userDetail['userListMore'] = $this->userListMore($uk);

        return $userDetail;
    }

    // 根据id获取用户详情   \ar\core\service('arcz.User')->getUserById($uid);
    public function getUserById($uid)
    {
        $userCondition = ['id' => $uid];

        $userDetail = $this->arczdb->table(self::USER_TABLENAME)->where($userCondition)->queryRow();
        if($userDetail){
            // 存在User
            $userDetail['hasUser'] = 1;
            $userDetail['group'] = "";
            // 默认不是超级管理员
            $userDetail['isadmin1'] = 0;
            $urs = $this->arczdb->table(self::USER_GROUP_TABLENAME)
                ->where(['uid' => $userDetail['id']])
                ->order('gid')
                ->queryAll();
            if($urs){
                $roleName = $this->arczdb->table(self::GROUP_TABLENAME)->where(['id' => $urs[0]['gid']])->queryRow();
                $userDetail['group'] = $roleName['group_name'];
            }

            foreach($urs as $ur) {
                // 判断是否为超级管理员
                if($ur['gid']==1){
                    $userDetail['isadmin1'] = 1;
                }
            }

            $userDetail['isDev'] = 0;
            // 判断是否为开发者
            $dev = $this->isDev($userDetail['id']);
            if($dev){
                $userDetail['group'] = "开发者 ";
                $userDetail['isDev'] = 1;
            }
        } else {
            // 未找到User
            $userDetail['hasUser'] = 0;
        }

        return $userDetail;
    }

    // 根据用户id查找用户组id  \ar\core\service('arcz.User')->getRidByUid($uid);
    public function getRidByUid($uid)
    {
        $roleList = $this->arczdb->table(self::USER_GROUP_TABLENAME)
            ->where(['uid' => $uid])
            ->queryAll();
        return $roleList;

    }

    // 根据用户组id查找权限id  \ar\core\service('arcz.User')->getNidByRid($rid);
    public function getNidByRid($rid)
    {
        $navList = $this->arczdb->table(self::GROUP_NAV_TABLENAME)
            ->where(['gid' => $rid])
            ->queryAll();
        return $navList;

    }

    // 根据gid获取用户组所属的功能权限ids  \ar\core\service('arcz.User')->getFidByRid($gid,$mid);
    public function getFidByRid($gid,$mid)
    {
        return $this->arczdb->table(self::GROUP_FUNC_TABLENAME)->where(['gid' => $gid, 'mid' => $mid])->queryAll();
    }

    // 判断登录用户为开发者  \ar\core\service('arcz.User')->isDev($uid);
    public function isDev($uid)
    {
        return $this->arczdb->table(self::DEVELOPER_TABLENAME)->where(['uid' => $uid])->count();
    }

    // 生成用户验证key  \ar\core\service('arcz.User')->gUserkey($id);
    public function gUserkey($id)
    {
        $enAuthStr = $id . '-' . time();
        return \server\lib\ext\Cipher::encode($enAuthStr);
    }

    // 获取用户id  \ar\core\service('arcz.User')->getUserId($enStr);
    public function getUserId($enStr)
    {
        if (!$this->checkValidUserKey($enStr)) {
            return 0;
        } else {
            $deStr = \server\lib\ext\Cipher::decode($enStr);
            list($id, $time) = explode('-', $deStr);
            return $id;
        }
    }

    // 管理员列表  \ar\core\service('arcz.User')->userList($uk, $count, $page, $key);
    public function userList($uk, $count, $page, $key)
    {
        $condition = [];
        // 搜索
        $keyword = !empty($key) ? $key : '';
        if ($keyword) {
            $condition['nickname like '] = '%'. $keyword . '%';
        }
        $totalCount = $this->arczdb->table(self::USER_TABLENAME)->where($condition)->count();
        $pageObj = new \server\lib\ext\Page($totalCount, $count, $page);

        $users = $this->arczdb->table(self::USER_TABLENAME)
            ->where($condition)
            ->limit($pageObj->limit())
            ->order('id desc')
            ->queryAll();

        foreach($users as $user => $uv){
            $urs = $this->arczdb->table(self::USER_GROUP_TABLENAME)
                ->where(['uid' => $uv['id']])
                ->select('gid')
                ->queryAll();
            $check = '';

            $users[$user]['devuser'] = 0;
            $users[$user]['group'] = "";
            // 判断是否为开发者
            $dev = $this->isDev($uv['id']);
            if($dev){
                $users[$user]['devuser'] = 1;
                $users[$user]['group'] = "开发者 ";
                $check = 'checked';
            }

            foreach($urs as $key => $value) {
                $roleName = $this->arczdb->table(self::GROUP_TABLENAME)->where(['id' => $value['gid']])->queryRow();
                $urs[$key]['rname'] = $roleName['group_name'];
                $users[$user]['group'] = $users[$user]['group'] . " " . $urs[$key]['rname'];
            }
            $users[$user]['isdev'] = '<input type="checkbox" class="ace ace-switch ace-switch-6 dev_check" value="'.$uv['id'].'" name="isdev" '.$check.'><span class="lbl middle"></span>';
        }

        // 登录用户详情
        $userDetail = \ar\core\service('arcz.User')->getLoginUser($uk);
        // 判断当前登录用户是否为开发者
        $nowdev = $userDetail['isDev'];

        if($nowdev){
            $users = $users;
        } else {
            $usersnodev = [];
            foreach($users as &$user){
                if($user['devuser']==0){
                    array_push($usersnodev, $user);
                }
            }
            $users = $usersnodev;
        }

        $arr = get_object_vars($pageObj);
        $totalPages = $arr['totalPages'];
        if ($page > $totalPages) {
            $users = [];
        }

        return [
            'users' => $users,
            'totalCount' => $totalCount,
            'totalPages' => $totalPages
        ];
    }

    // 设置开发者开关  \ar\core\service('arcz.User')->isdevSetSwitch($id, $value, $uk, $loginip);
    public function isdevSetSwitch($id, $value, $uk, $loginip)
    {

        // 当前登录用户详情
        $userDetail = \ar\core\service('arcz.User')->getLoginUser($uk);

        $errCode = 1000;
        $errMsg = '';

        $uid = $userDetail['id'];
        // 被修改用户详情
        $adminUserDetail = $this->arczdb->table(self::USER_TABLENAME)->where(['id' => $id])->queryRow();
        if($userDetail['id'] == $id){
            $errCode = 6003;
            $errMsg = '不能设置当前用户';
        } else {
            if($value==0){ // 取消开发者
                // 日志记录参数
                $title = '取消开发者';
                $content = '管理员 ' . $userDetail['username'] . ' 取消开发者 ' . $adminUserDetail['username'];
            } else if($value==1){ // 设置开发者
                // 日志记录参数
                $title = '添加开发者';
                $content = '管理员 ' . $userDetail['username'] . ' 添加开发者 ' . $adminUserDetail['username'];
            }
            $setResult = \ar\core\service('arcz.User')->setSwitchNow($id, $value);
            if ($setResult) {
                // 日志记录
                \ar\core\service('arcz.Specialized')->addAdminLog($uid, $title, $content, $loginip);
                $errMsg = '操作成功';
            } else {
                $errCode = 6004;
                $errMsg = '操作失败';
            }
        }

        return ['errCode' => $errCode, 'errMsg' => $errMsg];

    }

    // 设置开发者  \ar\core\service('arcz.User')->setSwitchNow($id, $value);
    public function setSwitchNow($id, $value)
    {
        if($value == 1){
            return $this->arczdb->table(self::DEVELOPER_TABLENAME)
                ->insert(['uid' => $id, 'addtime' => time()]);
        } else if($value == 0){
            return $this->arczdb->table(self::DEVELOPER_TABLENAME)
                ->where(['uid' => $id])
                ->delete();
        }
    }

    // 添加管理员用户  \ar\core\service('arcz.User')->addUser($username, $nickname, $realname, $email, $tel, $uk, $loginip);
    public function addUser($username, $nickname, $realname, $email, $tel, $uk, $loginip)
    {
        // 当前登录用户详情
        $userDetail = \ar\core\service('arcz.User')->getLoginUser($uk);
        $uid = $userDetail['id'];

        $errCode = 1000;
        $errMsg = '';

        $title = '添加管理员';
        $content = '添加管理员 ' . $username;
        // 验证是否重名
        $hasUsername = $this->arczdb->table(self::USER_TABLENAME)->where(['username' => $username])->queryRow();
        if($hasUsername){
            $errCode = 1001;
            $errMsg = '添加用户失败，用户登录名 ' . $username . '已存在';
        } else {
            $password = $this->pwd(trim($username) . '123456');
            $data = [
                'username' => $username,
                'admin_face' => '/cooparcz/coop-arcz2.0/arcz/assets/images/avatars/newuser.jpg',
                'password' => trim($password),
                'nickname' => $nickname,
                'realname' => $realname,
                'email' => $email,
                'tel' => $tel,
                'register_time' => time()
            ];
            $addSuccess = $this->arczdb->table(self::USER_TABLENAME)->insert($data);
            if ($addSuccess) {
                $this->arczdb->table(self::USER_GROUP_TABLENAME)->insert(['uid' => $addSuccess, 'gid' => 2]); // 默认普通管理员
                // 日志记录
                \ar\core\service('arcz.Specialized')->addAdminLog($uid, $title, $content, $loginip);
                $errMsg = '添加成功，请分配角色';
            } else {
                $errCode = '1002';
                $errMsg = '添加管理员失败';
            }
        }

        return ['errCode' => $errCode, 'errMsg' => $errMsg];

    }

    // 编辑管理员用户  \ar\core\service('arcz.User')->editUser($id, $username, $nickname, $realname, $email, $tel, $uk, $loginip);
    public function editUser($id, $username, $nickname, $realname, $email, $tel, $uk, $loginip)
    {
        // 当前登录用户详情
        $userDetail = \ar\core\service('arcz.User')->getLoginUser($uk);
        $uid = $userDetail['id'];

        $errCode = 1000;
        $errMsg = '';

        $title = '编辑管理员';
        $content = '编辑管理员 ' . $username;

        $data = [
            'nickname' => $nickname,
            'realname' => $realname,
            'email' => $email,
            'tel' => $tel
        ];
        $addSuccess = $this->arczdb->table(self::USER_TABLENAME)->where(['id' => $id])->update($data);
        if ($addSuccess) {
            // 日志记录
            \ar\core\service('arcz.Specialized')->addAdminLog($uid, $title, $content, $loginip);
            $errMsg = '编辑成功';
        } else {
            $errCode = 2002;
            $errMsg = '编辑管理员失败';
        }

        return ['errCode' => $errCode, 'errMsg' => $errMsg];

    }

    // 删除管理员  \ar\core\service('arcz.User')->delAdmin($id, $uk, $loginip);
    public function delAdmin($id, $uk, $loginip)
    {
        // 当前登录用户详情
        $userDetail = \ar\core\service('arcz.User')->getLoginUser($uk);
        $nowid = $userDetail['id'];

        $errCode = 1000;
        $errMsg = '';

        // 判断是否可以删除
        $isadmin1 = 0;
        $urs = $this->arczdb->table(self::USER_GROUP_TABLENAME)
            ->where(['uid' => $id])
            ->select('gid')
            ->queryAll();
        foreach($urs as $ur) {
            $adminGroup = $this->arczdb->table(self::GROUP_TABLENAME)->where(['id' => $ur['gid']])->queryRow();
            if($adminGroup['id']==1 && $adminGroup['status']==0){
                $isadmin1 = 1;
            }
        }

        // 判断是否为开发者
        $isdev = 0;
        $devu = $this->arczdb->table(self::DEVELOPER_TABLENAME)->where(['uid' => $id])->queryRow();
        if($devu){
            $isdev = 1;
        }

        // 被删除用户详情
        $delUser = $this->arczdb->table(self::USER_TABLENAME)->where(['id' => $id])->queryRow();

        if($nowid == $id){
            $errCode = 3002;
            $errMsg = '删除失败,不能删除当前登录用户';
        } else if($isadmin1 == 1){
            $errCode = 3001;
            $errMsg = '删除失败,不能删除超级管理员';
        } else if($isdev == 1){
            $errCode = 3003;
            $errMsg = '删除失败,不能删除开发者';
        } else {
            $delResult = $this->arczdb->table(self::USER_TABLENAME)->where(['id' => $id])->delete();
            if ($delResult) {
                $this->arczdb->table(self::DEVELOPER_TABLENAME)->where(['uid' => $id])->delete();
                $this->arczdb->table(self::USER_GROUP_TABLENAME)->where(['uid' => $id])->delete();
                // 日志记录
                $title = '删除管理员';
                $content = '删除管理员 ' . $delUser['username'];
                \ar\core\service('arcz.Specialized')->addAdminLog($nowid, $title, $content, $loginip);
                $errMsg = '删除成功';
            } else {
                $errCode = 2002;
                $errMsg = '删除失败';
            }
        }

        return ['errCode' => $errCode, 'errMsg' => $errMsg];

    }

    // 分配用户组列表  \ar\core\service('arcz.User')->getUserRoleList($uid);
    public function getUserRoleList($uid)
    {
        $role = $this->arczdb->table(self::GROUP_TABLENAME)
            ->order('id')
            ->queryAll();

        foreach($role as &$r) {
            $ur = $this->arczdb->table(self::USER_GROUP_TABLENAME)
                ->where(['gid' => $r['id'], 'uid' => $uid])
                ->queryRow();
            if($ur){
                $r['check'] = 1;
            } else {
                $r['check'] = 0;
            }
            $r['uid'] = $uid;
        }

        $rolestr = '<table class="table table-hover table-striped"><thead><tr class="active"><th width="50%">角色名称</th><th width="50%">分配角色</th></tr></thead><tbody>';
        foreach($role as &$r){
            $rolestr .= '<tr>';
            $rolestr .= '<td>' . $r['group_name'] . '</td>';
            if($r['check']==1){
                $rolestr .= '<td id="btng_' . $r['id'] . '"><a id="r0id_' . $r['id'] . '" class="btn btn-danger btn-xs" title="点击取消分配角色">已分配</a></td>';
            } else {
                $rolestr .= '<td id="btng_' . $r['id'] . '"><a id="r1id_' . $r['id'] . '" class="btn btn-warning btn-xs" title="点击分配角色">分配</a></td>';
            }
            $rolestr .= '</tr>';
        }

        $rolestr .= '</tbody></talbe>';

        return ['rolestr' => $rolestr];
    }

    // 分配角色  \ar\core\service('arcz.User')->changeRole($uid, $role_id, $type, $uk, $loginip);
    public function changeRole($uid, $role_id, $type, $uk, $loginip)
    {
        // 当前登录用户详情
        $userDetail = \ar\core\service('arcz.User')->getLoginUser($uk);
        $nowid = $userDetail['id'];

        $errCode = 1000;
        $errMsg = '';

        $urDetail = [
            'uid' => $uid,
            'gid' => $role_id
        ];

        // 被分配用户详情
        $editUser = $this->arczdb->table(self::USER_TABLENAME)->where(['id' => $uid])->queryRow();
        // 被分配角色详情
        $groupDetail = $this->arczdb->table(self::GROUP_TABLENAME)->where(['id' => $role_id])->queryRow();

        if($type == 1){
            // 分配角色
            $result = $this->addUserRole($urDetail);
            if ($result) {
                // 日志记录
                $title = '分配角色';
                $content = '分配管理员 ' . $editUser['username'] .' 角色 ' . $groupDetail['group_name'];
                \ar\core\service('arcz.Specialized')->addAdminLog($nowid, $title, $content, $loginip);
                $errMsg = '分配成功';
            } else {
                $errCode = 5002;
                $errMsg = '分配失败';
            }
        } else if($type == 0){
            // 取消分配角色
            $result = $this->delUserRole($urDetail);
            if ($result) {
                // 日志记录
                $title = '取消分配角色';
                $content = '取消分配管理员 ' . $editUser['username'] .' 角色 ' . $groupDetail['group_name'];
                \ar\core\service('arcz.Specialized')->addAdminLog($nowid, $title, $content, $loginip);
                $errMsg = '取消分配成功';
            } else {
                $errCode = 5002;
                $errMsg = '取消分配失败';
            }
        }

        return ['errCode' => $errCode, 'errMsg' => $errMsg];

    }

    // 所有用户组列表  \ar\core\service('arcz.User')->getRoleList();
    public function getRoleList()
    {
        $role = $this->arczdb->table(self::GROUP_TABLENAME)
            ->order('id')
            ->queryAll();

        return $role;
    }

    // 添加用户组  \ar\core\service('arcz.User')->addRole($groupname, $uk, $loginip);
    public function addRole($groupname, $uk, $loginip)
    {
        // 当前登录用户详情
        $userDetail = \ar\core\service('arcz.User')->getLoginUser($uk);
        $uid = $userDetail['id'];

        $errCode = 1000;
        $errMsg = '';

        if($groupname!=""){
            $addSuccess = $this->arczdb->table(self::GROUP_TABLENAME)->insert(['group_name' => $groupname]);
            if ($addSuccess) {
                // 日志记录
                $title = '添加新管理员角色';
                $content = '添加管理员角色 ' . $groupname;
                \ar\core\service('arcz.Specialized')->addAdminLog($uid, $title, $content, $loginip);
                $errMsg = '添加成功';
            } else {
                $errCode = 1001;
                $errMsg = '添加失败';
            }
        } else {
            $errCode = 1002;
            $errMsg = '不能为空';
        }

        return ['errCode' => $errCode, 'errMsg' => $errMsg];

    }

    // 查找单个用户组  \ar\core\service('arcz.User')->getRoleRow($rid);
    public function getRoleRow($rid)
    {
        $role = $this->arczdb->table(self::GROUP_TABLENAME)->where(['id'=>$rid])->queryRow();
        if($role){
            $role['has'] = 1;
        } else {
            $role['has'] = 0;
        }
        return $role;
    }

    // 编辑用户组  \ar\core\service('arcz.User')->editRoleDo($id, $groupname, $uk, $loginip);
    public function editRoleDo($id, $groupname, $uk, $loginip)
    {
        // 当前登录用户详情
        $userDetail = \ar\core\service('arcz.User')->getLoginUser($uk);
        $uid = $userDetail['id'];

        $errCode = 1000;
        $errMsg = '';

        $result = $this->arczdb->table(self::GROUP_TABLENAME)
            ->where(['id' => $id])
            ->update(['group_name' => $groupname]);

        if ($result) {
            // 日志记录
            $title = '编辑管理员角色';
            $content = '编辑管理员角色 角色id: ' . $id;
            \ar\core\service('arcz.Specialized')->addAdminLog($uid, $title, $content, $loginip);
            $errMsg = '编辑成功';
        } else {
            $errCode = 1001;
            $errMsg = '编辑失败';
        }

        return ['errCode' => $errCode, 'errMsg' => $errMsg];

    }

    // 删除用户组  \ar\core\service('arcz.User')->delRole($id, $uk, $loginip);
    public function delRole($id, $uk, $loginip)
    {
        // 当前登录用户详情
        $userDetail = \ar\core\service('arcz.User')->getLoginUser($uk);
        $uid = $userDetail['id'];

        $errCode = 1000;
        $errMsg = '';

        $delResult = $this->delGroup($id);
        if ($delResult) {
            // 日志记录
            $title = '删除管理员角色';
            $content = '删除管理员角色 角色id: ' . $id;
            \ar\core\service('arcz.Specialized')->addAdminLog($uid, $title, $content, $loginip);
            $errMsg = '删除成功';
        } else {
            $errCode = 1001;
            $errMsg = '删除失败';
        }

        return ['errCode' => $errCode, 'errMsg' => $errMsg];

    }

    // 权限列表  \ar\core\service('arcz.User')->getRoleNavList($rid);
    public function getRoleNavList($rid)
    {
        $navsList = \ar\core\service('arcz.Nav')->navslist();
        $navs = $navsList['navs'];
        foreach($navs as $key => $value){
            if($navs[$key]['children_code']==1){
                $navs[$key]['check'] = 2;
            } else if($navs[$key]['children_code']==0 && $navs[$key]['href']=="" && $navs[$key]['cate']==1){
                $navs[$key]['check'] = 2;
            } else if($navs[$key]['children_code']==0 && $navs[$key]['href']=="" && $navs[$key]['mid']<=0 && $navs[$key]['cate']==2){
                $navs[$key]['check'] = 2;
            } else if($navs[$key]['children_code']==0 && $navs[$key]['href']=="" && $navs[$key]['mid']==null && $navs[$key]['cate']==2){
                $navs[$key]['check'] = 2;
            } else {
                $rn = $this->arczdb->table(self::GROUP_NAV_TABLENAME)
                    ->where(['nid' => $navs[$key]['id'], 'gid' => $rid])
                    ->queryRow();
                if($rn){
                    $navs[$key]['check'] = 1;
                } else {
                    $navs[$key]['check'] = 0;
                }
            }

            $navs[$key]['gid'] = $rid;
        }

        foreach($navs as &$r){
            if($r['cate']==2){
                $r['title'] = '-' . $r['title'];
            } else if($r['cate']==3){
                $r['title'] = '- -' . $r['title'];
            }
        }

        $rolestr = '<table class="table table-hover table-striped"><thead><tr class="active"><th width="50%">权限名称</th><th width="50%">分配权限</th></tr></thead><tbody>';
        foreach($navs as &$r){
            if($r['isdev']==0){
                $rolestr .= '<tr>';
                $rolestr .= '<td>' . $r['title'] . '</td>';
                if($r['check']==2) {
                    $rolestr .= '<td></td>';
                } else if($r['check']==1){
                    $rolestr .= '<td id="btng_' . $r['id'] . '"><a id="n0id_' . $r['id'] . '" class="btn btn-danger btn-xs" title="点击取消分配权限">已分配</a></td>';
                } else {
                    $rolestr .= '<td id="btng_' . $r['id'] . '"><a id="n1id_' . $r['id'] . '" class="btn btn-warning btn-xs" title="点击分配权限">分配</a></td>';
                }
                $rolestr .= '</tr>';
            }
        }

        $rolestr .= '</tbody></talbe>';

        return ['rolestr' => $rolestr];
    }

    // 分配用户组权限  \ar\core\service('arcz.User')->changeRoleNav($rid, $nav_id, $type, $uk, $loginip);
    public function changeRoleNav($rid, $nav_id, $type, $uk, $loginip)
    {
        // 当前登录用户详情
        $userDetail = \ar\core\service('arcz.User')->getLoginUser($uk);
        $nowid = $userDetail['id'];

        $errCode = 1000;
        $errMsg = '';

        $rnDetail = [
            'nid' => $nav_id,
            'gid' => $rid
        ];

        // 被分配角色详情
        $groupDetail = $this->arczdb->table(self::GROUP_TABLENAME)->where(['id' => $rid])->queryRow();
        // 被分配菜单详情
        $navDetail = $this->arczdb->table(self::NAV_TABLENAME)->where(['id' => $nav_id])->queryRow();

        if($type == 1){
            // 分配权限
            $result = $this->addRoleNav($rnDetail);
            if ($result) {
                // 日志记录
                $title = '分配权限';
                $content = '分配管理员组 ' . $groupDetail['group_name'] .' 操作菜单 ' . $navDetail['title'] . ' 的权限';
                \ar\core\service('arcz.Specialized')->addAdminLog($nowid, $title, $content, $loginip);
                $errMsg = '分配成功';
            } else {
                $errCode = 1001;
                $errMsg = '分配失败';
            }
        } else if($type == 0){
            // 取消分配权限
            $result = $this->delRoleNav($rnDetail);
            if ($result) {
                // 日志记录
                $title = '取消分配权限';
                $content = '取消分配管理员组 ' . $groupDetail['group_name'] .' 操作菜单 ' . $navDetail['title'] . ' 的权限';
                \ar\core\service('arcz.Specialized')->addAdminLog($nowid, $title, $content, $loginip);
                $errMsg = '取消分配成功';
            } else {
                $errCode = 2001;
                $errMsg = '取消分配失败';
            }
        }

        return ['errCode' => $errCode, 'errMsg' => $errMsg];

    }

    // 个人中心编辑资料  \ar\core\service('arcz.User')->editUserInfo($uk, $nickname, $realname, $age, $tel, $email, $website, $admin_content, $qq, $wx, $weibo, $ip);
    public function editUserInfo($uk, $nickname, $realname, $age, $tel, $email, $website, $admin_content, $qq, $wx, $weibo, $ip)
    {
        // 当前登录用户详情
        $userDetail = \ar\core\service('arcz.User')->getLoginUser($uk);
        $id = $userDetail['id'];

        $errCode = 1000;
        $errMsg = '';

        $data = [
            'nickname' => $nickname,
            'realname' => $realname,
            'age' => $age,
            'tel' => $tel,
            'email' => $email,
            'website' => $website,
            'admin_content' => $admin_content,
            'qq' => $qq,
            'wx' => $wx,
            'weibo' => $weibo
        ];

        $update = $this->arczdb->table(self::USER_TABLENAME)->where(['id' => $id])->update($data);
        if($update){
            // 日志记录
            $title = '修改个人资料';
            $content = '管理员 ' . $userDetail['username'] .' 修改个人资料 ';
            \ar\core\service('arcz.Specialized')->addAdminLog($id, $title, $content, $ip);
            $errMsg = '修改用户资料成功';
        } else {
            $errCode = 1001;
            $errMsg = '修改用户资料失败！';
        }

        return ['errCode' => $errCode, 'errMsg' => $errMsg];

    }

    // 个人中心修改密码  \ar\core\service('arcz.User')->changePwd($uk, $oldPwd, $newPwd, $new2Pwd, $ip);
    public function changePwd($uk, $oldPwd, $newPwd, $new2Pwd, $ip)
    {
        // 当前登录用户详情
        $userDetail = \ar\core\service('arcz.User')->getLoginUser($uk);
        $nowid = $userDetail['id'];

        $errCode = 1000;
        $errMsg = '';

        if($oldPwd == $newPwd){
            $errCode = 1004;
            $errMsg = '不能与旧密码相同';
        } else if(strlen($newPwd) < 6){
            $errCode = 1003;
            $errMsg = '密码长度不能小于6位';
        } else if($newPwd != $new2Pwd){
            $errCode = 1002;
            $errMsg = '两次输入密码不一致，请重新输入！';
        } else {
            $userConditon = [
                'id' => $nowid,
                'password' => $this->pwd($oldPwd),
            ];
            $userCount = $this->arczdb->table(self::USER_TABLENAME)->where($userConditon)->queryRow();
            if($userCount){
                $update = $this->arczdb->table(self::USER_TABLENAME)->where(['id' => $nowid])->update(['password' => $this->pwd($newPwd)]);
                if($update){
                    // 日志记录
                    $title = '修改密码';
                    $content = '管理员 ' . $userDetail['username'] .' 修改密码 ';
                    \ar\core\service('arcz.Specialized')->addAdminLog($nowid, $title, $content, $ip);
                    $errMsg = '修改密码成功';
                } else {
                    $errCode = 1005;
                    $errMsg = '修改密码失败！';
                }
            } else {
                $errCode = 1001;
                $errMsg = '旧密码不正确，修改密码失败！';
            }
        }

        return ['errCode' => $errCode, 'errMsg' => $errMsg];
    }

    // 分配角色权限
    public function addRoleNav($rnDetail)
    {
        return $this->arczdb->table(self::GROUP_NAV_TABLENAME)->insert($rnDetail);
    }

    // 取消分配角色权限
    public function delRoleNav($rnDetail)
    {
        return $this->arczdb->table(self::GROUP_NAV_TABLENAME)->where($rnDetail)->delete();
    }

    // 删除用户组操作
    public function delGroup($id)
    {
        $role = $this->arczdb->table(self::GROUP_TABLENAME)->where(['id' => $id])->queryRow();
        if($role['status']==1){
            $this->arczdb->table(self::USER_GROUP_TABLENAME)->where(['gid'=>$id])->delete();
            $this->arczdb->table(self::GROUP_NAV_TABLENAME)->where(['gid'=>$id])->delete();
            $this->arczdb->table(self::GROUP_FUNC_TABLENAME)->where(['gid'=>$id])->delete();
            $del = $this->arczdb->table(self::GROUP_TABLENAME)->where(['id' => $id])->delete();
            return $del;
        } else {
            return false;
        }

    }

    // 分配用户角色
    public function addUserRole($urDetail)
    {
        return $this->arczdb->table(self::USER_GROUP_TABLENAME)->insert($urDetail);
    }

    // 取消分配用户角色
    public function delUserRole($urDetail)
    {
        return $this->arczdb->table(self::USER_GROUP_TABLENAME)->where($urDetail)->delete();
    }

    // 加密方式
    public function pwd($str = 'hello,arphp')
    {
        return md5(substr(md5(md5($str) . 'arcz'), 6, 6));
    }

    // 个人中心查看其他管理员
    public function userListMore($uk)
    {

        $users = $this->arczdb->table(self::USER_TABLENAME)
            ->order('id desc')
            ->queryAll();

        foreach($users as $user => $uv){
            $urs = $this->arczdb->table(self::USER_GROUP_TABLENAME)
                ->where(['uid' => $uv['id']])
                ->select('gid')
                ->queryAll();

            $users[$user]['devuser'] = 0;
            $users[$user]['group'] = "";
            // 判断是否为开发者
            $dev = $this->isDev($uv['id']);
            if($dev){
                $users[$user]['devuser'] = 1;
                $users[$user]['group'] = "开发者 ";
            }

            foreach($urs as $key => $value) {
                $roleName = $this->arczdb->table(self::GROUP_TABLENAME)->where(['id' => $value['gid']])->queryRow();
                $urs[$key]['rname'] = $roleName['group_name'];
                $users[$user]['group'] = $users[$user]['group'] . " " . $urs[$key]['rname'];
            }

            $users[$user]['login_date'] = $this->getDateDiff($users[$user]['login_time']);
        }

        // 登录用户详情
        $userDetail = \ar\core\service('arcz.User')->getLoginUser($uk);
        // 判断当前登录用户是否为开发者
        $nowdev = $userDetail['isDev'];

        if($nowdev){
            $users = $users;
        } else {
            $usersnodev = [];
            foreach($users as &$user){
                if($user['devuser']==0){
                    array_push($usersnodev, $user);
                }
            }
            $users = $usersnodev;
        }

        return $users;
    }

    // 个人中心获取管理员操作记录
    public function getLogList($uk, $count, $page)
    {
        // 登录用户详情
        $userDetail = \ar\core\service('arcz.User')->getLoginUser($uk);

        $isDev = $userDetail['isDev'];
        if($isDev==1){
            $condition['is_dev'] = [0,1];
        } else {
            $condition['is_dev'] = 0;
        }

        $totalCount =  $this->arczdb->table(self::LOG_TABLENAME)->where($condition)->count();
        $pageObj = new \server\lib\ext\Page($totalCount, $count, $page);

        $logLists = $this->arczdb->table(self::LOG_TABLENAME)
            ->where($condition)
            ->limit($pageObj->limit())
            ->order('id desc')
            ->queryAll();

        foreach($logLists as &$l){
            $userInfo = $this->getUserById($l['uid']);
            if($userInfo){
                $l['log_date'] = $this->getDateDiff($l['log_time']);
                $l['admin_face'] = $userInfo['admin_face'];
            } else {
                $l['log_date'] = '...';
                $l['admin_face'] = '/cooparcz/coop-arcz2.0/arcz/assets/images/avatars/newuser.jpg';
            }
        }

        return $logLists;

    }

    // 个人中心按关键字获取操作日志数量
    public function countAdminLog($uid, $keyword)
    {
        $condition = ['uid' => $uid];
        $like = 'title like';
        $condition[$like] = '%'. $keyword . '%';

        $totalCount =  $this->arczdb->table(self::LOG_TABLENAME)->where($condition)->count();

        return $totalCount;
    }

    // 用户修改头像  \ar\core\service('arcz.User')->editUserFace($uid, $img);
    public function editUserFace($uid, $img)
    {
        $errCode = 1000;
        $errMsg = '';
        $userCondition = ['id' => $uid];
        $upload = $this->arczdb->table(self::USER_TABLENAME)->where($userCondition)->update(['admin_face' => $img]);

        if($upload){
            $errMsg = '上传成功';
        } else {
            $errCode = 1001;
            $errMsg = '上传失败';
        }

        return ['errCode' => $errCode, 'errMsg' => $errMsg];
    }

    // checkValidKey
    public function checkValidUserKey($enStr)
    {
        $deStr = \server\lib\ext\Cipher::decode($enStr);
        if (!$deStr || strpos($deStr, '-') === false) {
            return false;
        } else {
            list($id, $time) = explode('-', $deStr);
            $time = (int)$time;
            if ($time + \ar\core\cfg('USER_VALID_TIME') < time()) {
                return false;
            } else {
                return true;
            }
        }
    }

    // 获取单个功能  \ar\core\service('arcz.User')->getMenuFuncRow($mid, $type, $id);
    public function getMenuFuncRow($mid, $type, $id)
    {
        // 对应功能信息
        if($type!=0){
            $menuFunc = $this->arczdb->table(self::MODEL_MENUFUNC_TABLENAME)
                ->where(['mid' => $mid, 'type' => $type])
                ->queryRow();
        } else {
            $menuFunc = $this->arczdb->table(self::MODEL_MENUFUNC_TABLENAME)
                ->where(['id' => $id, 'mid' => $mid, 'type' => $type])
                ->queryRow();
        }

        $check = '';
        // 判断是否开启功能
        $status = $menuFunc['status'];
        if($status==1){
            $check = 'checked';
        }
        $switchstr = '<input type="checkbox" class="ace ace-switch ace-switch-6" id="switch_status" value="'.$menuFunc['id'].'" name="status" '.$check.'><span class="lbl middle"></span>';

        return ['switchstr' => $switchstr];
    }

    // 分配用户组功能列表  \ar\core\service('arcz.User')->getUserRoleFuncList($mid, $type, $id);
    public function getUserRoleFuncList($mid,$type,$id)
    {
        // 所有权限
        $role = $this->arczdb->table(self::GROUP_TABLENAME)
            ->order('id')
            ->queryAll();
        // 对应功能信息
        if($type!=0){
            $menuFunc = $this->arczdb->table(self::MODEL_MENUFUNC_TABLENAME)->where(['mid' => $mid, 'type' => $type])->queryRow();
        } else {
            $menuFunc['id'] = $id;
        }


        $fid = $menuFunc['id'];

        foreach($role as $key => $value) {
            $ur = $this->arczdb->table(self::GROUP_FUNC_TABLENAME)
                ->where(['gid' => $role[$key]['id'], 'mid' => $mid, 'fid' => $fid])
                ->queryRow();
            if($ur){
                $role[$key]['check'] = 1;
            } else {
                $role[$key]['check'] = 0;
            }
            $role[$key]['mid'] = $mid;
            $role[$key]['fid'] = $fid;
            $role[$key]['functype'] = $type;
        }

        $rolestr = '<table class="table table-hover table-striped"><thead><tr class="active"><th width="50%">角色名称</th><th width="50%">分配功能</th></tr></thead><tbody>';
        foreach($role as &$r){
            $rolestr .= '<tr>';
            $rolestr .= '<td>' . $r['group_name'] . '</td>';
            if($r['check']==1){
                $rolestr .= '<td id="btng_' . $r['id'] . '"><a id="rf0id_' . $r['id'] . '" class="btn btn-danger btn-xs" title="点击取消分配功能">已分配</a>
                <input class="mid" type="hidden" value="' . $r['mid'] . '">
                <input class="fid" type="hidden" value="' . $r['fid'] . '">
                <input class="functype" type="hidden" value="' . $r['functype'] . '"></td>';
            } else {
                $rolestr .= '<td id="btng_' . $r['id'] . '"><a id="rf1id_' . $r['id'] . '" class="btn btn-warning btn-xs" title="点击分配功能">分配</a>
                <input class="mid" type="hidden" value="' . $r['mid'] . '">
                <input class="fid" type="hidden" value="' . $r['fid'] . '">
                <input class="functype" type="hidden" value="' . $r['functype'] . '"></td>';
            }
            $rolestr .= '</tr>';
        }

        $rolestr .= '</tbody></talbe>';

        return ['rolestr' => $rolestr];

    }

    // 分配用户组相关功能  \ar\core\service('arcz.User')->changeRoleFunc($role_id, $type, $mid, $fid, $functype, $uk, $loginip);
    public function changeRoleFunc($role_id, $type, $mid, $fid, $functype, $uk, $loginip)
    {
        // 当前登录用户详情
        $userDetail = \ar\core\service('arcz.User')->getLoginUser($uk);

        $errCode = 1000;
        $errMsg = '';

        $uid = $userDetail['id'];
        // 判断当前管理员是否为开发者
        $isDev = $userDetail['isDev'];
        if($isDev==1){
            $urDetail = [
                'gid' => $role_id,
                'mid' => $mid,
                'fid' => $fid
            ];

            // 被分配角色详情
            $groupDetail = $this->arczdb->table(self::GROUP_TABLENAME)->where(['id' => $role_id])->queryRow();
            // 被分配模型详情
            $modelDetail = $this->arczdb->table(self::MODELLIST_TABLENAME)->where(['id' => $mid])->queryRow();
            // 被分配功能详情
            $funcDetail = $this->arczdb->table(self::MODEL_MENUFUNC_TABLENAME)->where(['id' => $fid])->queryRow();

            if($type == 1){
                // 分配角色功能
                $result = \ar\core\service('arcz.User')->addUserRoleFunc($urDetail);
                if ($result) {
                    // 日志记录
                    $title = '分配角色操作功能';
                    $content = '分配管理员组 ' . $groupDetail['group_name'] .' 模型 ' . $modelDetail['modelname'] . ' 操作功能 ' . $funcDetail['title'] . ' 的权限';
                    \ar\core\service('arcz.Specialized')->addAdminLog($uid, $title, $content, $loginip);
                    $errMsg = '分配成功';
                } else {
                    $errCode = 6002;
                    $errMsg = '分配失败';
                }
            } else if($type == 0){
                // 取消分配角色功能
                $result = \ar\core\service('arcz.User')->delUserRoleFunc($urDetail);
                if ($result) {
                    // 日志记录
                    $title = '取消分配角色操作功能';
                    $content = '取消分配管理员组 ' . $groupDetail['group_name'] .' 模型 ' . $modelDetail['modelname'] . ' 操作功能 ' . $funcDetail['title'] . ' 的权限';
                    \ar\core\service('arcz.Specialized')->addAdminLog($uid, $title, $content, $loginip);
                    $errMsg = '取消分配成功';
                } else {
                    $errCode = 6002;
                    $errMsg = '取消分配失败';
                }
            }
        } else {
            $errCode = 2550;
            $errMsg = '非法操作！';
        }

        return ['errCode' => $errCode, 'errMsg' => $errMsg];
    }

    // 分配角色功能  \ar\core\service('arcz.User')->addUserRoleFunc($urDetail);
    public function addUserRoleFunc($urDetail)
    {
        return $this->arczdb->table(self::GROUP_FUNC_TABLENAME)->insert($urDetail, 1);
    }

    // 取消分配角色功能  \ar\core\service('arcz.User')->delUserRoleFunc($urDetail);
    public function delUserRoleFunc($urDetail)
    {
        return $this->arczdb->table(self::GROUP_FUNC_TABLENAME)->where($urDetail)->delete();
    }





}

<?php

namespace server\ctl\arcz\service;
/**
 * 显示样式
 */
class View extends Base
{

    // 获取系统设定信息  \ar\core\service('arcz.View')->getSystemSetting();
    public function getSystemSetting()
    {
        return $this->arczdb->table(self::SYSTEM_SETTING_TABLENAME)->queryRow();
    }

    // 设定登录背景颜色  \ar\core\service('arcz.View')->setLoginBg($num);
    public function setLoginBg($num)
    {
        return $this->arczdb->table(self::SYSTEM_SETTING_TABLENAME)->update(['loginbgnum' => $num]);
    }



}

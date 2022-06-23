<?php

namespace server\ctl\arcz\service;
/**
 * 显示样式
 */
class Web extends Base
{

    // 获取系统设定信息  \ar\core\service('server.arcz.Web')->getHostInfoByMark($mark);
    public function getHostInfoByMark($mark)
    {
        $errMsg = ['errMsg' => '', 'data' => []];

        $info = \server\lib\model\sg2\Sysinfo::model()
            ->getDb()
            ->where(['mark' => $mark])
            ->queryRow();


        if (!$info) {
            $errMsg['errMsg'] = '站点不存在';
        } else {
            $video = \server\lib\model\sg2\Sysvideo::model()
                ->getDb()
                ->where(['sysid' => $info['id']])
                ->queryRow();

            $picList = \server\lib\model\sg2\Sysshot::model()
                ->getDb()
                ->where(['sysid' => $info['id']])
                ->order('oindex desc')
                ->queryAll();

            foreach ($picList as &$pic) {
                $pic['shoturl'] = $info['sitehost'] . $pic['shoturl'];
            }

            $video['videourl'] = $info['sitehost'] . $video['videourl'];
            $video['vbg'] = $info['sitehost'] . $video['vbg'];

            $info['firstshowimg'] = $picList[0]['shoturl'];

            $info['site_icon'] = $info['sitehost'] . $info['site_icon'];

            $info['kf_wechat'] = $info['sitehost'] . $info['kf_wechat'];
            $info['headerbg'] = $info['sitehost'] . $info['headerbg'];

            $info['video'] = $video;
            $info['pics'] = $picList;
            $errMsg['data'] = $info;

        }

        return $errMsg;

    }

    // \ar\core\service('server.arcz.Web')->copySiteInfo($infoid);
    public function copySiteInfo($infoid)
    {
        $errMsg = ['errMsg' => '', 'retMsg' => ''];
        $info = \server\lib\model\sg2\Sysinfo::model()
            ->getDb()
            ->where(['id' => $infoid])
            ->queryRow();


        if (!$info) {
            $errMsg['errMsg'] = '站点不存在';
        } else {
            $newinfo = $info;
            unset($newinfo['id']);

            $newinfo['sysname'] = $info['sysname'] . $info['id'] . '_复制' . time();
            $newid = \server\lib\model\sg2\Sysinfo::model()
                ->getDb()
                ->insert($newinfo);


            $videos = \server\lib\model\sg2\Sysvideo::model()
                ->getDb()
                ->where(['sysid' => $info['id']])
                ->queryAll();

            foreach ($videos as $video) {
                $newvideo = $video;
                unset($newvideo['id']);
                $newvideo['sysid'] = $newid;
                \server\lib\model\sg2\Sysvideo::model()
                    ->getDb()
                    ->insert($newvideo);
            }

            $picLists = \server\lib\model\sg2\Sysshot::model()
                ->getDb()
                ->where(['sysid' => $info['id']])
                ->queryAll();
            

            foreach ($picLists as $pic) {
                $newpic = $pic;
                unset($newpic['id']);
                $newpic['sysid'] = $newid;
                \server\lib\model\sg2\Sysshot::model()
                    ->getDb()
                    ->insert($newpic);
            }
            $errMsg['retMsg'] = 'copy succ';
        }

        return $errMsg;
    }

}

<?php
/**
 * 前端基于layuicms2.0 ，后端基于arphp 5.1.14
 *
 * @author assnr assnr@coopcoder.com
 *
 * 本项目仅供学习交流使用，如果用于商业请联系授权
 */
namespace arcz\ctl\main;

use \ar\core\ApiController as Controller;

// json 接口
class Json extends Base
{

    /**需要做验证的接口**/

    ###############


    // 富文本编辑器中上传图片
    public function uploadImgByArtice()
    {
        $filestr = date('YmdHis',time());
        // 上传图片
        $dstDir = AR_ROOT_PATH . 'arcz/assets/adminUpload/articeimg/' . $filestr . '/';
        $picName = \ar\core\comp('ext.upload')->upload('file',$dstDir,'img');

        $serverName = \ar\core\comp('url.route')->serverName();
        $path = $serverName . \ar\core\cfg('PATH.GPUBLIC') . 'adminUpload/articeimg/' . $filestr . '/' . $picName['filename'];

        $backJson = [
            'code' => 0,
            'msg' => '',
            'data' => ['src' => $path]
        ];

        if($path){
            $this->showJson($backJson,['data'=>true]);
            return;
        }
    }

}

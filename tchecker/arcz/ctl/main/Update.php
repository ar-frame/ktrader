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

/**
 * 更新控制器
 */
class Update extends Base
{
    // 更新文件
    public function updateRaw($name, $version, $filename)
    {
        $edition = \ar\core\cfg('czweb_version');
        if (version_compare($edition, $version, '<')) {
            $api = 'https://api.coopcoder.com/Update/getFileRawData';
            try {
                $resource = \ar\core\comp('rpc.api')->remoteCall($api, 
                    ['name' => $name, 'filename' => $filename, 'version' => $version], 'post');
                if (strpos($resource, '{"ret_code"') === 0) {
                    $serverResult = json_decode($resource, true);
                    $this->showJsonError($serverResult['ret_msg'], 1001, ['filename' => $filename]);
                } else {
                    $updatePath = AR_ORI_PATH;
                    if (!is_dir($updatePath)) {
                        $this->showJsonError('ori path is not existed', 1001, ['filename' => $updateFile]);
                        return;
                    }
                    $updateFile = $updatePath . $filename; 
                    if (is_file($updateFile)) {
                    } else {
                        $upDir = dirname($updateFile);
                        if (!is_dir($upDir)) {
                            mkdir($upDir, 0777, true);
                        }                     
                        touch($updateFile);
                    }
                    if (is_writable($updateFile)) {
                        file_put_contents($updateFile, $resource);
                        $this->showJson(['filename' => $filename]);
                    } else {
                        $this->showJsonError('文件更新错误' . $edition . '升级版本' . $version . ' ', 1011, ['filename' => $updateFile]);
                    }
                }

            } catch(\Execption $e) {
                echo 'net work err';
            }

        } else {
            $this->showJsonError('版本对比冲突：线上版本' . $edition . '升级版本' . $version . ' ', 1011, ['filename' => $filename]);
        }
    }

    // 设置
    public function setUpdateSuccEdition($version)
    {
        $edition = \ar\core\cfg('czweb_version');

        if (version_compare($edition, $version, '<')) {
            $asonFile = AR_ROOT_PATH . 'ar.ason';
            if (is_writable($asonFile)) {
                $asonFileContent = file_get_contents($asonFile);
                $newFileContent = str_replace($edition, $version, $asonFileContent);
                file_put_contents($asonFile, $newFileContent);
                $this->showJsonSuccess('更新成功');

            } else {
                $this->showJsonError($asonFile . '配置文件不可写');
            }
        } else {
            $this->showJsonError('已经是最新版本');
        }

    }

    // 检查版本
    public function checkVersion() 
    {
        $this->display();
    }
}
<?php
/**
 * 前端基于layuicms2.0 ，后端基于arphp 5.1.14
 *
 * @author assnr assnr@coopcoder.com
 *
 * 本项目仅供学习交流使用，如果用于商业请联系授权
 */
namespace arcz\ctl\main;
/**
 * 自定义功能接口控制器，在此编写自定义功能接口
 */
class CostomFunc extends Base
{
    public function init($notCheckAction = [])
    {
        $notCheckAction = [

        ];
        parent::init($notCheckAction);

    }

    // 自定义功能权限验证接口
    public function queryCostomFunc($mid, $type, $href, $uk)
    {
        $apiname = 'Ws'.'server.ctl.arcz.Specialized';
        $isFunc = \ar\core\comp('rpc.service')->$apiname("queryFuncByCon",array ($mid, $type, $href, $uk));
        return $isFunc;
    }


    /**
     * 自定义功能控制器函数示例写法
     * 所有自定义功能按照下面示例写
     * 需要先进行权限验证
     * 以下适用基于模型生成的自定义功能
     */

    // 示例 1
    public function haha()
    {
        // 接收到的数据
        $request = \ar\core\request();
        $mid = $request['mid']; // 模型id
        $type = $request['type']; // 功能类型
        $href = $request['href']; // api名称

        // 获取uk
        $uk = $this->getUserService()->getUk();
        // 先进行权限验证
        $isFunc = $this->queryCostomFunc($mid, $type, $href, $uk);
        if($isFunc){
            // 验证通过
            $id = $request['res']; // 字段唯一键
            var_dump($request);
            // 根据获取的数据进行下一步操作

        } else {
            // 验证不通过
            $this->display('/404');
        }
    }

    // 示例 2
    public function alg()
    {
        // 接收到的数据
        $request = \ar\core\request();
        $mid = $request['mid']; // 模型id
        $type = $request['type']; // 功能类型
        $href = $request['href']; // api名称

        // 获取uk
        $uk = $this->getUserService()->getUk();
        // 先进行权限验证
        $isFunc = $this->queryCostomFunc($mid, $type, $href, $uk);
        if($isFunc){
            // 验证通过
            $id = $request['res']; // 字段唯一键
            var_dump($request);
            // 根据获取的数据进行下一步操作

        } else {
            // 验证不通过
            $this->display('/404');
        }
    }

    // 示例 3
    public function ji()
    {
        // 接收到的数据
        $request = \ar\core\request();
        $mid = $request['mid']; // 模型id
        $type = $request['type']; // 功能类型
        $href = $request['href']; // api名称

        // 获取uk
        $uk = $this->getUserService()->getUk();
        // 先进行权限验证
        $isFunc = $this->queryCostomFunc($mid, $type, $href, $uk);
        if($isFunc){
            // 验证通过
            $id = $request['res']; // 字段唯一键
            var_dump($request);
            // 根据获取的数据进行下一步操作

        } else {
            // 验证不通过
            $this->display('/404');
        }
    }

    // 示例 4
    public function ni()
    {
        // 接收到的数据
        $request = \ar\core\request();
        $mid = $request['mid']; // 模型id
        $type = $request['type']; // 功能类型
        $href = $request['href']; // api名称

        // 获取uk
        $uk = $this->getUserService()->getUk();
        // 先进行权限验证
        $isFunc = $this->queryCostomFunc($mid, $type, $href, $uk);
        if($isFunc){
            // 验证通过
            $id = $request['res']; // 字段唯一键
            var_dump($request);
            // 根据获取的数据进行下一步操作

        } else {
            // 验证不通过
            $this->display('/404');
        }
    }

    // 示例 5
    public function tai()
    {
        // 接收到的数据
        $request = \ar\core\request();
        $mid = $request['mid']; // 模型id
        $type = $request['type']; // 功能类型
        $href = $request['href']; // api名称

        // 获取uk
        $uk = $this->getUserService()->getUk();
        // 先进行权限验证
        $isFunc = $this->queryCostomFunc($mid, $type, $href, $uk);
        if($isFunc){
            // 验证通过
            $id = $request['res']; // 字段唯一键
            var_dump($request);
            // 根据获取的数据进行下一步操作

        } else {
            // 验证不通过
            $this->display('/404');
        }
    }

    // 示例 6
    public function mei()
    {
        // 接收到的数据
        $request = \ar\core\request();
        $mid = $request['mid']; // 模型id
        $type = $request['type']; // 功能类型
        $href = $request['href']; // api名称

        // 获取uk
        $uk = $this->getUserService()->getUk();
        // 先进行权限验证
        $isFunc = $this->queryCostomFunc($mid, $type, $href, $uk);
        if($isFunc){
            // 验证通过
            $id = $request['res']; // 字段唯一键
            var_dump($request);
            // 根据获取的数据进行下一步操作

        } else {
            // 验证不通过
            $this->display('/404');
        }
    }


    /**  copySiteInfo   **/
    public function copySiteInfo()
    {
        // 接收到的数据
        $request = \ar\core\request();
        $mid = $request['mid']; // 模型id
        $type = $request['type']; // 功能类型
        $href = $request['href']; // api名称

        // 获取uk
        $uk = $this->getUserService()->getUk();
        // 先进行权限验证
        $isFunc = $this->queryCostomFunc($mid, $type, $href, $uk);
        if($isFunc){
            // 验证通过
            $id = $request['res']; // 字段唯一键
            // var_dump($id);
            // 根据获取的数据进行下一步操作

            $apiname = 'Ws'.'server.ctl.arcz.Web';
            $ret = \ar\core\comp('rpc.service')->$apiname("copySiteInfo", [$id]);
            var_dump($ret);

        } else {
            // 验证不通过
            $this->display('/404');
        }
    }


}

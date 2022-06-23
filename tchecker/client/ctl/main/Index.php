<?php
/**
 * Powerd by ArPHP.
 *
 * default Controller.
 *
 */
namespace client\ctl\main;
use \ar\core\Controller as Controller;
/**
 * Default Controller of webapp.
 */
class Index extends Controller
{
    /**
     * 客户端调试器
     *
     * @return void
     */
    public function index()
    {
        try {
            $returnData = '';
            $showFunc = '';
            $funcName = \ar\core\request('funcname');
            $apiname = \ar\core\request('name');
            $params = \ar\core\request('params');
           
            if ($funcName  && $apiname) :
                
                if (strlen($params) > 0) :
                    $params = explode('|', $params);
                else :
                    $params = [];
                endif;
                
               
                $paramsStr = var_export($params, 1);
                

                $showFunc = <<<sfunc
try {
    // 接口名称
    \$apiname = 'Ws'.'{$apiname}';
    \$res = \ar\core\comp('rpc.service')->\$apiname("{$funcName}",{$paramsStr});
    // todo \$res
    // var_dump(\$res);
} catch (\ar\core\Exception \$e) {
    // todos 异常处理
    echo \$e->getMessage();
}
sfunc;
                $apiname = 'Ws' . $apiname;
                $res = \ar\core\comp('rpc.service')->$apiname($funcName, $params);
                // var_dump($res);
                $returnData = var_export($res, 1);
            endif;
            $this->assign(['returnData' => $returnData]);
        
           
        } catch (\ar\core\Exception $e) {
            $this->assign(['returnData' => $e->getMessage()]);
        }
        $this->assign(['showFunc' => $showFunc]);
        $this->display();
    }
}

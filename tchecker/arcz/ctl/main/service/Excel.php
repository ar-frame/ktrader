<?php
/**
 * @Author: yaoxf
 * @Date:   2018-07-12 17:39:24
 * @Last Modified by:   Marte
 * @Last Modified time: 2019-06-18 17:54:42
 */
namespace arcz\ctl\main\service;
define('ORI_PATH', dirname(dirname(dirname(dirname(__FILE__)))));
require_once(ORI_PATH."/lib/ext/Classes/PHPExcel.php");
/**
 * 数据服务组件
 */
class Excel
{
    public function init()
    {

    }
    public function visit_host()
    {
        // 当前访问方式是http://或者https://
        $http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';

        // 当前域名，如本地是localhost或127.0.0.1，线上是 www.xzgk.net
        $visit_host = $_SERVER['HTTP_HOST'];    // 127.0.0.1
        $full_visit_host = $http_type . $visit_host;   // http://127.0.0.1
        return ['http_type' => $http_type, 'visit_host' => $visit_host, 'full_visit_host' => $full_visit_host];
    }

    /** 
     * 数据导出 
     * @param array $title   标题行名称 
     * @param array $data   导出数据 
     * @param string $fileName 文件名 
     * @param string $savePath 保存路径 
     * @param $type   是否下载  false--保存   true--下载 
     * @return string   返回文件全路径 
     * @throws PHPExcel_Exception 
     * @throws PHPExcel_Reader_Exception 
    */  
    public function exportExcel($title=array(), $data=array(), $fileName='', $savePath='./', $isDown=false)
    {  
        define('arcz_PATH', dirname(dirname(dirname(dirname(__FILE__)))));
        
        require_once(arcz_PATH."\lib\\ext\Classes\PHPExcel.php");
        
        $obj = new \PHPExcel();
  
        //横向单元格标识  
        $cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');  
          
        $obj->getActiveSheet(0)->setTitle($fileName);   //设置sheet名称  
        $_row = 1;   //设置纵向单元格标识  
        if($title){  
            $_cnt = count($title);  
            $obj->getActiveSheet(0)->mergeCells('A'.$_row.':'.$cellName[$_cnt-1].$_row);   //合并单元格  
            $obj->setActiveSheetIndex(0)->setCellValue('A'.$_row, '数据导出时间：'.date('Y-m-d H:i:s'));  //设置合并后的单元格内容  
            $_row++;  
            $i = 0;  
            foreach($title AS $v){   //设置列标题  
                $obj->setActiveSheetIndex(0)->setCellValue($cellName[$i].$_row, $v);  
                $i++;  
            }  
            $_row++;  
        }  
  
        //填写数据  
        if($data){  
            $i = 0;  
            foreach($data AS $_v){  
                $j = 0;  
                foreach($_v AS $_cell){  
                    $obj->getActiveSheet(0)->setCellValue($cellName[$j] . ($i+$_row), $_cell);  
                    $j++;  
                }  
                $i++;  
            }  
        }  
      
        //文件名处理  
        if(!$fileName){  
            $fileName = uniqid(time(),true);  
        }  
      
        $objWrite = \PHPExcel_IOFactory::createWriter($obj, 'Excel2007');  
      
        if($isDown){   //网页下载  
            header('pragma:public');  
            header("Content-Disposition:attachment;filename=$fileName.xlsx");  
            $objWrite->save('php://output');exit;  
        }  
  
        $_fileName = iconv("utf-8", "gb2312", $fileName);   //转码  
        $_savePath = $savePath.$_fileName.'.xlsx';  
         $objWrite->save($_savePath);  
      
         return $savePath.$fileName.'.xlsx';  
    }



}
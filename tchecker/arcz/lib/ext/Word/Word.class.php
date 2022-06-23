<?php
/**
 * @Author: Marte
 * @Date:   2018-07-18 14:22:19
 * @Last Modified by:   Marte
 * @Last Modified time: 2018-07-18 14:29:47
 */
 class word
{ 
    function start()
    {
        ob_start();
        echo '<html xmlns:o="urn:schemas-microsoft-com:office:office"  xmlns:w="urn:schemas-microsoft-com:office:word"  xmlns="http://www.w3.org/TR/REC-html40">
              <head>
                   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                   <xml><w:WordDocument><w:View>Print</w:View></xml>
            </head><body>';
    }
    function save($path)
    {


        echo "</body></html>";
        $data = ob_get_contents();
        ob_end_clean();

        $this->wirtefile ($path,$data);
    }


    function wirtefile($fn,$data)
    {
        $fp=fopen($fn,"wb");
        fwrite($fp,$data);
        fclose($fp);
    }
}

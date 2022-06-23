<?php
/**
* Created by PhpStorm.
* User: zhangxd
* Date: 2018/2/9
* Time: 15:20
*/
// 用pChart生成雷达图图片
// 来源：https://www.cnblogs.com/haizizhu/p/8442524.html
include ("../class/pData.class.php");
include ("../class/pDraw.class.php");
include ("../class/pImage.class.php");
include ("../class/pRadar.class.php");
$one_data = array(1,5,10,20,30);
drow_love_radar($one_data);
function drow_love_radar($one_data, $file_name='radar.png', $type='save'){
    /* 设置颜色 */
    $MyData = new pData();
    $MyData->addPoints($one_data, "score");
    //设置字体描述
    //$MyData->setSerieDescription("ScoreB", "Coverage B");
    //设置数据线颜色（此处为红绿蓝三元素调色 alpha为透明度）
    $data = array("R"=>30,"G"=>220,"B"=>245,"Alpha"=>100);
    $MyData->setPalette('score',$data);

    /* 设立数据名称 此处设置为空 不做显示名称 但是占位*/
    $MyData->addPoints(array("", "", "", "", ""), "score_name");
    $MyData->setAbscissa("score_name");

    /* 创建画布设置大小 */
    $myPicture = new pImage(800, 800, $MyData);
    //$myPicture = new pImage(212, 213, $MyData);

    /* 画一个背景蒙版 */
    $Settings = array("R" => 255, "G" => 151, "B" => 178,"Alpha" => 100);
    //$myPicture->drawFilledRectangle(0, 0, 700, 230, $Settings);
    //根据起点和重点设置背景图大小
    $myPicture->drawFilledRectangle(100, 100, 600, 600, $Settings);

    /* 设置默认的字体属性 */
    $myPicture->setFontProperties(array("FontName" => "../fonts/Forgotte.ttf", "FontSize" => 10, "R" => 80, "G" => 80, "B" => 80));

    /*在数据区域 添加填充颜色(为图添加阴影)*/
//    $myPicture->setShadow(TRUE, array("X" => 1, "Y" => 1, "R" => 250, "G" => 255, "B" => 250, "Alpha" => 50));
    //$myPicture->setShadow(TRUE, array("X" => 1, "Y" => 1, "R" => 49, "G" => 221, "B" => 243, "Alpha" => 100));

    /* Create the pRadar object */
    $SplitChart = new pRadar();


    //根据起点和重点设置雷达图大小
    $myPicture->setGraphArea(200, 200, 500, 500);
    $Options = array(

        //坐标轴颜色
        'AxisR'=>255,
        'AxisG'=>0,
        'AxisB'=>0,
        'AxisAlpha'=>100,

        "AxisRotation" => -17,          //图形旋转角度
        "DrawPoly" => TRUE,             //区域阴影 需要调用setShadow方法设置阴影颜色
//    "PolyAlpha" => 100,             //区域阴影 透明度
        'DrawAxisValues' => false,      //画坐标轴的值 奇丑
        'WriteValues'=>false,           //在坐标轴顶点标注数值
        'WriteValuesInBubble'=>true,    //在顶点气泡中标注
        'ValuePadding'=>1,              //在顶点气泡中标注 大小
        'OuterBubbleRadius'=>0,         //顶点气泡颜色

        //设置渐变颜色 从里圈到外圈
        "BackgroundGradient" => array("StartR" => 255, "StartG" => 151, "StartB" => 178, "StartAlpha" => 100, "EndR" => 255, "EndG" => 255, "EndB" => 255, "EndAlpha" => 100),

        'Layout'=>690011,//690011=>尖角雷达图    690012=>圆角雷达图

        'SegmentHeight'=> 5,//设置每个坐标格大小
        'Segments'=> 3, //设置雷达图显示几个坐标格
        'LabelMiddle'=>true,

        //标签的一些东西 死丑死丑的 反正我没用
        'LabelsBackground'=>true,
        'LabelsBGR'=>255,
        'LabelsBGG'=>255,
        'LabelsBGB'=>255,
        'LabelsBGAlpha'=>100,
        "LabelPos" => RADAR_LABELS_HORIZONTAL,
        'LabelPadding'=>10,//标签距离

        'DrawPoints'=>TRUE,//画坐标顶点的小圆点
        'PointRadius'=>5,//坐标顶点的小圆点大小
        'PointSurrounding'=>500,
        'DrawLines'=>true,//画坐标点连接线(首尾点不连接 适用于xy坐标轴)
        'LineLoopStart'=>true,//链接首尾的点

        "FontName" => "../fonts/pf_arma_five.ttf",//字体文件
        "FontSize" => 6,//字体大小

        /*下面的调试无结果*/
        //设置外 气泡颜色
        'OuterBubbleR'=>1,
        'OuterBubbleG'=>1,
        'OuterBubbleB'=>1,
        'OuterBubbleAlpha'=>100,

        //设置内 气泡颜色
        'InnerBubbleR'=>1,
        'InnerBubbleG'=>1,
        'InnerBubbleB'=>1,
        'InnerBubbleAlpha'=>100,

        //设置背景色
        'DrawBackground'=>true,
        'BackgroundR'=>255,
        'BackgroundG'=>255,
        'BackgroundB'=>255,
        'BackgroundAlpha'=>100,

    );

    $SplitChart->drawRadar($myPicture, $MyData, $Options);

    switch ($type){
        case 'auto':
            //根据输出环境操作 在命令模式下保存
            $myPicture->autoOutput($file_name);
            break;
        case 'out':
            $myPicture->stroke();
            break;
        case 'save':
            $myPicture->Render($file_name);
            break;

    }
}


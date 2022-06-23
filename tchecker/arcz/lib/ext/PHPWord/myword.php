<?php
define("DOWN_PATH", dirname(__FILE__)."\Download\\");
require_once './PHPWord.php';

// New Word Document
$PHPWord = new PHPWord();

// New portrait section
$section = $PHPWord->createSection();


// Add header
$header = $section->createHeader();
$table = $header->addTable();
$table->addRow();
$table->addCell(4500)->addText('成都中企艾维数据有限公司',array('text-decoration'=>'underline','border-bottom'=>'1px solid #000','size'=>12), array('text-decoration'=>'underline','border-bottom'=>'1px solid #000','size'=>12));
// $table->addCell(4500)->addImage('_earth.jpg', array('width'=>50, 'height'=>50, 'align'=>'right'));

// Add footer
$footer = $section->createFooter();
$footer->addPreserveText('{PAGE}/{NUMPAGES}', array('text-align'=>'right'));


// Create header
// $header = $section->createHeader();


$PHPWord->setDefaultFontName('楷体_GB2312'); // 全局字体
$PHPWord->setDefaultFontSize(12);     // 全局字号为小四号，12pt

// 二号22字体，加粗，居中
$PHPWord->addFontStyle('1para', array('align'=>'center', 'bold'=>true, 'size'=>16));
$PHPWord->addFontStyle('erhao', array('size' => 22 ));
$PHPWord->addFontStyle('sanhao', array('size' => 16));
$PHPWord->addFontStyle('juzhong', array('align' => 'center'));
$PHPWord->addFontStyle('jiacu', array('bold' => true));
$PHPWord->addFontStyle('sanhao',array('size'=>16));  // 三号16字体
$PHPWord->addFontStyle('sanhao_jiacu',array('bold'=>true,'size'=>16));  // 三号16字体，加粗
$PHPWord->addFontStyle('sanhao_juzhong', array('align'=>'center', 'size'=>16));  // 三号16字体，居中



$PHPWord->addParagraphStyle('pStyle', array('spacing'=>100));
$PHPWord->addParagraphStyle('margin_top_100', array('spaceBefore'=>500));
$PHPWord->addParagraphStyle('margin_buttom_100', array('spaceAfter'=>500));
$PHPWord->addParagraphStyle('suojin', array('text-indent' => 2));
$PHPWord->addParagraphStyle('erhao_juzhong_jiacu',array('align'=>'center','bold'=>true,'size'=>22));
$PHPWord->addParagraphStyle('sanhao',array('size'=>16));  // 三号16字体
$PHPWord->addParagraphStyle('sanhao_jiacu',array('bold'=>true, 'size'=>16));  // 三号16字体，加粗
$PHPWord->addParagraphStyle('sanhao_juzhong',array('align'=>'center','size'=>16));// 三号16字体，居中

$section->addTextBreak(2);

$section->addText('大数据智能市值评估报告', '1para', 'erhao_juzhong_jiacu');
$section->addText('(快速版)', '1para', 'erhao_juzhong_jiacu');
$section->addTextBreak(20);



// 三号16字体，加粗
$PHPWord->addFontStyle('2para', array('bold'=>true, 'size'=>16));

// Write some text
$section->addTextBreak();


$qiye = '企业名称';
$jigou = '中企艾维';
$bianhao = '20189999';

$textrun = $section->createTextRun();
$textrun->addText('评估标的：', array('bold'=>true));
$textrun->addText($jigou, array('italic'=>true));

$section->addTextBreak();
$textrun->addText('报告编号：', array('bold'=>true));
$textrun->addText($bianhao);


$section->addText('评估标的：'.$jigou, array('bold'=>true,'size'=>16),array('bold'=>true,'size'=>16));
$section->addText('报告编号：'.$bianhao, array('bold'=>true,'size'=>16),array('bold'=>true,'size'=>16));
$section->addTextBreak(10);



$section->addText($jigou, array('align'=>'center','size'=>16),array('align'=>'center','size'=>16));
$section->addText(date('Y年m月d日',time()), array('align'=>'center','size'=>16),array('align'=>'center','size'=>16));

// 分页
$section->addPageBreak();
$section->addText('声 明', array('bold'=>true,'size'=>14), array('align'=>'center'));

$section->addTextBreak(2);
$section->addText('    本系统技术人员于整体评估过程，恪守独立、客观和公正的原则，严格遵循有关法律、法规和市值评估理论，并尽专业上应有之注意，且对下列评估事项进行声明：', array('text-indent'=>'2em', 'size'=>12, 'marginBottom'=>1500), array('spacing'=>150));


$table = $section->addTable();

$cellStyle = array('cellMerge'=>'continue', 'borderBottomSize'=>15, 'borderBottomColor'=>'black', 'borderRightSize'=>15, 'borderRightColor'=>'red');
$a2 = array('cellMerge'=>'restart', 'valign'=>'center');

$table->addRow(400);
$table->addCell(1600, array('cellMerge'=>'restart', 'valign'=>"center", 'borderRightSize'=>15, 'borderRightColor'=>'red'))->addText('横向合并横向合并横向合并横向合并,横向合并横向合并横向合并横向合并,横向合并横向合并横向合并横向合并,横向合并横向合并横向合并横向合并,横向合并横向合并横向合并横向合并');
$table->addCell(1600, array('cellMerge'=>'continue', 'borderRightSize'=>15, 'borderRightColor'=>'red'));
$table->addCell(1600, array('cellMerge'=>'continue', 'borderRightSize'=>15, 'borderRightColor'=>'red'));
$table->addCell(1600, array('cellMerge'=>'continue', 'borderRightSize'=>15, 'borderRightColor'=>'red'));  // array('cellMerge'=>'continue');

$table->addRow(400);
$table->addCell(1600, array('cellMerge'=>'restart', 'valign'=>"center", 'borderRightSize'=>15, 'borderRightColor'=>'red'))->addText('横向合并横向合并横向合并横向合并,横向合并横向合并横向合并横向合并,横向合并横向合并横向合并横向合并,横向合并横向合并横向合并横向合并,横向合并横向合并横向合并横向合并');
$table->addCell(1600, array('cellMerge'=>'continue', 'borderRightSize'=>15, 'borderRightColor'=>'red'));
$table->addCell(1600, array('cellMerge'=>'continue', 'borderRightSize'=>15, 'borderRightColor'=>'red'));
$table->addCell(1600, array('cellMerge'=>'continue', 'borderRightSize'=>15, 'borderRightColor'=>'red'));  // array('cellMerge'=>'continue');

$section->addTextBreak(3);
            $table = $section->addTable();
            $table->addRow();
            $styleCell = array('gridSpan' => 2);
            $table->addCell(200, $styleCell)->addText('PHP二次开发');
            $table->addCell(100)->addText('http://www.jquerycn.cn');
            $table->addRow();
            $table->addCell(100)->addText('PHP');
            $table->addCell(100)->addText('python');
            $table->addCell(100)->addText('java');
            $section->addTextBreak(10);

        # 可以使用 start
        $table = $section->addTable();
        $table->addRow(600);
        $table->addCell(1500,array('vMerge' => 'restart', 'borderRightSize'=>15, 'borderRightColor'=>'red', 'borderBottomSize'=>15, 'borderBottomColor'=>'black'))->addText('1');
        $table->addCell(1500, array('borderRightSize'=>15, 'borderRightColor'=>'red', 'borderBottomSize'=>15, 'borderBottomColor'=>'black'))->addText('2');
        $table->addRow(600);
        $table->addCell(1500,array('vMerge' => 'fusion', 'borderRightSize'=>15, 'borderRightColor'=>'red', 'borderBottomSize'=>15, 'borderBottomColor'=>'black'));
        $table->addCell(1500, array('borderRightSize'=>15, 'borderRightColor'=>'red', 'borderBottomSize'=>15, 'borderBottomColor'=>'black'))->addText('3');

        $section->addTextBreak(3);

        $table->addRow(600);
        $styleCell=array('gridSpan' => 2, 'borderRightSize'=>15, 'borderRightColor'=>'red', 'borderBottomSize'=>15, 'borderBottomColor'=>'black');
        $table->addCell(3000, $styleCell)->addText('PHP点点通');
        $table->addCell(100)->addText('http://www.phpddt.com');
        $table->addRow(600);
        $table->addCell(1500)->addText('PHP');
        $table->addCell(1500)->addText('python');
        $table->addCell(1500)->addText('java');
        $section->addTextBreak(10);

        # 可以使用 end
        

        $table = $section->addTable();
        $table->addRow(600);
        $table->addCell(300)->addText('法人代表：');
        $table->addCell(20000)->addText("legal_person");
        $table->addRow(600);
        $table->addCell(300)->addText('成立日期：');
        $table->addCell(20000)->addText("establish_year");
        $table->addRow(600);
        $table->addCell(300)->addText('注册资本：');
        $table->addCell(20000)->addText("capital"."万");
        $table->addRow(600);
        $table->addCell(300)->addText('注册地址：');
        $table->addCell(20000)->addText("zcdz");
        $table->addRow(600);
        $table->addCell(300)->addText('统一社会信用代码：'."social_credit_code", array('cellMerge'=>'restart', 'valign'=>'center'));
        $table->addCell(300, array('cellMerge'=>'continue'));
        $table->addRow(600);
        $table->addCell(300)->addText('联系电话：');
        $table->addCell(20000)->addText("linkphone");
        $table->addRow(600);
        $table->addCell(300)->addText('电子邮箱：');
        $table->addCell(20000)->addText("email");
        $table->addRow(600);
        $table->addCell(300)->addText('所属行业：');
        $table->addCell(20000)->addText("hangye");
        $table->addRow(600);
        $table->addCell(300)->addText('发展阶段：');
        $table->addCell(20000)->addText("jieduan");
        $table->addRow(600);
        $table->addCell(300)->addText('员工人数：');
        $table->addCell(20000)->addText("employees");
        $table->addRow(600);
        $table->addCell(3000)->addText('经营范围：');
        $table->addCell(20000)->addText("师生的方式开始疯狂电脑机房和斯蒂芬金黄色的破开发生的那么疯狂拉升到女方家师生的方式开始疯狂电脑机房和斯蒂芬金黄色的破开发生的那么疯狂拉升到女方家师生的方式开始疯狂电脑机房和斯蒂芬金黄色的破开发生的那么疯狂拉升到女方家师生的方式开始疯狂电脑机房和斯蒂芬金黄色的破开发生的那么疯狂拉升到女方家师生的方式开始疯狂电脑机房和斯蒂芬金黄色的破开发生的那么疯狂拉升到女方家");



//  text-indent:2em 
// 小四  12pt    16px    1em

// 水印 Add a watermark to the header
// $header->addWatermark('_earth.jpg', array('marginTop'=>200, 'marginLeft'=>55));

// $section->addText('The header reference to the current section includes a watermark image.');


// Save File
$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
$num = "20189999";
$filename = $num.".doc";

$objWriter->save( iconv("utf-8","gbk", DOWN_PATH.$filename));

$file_path = iconv("utf-8", "gbk", DOWN_PATH.$filename);

// 以doc格式输出文件
header('Content-type: application/doc');  
// 输出文件名是 $filename 
header('Content-Disposition: attachment; filename='.$filename);
// readfile这个函数的意思就是读取一个文件然后输出
readfile($file_path);



// return;



?>
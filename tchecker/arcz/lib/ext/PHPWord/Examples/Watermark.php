<?php
define("DOWN_PATH", dirname(dirname(__FILE__))."\Download\\");
require_once '../PHPWord.php';

// New Word Document
$PHPWord = new PHPWord();

// New portrait section
$section = $PHPWord->createSection();


// Add header
$header = $section->createHeader();
$table = $header->addTable();
$table->addRow();
$table->addCell(4500)->addText('成都中企艾维数据有限公司');
// $table->addCell(4500)->addImage('_earth.jpg', array('width'=>50, 'height'=>50, 'align'=>'right'));

// Add footer
$footer = $section->createFooter();
$footer->addPreserveText('{PAGE}/{NUMPAGES}', array('text-align'=>'right'));


// Create header
// $header = $section->createHeader();


$PHPWord->setDefaultFontName('楷体_GB2312'); // 全局字体
$PHPWord->setDefaultFontSize(12);     // 全局字号为小四号，12pt

// 二号22字体，加粗，居中
$PHPWord->addFontStyle('1para', array('align'=>'center', 'bold'=>true, 'size'=>22));
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

$section->addText(iconv('utf-8', 'GB2312//IGNORE', '大数据智能市值评估报告'), '1para', 'erhao_juzhong_jiacu');
$section->addText(iconv('utf-8', 'GB2312//IGNORE', '(快速版)'), '1para', 'erhao_juzhong_jiacu');
$section->addTextBreak(20);

// 三号16字体，加粗
$PHPWord->addFontStyle('2para', array('bold'=>true, 'size'=>16));

// Write some text
$section->addTextBreak();


$qiye = 'qiye_mingcheng';
$jigou = 'aiwei';
$bianhao = '20189999';

$textrun = $section->createTextRun('pstyle');

// $textrun->addText(iconv('utf-8','GB2312//IGNORE','评估标的：'), 'sanhao_jiacu','sanhao_jiacu');
// $textrun->addText(iconv('utf-8','GB2312//IGNORE',$qiye), 'sanhao','sanhao');
// $section->addTextBreak();
// $textrun->addText(iconv('utf-8','GB2312//IGNORE','报告编号：'), 'sanhao_jiacu','sanhao_jiacu');
// $textrun->addText(iconv('utf-8','GB2312//IGNORE',$bianhao), 'sanhao','sanhao');
// $section->addTextBreak();

$textrun->addText('biaodi:', array('bold'=>true,'size'=>16),array('bold'=>true,'size'=>16));
$textrun->addText($qiye, array('size'=>16),array('size'=>16));
$section->addTextBreak();
$textrun->addText('bianhao:', array('bold'=>true,'size'=>16),array('bold'=>true,'size'=>16));
$textrun->addText($bianhao, array('size'=>16),array('size'=>16));
$section->addTextBreak(10);



$section->addText(iconv('utf-8', 'GB2312//IGNORE', $jigou), array('align'=>'center','size'=>16),array('align'=>'center','size'=>16));
$section->addText(iconv('utf-8', 'GB2312//IGNORE', date('Y年m月d日',time())), array('align'=>'center','size'=>16),array('align'=>'center','size'=>16));






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
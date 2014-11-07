<?php

/**
 * 早教温馨提示
 * type=3
 */

error_reporting(E_ALL ^ E_NOTICE);

include_once "PHPExcel.class.php";
include_once "PHPExcel/IOFactory.php";

$filePath = "test.xlsx";
$fileType = PHPExcel_IOFactory::identify($filePath);
$objReader = PHPExcel_IOFactory::createReader($fileType);
$objPHPExcel = $objReader->load($filePath);
//指定当前工作簿
$workSheet = $objPHPExcel->getSheet(1);
//指定有效行和列
$startColumn = "A";
$startColumnIndex = PHPExcel_Cell::columnIndexFromString($startColumn);
$endColumn = "BA";
$endColumnIndex = PHPExcel_Cell::columnIndexFromString($endColumn);
//读取文件中的有效数据，拼接成字符串
$data = "";
$week = 0;
for($col=$startColumnIndex; $col<$endColumnIndex; $col++) {
    $title = $workSheet->getCellByColumnAndRow($col, 5)->getValue();
    $content = $workSheet->getCellByColumnAndRow($col, 6)->getValue();
    $type = 3;
    $week++;
    $pic = "/parentalKnowledge/teach/".$week.'.jpg';
    $data .= "('$title','$content','$type','$week','$pic'),";
}
$data = substr($data, 0, -1);
//数据库配置
$db_host = "localhost";
$db_name = "pregnancy";
$db_user = "root";
$db_pwd	= "";
//建立连接
$conn = mysql_connect($db_host, $db_user, $db_pwd) or die("数据库连接失败！错误原因：".mysql_error());
//选择数据库
mysql_select_db($db_name, $conn) or die("数据库选择失败！错误原因：".mysql_error());
//设置编码
mysql_query("set names utf8", $conn) or die(mysql_errno());
//指定数据表
$table = "`pt_parental_knowledge`";
//清空数据表
//mysql_query("truncate table ".$table, $conn);
//生成SQL语句
$sql = "insert into ".$table." (title,content,type,week,pic) values ".$data;
//执行操作
$query = mysql_query($sql, $conn) or die("Bad query:".mysql_error());
//执行结果
if($query) {
    echo 'success';
} else {
    echo 'fail';
}

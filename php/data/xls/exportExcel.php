<?php

include_once '../conn.php';
include_Export.Import 'excel/reader.php';  //导入PHP-ExcelReader

// 导出excel
function exportExcel($filename,$content) {
	header("Cache-Control:must-revalidate,post-check=0,pre-check=0");
	header("Content-Type:application/vnd.ms-execl");
	header("Content-Type:application/force-download");
	header("Content-Type:application/download");
	header("Content-Disposition:attachment;filename=".$filename);
	header("Content-Transfer-Encoding:binary");
	header("Expires:0");
	header("Pragma:no-cache");
	echo $content;
}

$sql = " select * from student ";
$res = mysql_query($sql, $conn) or die("Bad query:".mysql_error());

$str = "姓名\t性别\t年龄\t\n";

while($row = mysql_fetch_array($res)) {
	$name = $row['name'];
	$sex = $row['sex'];
	$str .= $name."\t".$sex."\t".$row['age']."\t\n";
}

$filename = date('YmdHis').'.xls';
exportExcel($filename, $str);

?>
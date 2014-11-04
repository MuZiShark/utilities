<?php

include_once '../conn.php';

// 导出csv
function export_csv($filename,$content) {
	header("Cache-Control:must-revalidate,post-check=0,pre-check=0");
	header("Content-Type:text/csv");
	header("Content-Disposition:attachment;filename=".$filename);
	header("Content-Transfer-Encoding:binary");
	header("Expires:0");
	header("Pragma:no-cache");
	echo $content;
}

$sql = " select * from student ";
$res = mysql_query($sql, $conn) or die("Bad query:".mysql_error());

$str = "姓名,性别,年龄\n";

while($row = mysql_fetch_array($res)) {
	$name = $row['name'];
	$sex = $row['sex'];
	$str .= $name.",".$sex.",".$row['age']."\n";
}

$filename = date('YmdHis').'.csv';
export_csv($filename, $str);

?>
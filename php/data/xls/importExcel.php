<?php

header("Content-type:text/html;charset=utf-8");

include_once '../conn.php';
include_once 'excel/reader.php';  //导入PHP-ExcelReader

$data = new Spreadsheet_Excel_Reader();
$data->setOutputEncoding('utf-8');
$data->read('student.xls');

$data_values = "";

for($i=2; $i<=$data->sheets[0]['numRows']; $i++) {
	$name = $data->sheets[0]['cells'][$i][1];
	$sex = $data->sheets[0]['cells'][$i][2];
	$age = $data->sheets[0]['cells'][$i][3];
	$data_values .= "('$name','$sex','$age'),";
}

$data_values = substr($data_values, 0, -1);

$sql = " insert into `student` (name,sex,age) values $data_values ";
$query = mysql_query($sql, $conn) or die("Bad query:".mysql_error());
if($query) {
	echo 'success';
} else {
	echo 'fail';
}

?>
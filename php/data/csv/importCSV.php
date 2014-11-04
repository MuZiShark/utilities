<?php

header("Content-type:text/html;charset=utf-8");

include_once '../conn.php';

// 解析csv
function input_csv($handle) {
	$res = array();
	$num = 0;
	while($data = fgetcsv($handle, 10000)) {
		for($i=0; $i<count($data); $i++) {
			$res[$num][$i] = $data[$i];
		}
		$num++;
	}
	return $res;
}

$handle = fopen("student.csv", 'r');

$res = input_csv($handle);

$num = count($res);

$data_values = "";

for($i=1; $i<$num; $i++) {
	$name = $res[$i][0];
	$sex = $res[$i][1];
	$age = $res[$i][2];
	$data_values .= "('$name','$sex','$age'),";
}

$data_values = substr($data_values, 0, -1);

fclose($handle);

$sql = " insert into `student` (name,sex,age) values $data_values ";
$query = mysql_query($sql, $conn) or die("Bad query:".mysql_error());
if($query) {
	echo 'success';
} else {
	echo 'fail';
}

?>
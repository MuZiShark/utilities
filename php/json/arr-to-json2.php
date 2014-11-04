<?php

/**
 * 二维数组的json转换
 */

header("Content-type:text/html;charset=utf-8");

function my_urlencode($var) {
	if(empty($var))  return false;
	if(is_array($var)) {
		foreach ($var as $k=>$v ) {
			//if用来处理不是数组的情况
			if(is_scalar($v)) {
				$var[$k] = urlencode($v);
			} else {//else用来处理数组
				$var[$k] = my_urlencode($v);
			}
		}
	} else {
		//用来处理数组
		$var = urlencode($var);
	}
	return $var;
}

function my_json_encode($var) {
	$_var = my_urlencode($var);
	$_str = json_encode($_var);
	return urldecode($_str);
}

//数组
$arr = array("10001","李瑞");
var_dump($arr);
//一维数组
$arr1 = array("id"=>10001,"name"=>"李瑞",);
var_dump($arr1);
//二维数组
$arr2 = array(
		"id"=>10001,
		"name"=>"李瑞",
		"profile"=>array(
				"age"=>25,
				"sex"=>"男",
				"character"=>"活泼开朗、乐观大方",
				)
		);var_dump($arr2);
//三维数组
$arr3 = array(
		"id"=>10001,
		"name"=>"李瑞",
		"profile"=>array(
				"age"=>25,
				"sex"=>"男",
				"education"=>array(
						"major"=>"software engineering",
						"degree"=>"master",
						),
						"character"=>"活泼开朗、乐观大方",
				)
		);var_dump($arr3);
//输出结果
echo my_json_encode($arr);
echo '<br />';
echo my_json_encode($arr1);
echo '<br />';
echo my_json_encode($arr2);
echo '<br />';
echo my_json_encode($arr3);

?>
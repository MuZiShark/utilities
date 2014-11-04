<?php

/**
 * 一维数组的json转换
 */

header("Content-type:text/html;charset=utf-8");

function my_urlencode($array) {
	if(is_array($array)) {
		foreach ($array as $key => $value) {
			$array[$key] = urlencode($value);
		}
	}
	return $array;
}
//输出结果
$arr = array(1,"李瑞",25,"男","活泼开朗、乐观大方",);
echo "数组";var_dump($arr);
$arr = array("id"=>1,"name"=>"李瑞","age"=>25,"sex"=>"男","character"=>"活泼开朗、乐观大方",);
echo "一维数组";var_dump($arr);
$arr2 = my_urlencode($arr);
echo "中文编码";var_dump($arr2);
$jsonstr = json_encode($arr2);
echo "json编码";var_dump($jsonstr);
$jsonstr2 = urldecode($jsonstr);
echo "中文解码";var_dump($jsonstr2);
$out_arr = json_decode($jsonstr2,true);
echo "json解码（数据）";var_dump($out_arr);
$out_obj = json_decode($jsonstr2,false);
echo "json解码（对象）";var_dump($out_obj);

?>
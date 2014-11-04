<?php

// create cURL resources
// 创建cURl资源

$ch1 = curl_init();
$ch2 = curl_init();
$ch3 = curl_init();

// set URL and other appropriate options
// 设置URL和相应的选项

curl_setopt($ch1, CURLOPT_URL, "http://www.cnwust.com/Show/270");
curl_setopt($ch1, CURLOPT_HEADER, 0);
curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch2, CURLOPT_URL, "http://www.cnwust.com/News/72916");
curl_setopt($ch2, CURLOPT_HEADER, 0);
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch3, CURLOPT_URL, "http://www.cnwust.com/News/73185");
curl_setopt($ch3, CURLOPT_HEADER, 0);
curl_setopt($ch3, CURLOPT_RETURNTRANSFER, 1);

// add the multiple cURL handles
// 新增批处理cURL句柄

$mh = curl_multi_init();

curl_multi_add_handle($mh, $ch1);
curl_multi_add_handle($mh, $ch2);
curl_multi_add_handle($mh, $ch3);

// execute the handles
// 执行批处理句柄

$active = null;

do {
	$mrc = curl_multi_exec($mh, $active);
} while($mrc == CURLM_CALL_MULTI_PERFORM);

while($active && $mrc == CURLM_OK) {
	if(curl_multi_select($mh) != -1)  usleep(100);
	do{
		$mrc = curl_multi_exec($mh, $active);
	} while($mrc == CURLM_CALL_MULTI_PERFORM);
}

// close the handles
// 关闭全部句柄

curl_multi_remove_handle($mh, $ch1);
curl_multi_remove_handle($mh, $ch2);
curl_multi_remove_handle($mh, $ch3);

curl_close($ch1);
curl_close($ch2);
curl_close($ch3);

curl_multi_close($mh);

?>
<?php

/**
 * -- ----------------------------
 * -- ----------------------------
 * -- 测试数据
 * -- ----------------------------
 * -- ----------------------------
 */

$urlArr = array(
	"美丽校园" => "http://www.cnwust.com/Show/270",
	"剪影毕业照" => "http://www.cnwust.com/News/72916",
	"初夏黄家湖" => "http://www.cnwust.com/News/73185",
);

/**
 * -- ----------------------------
 * -- ----------------------------
 * -- 函数主体
 * -- ----------------------------
 * -- ----------------------------
 */

$options = array(
	CURLOPT_HEADER => 0,
	CURLOPT_RETURNTRANSFER => 1,
	CURLOPT_TIMEOUT, 3,
);

/**
 * Test 1 :
 *
 */

$time_begin = microtime_float();

foreach($urlArr as $k => $url) {
	$data[$k] = curl_fetch($url, $options);
}

$time_end = microtime_float();

echo "total time : ".($time_end-$time_begin);

var_dump($data);

/**
 * Test 2 :
 *
 */

$time_begin2 = microtime_float();

$data2 = curl_fetch_multi($urlArr, $options);

$time_end2 = microtime_float();

echo "total time : ".($time_end2-$time_begin2);

var_dump($data2);

/**
 * -- ----------------------------
 * -- ----------------------------
 * -- 函数功能
 * -- ----------------------------
 * -- ----------------------------
 */

function microtime_float() {
	list($usec, $sec) = explode(" ", microtime());
	return (float)$usec + (float)$sec;
}

/**
 * solution 1 : curl_fetch
 * 
 */
function curl_fetch($url, $options=array()) {
	// 创建curl句柄
	$ch = curl_init();
	// 设置参数
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt_array($ch, $options);
	// 执行句柄
	$res = curl_exec($ch);
	// 检测错误
	if(curl_errno($ch)) {
		echo 'curl error : '.curl_error($ch);
	}
	// 关闭句柄
	curl_close($ch);
	return $res;
}

/**
 * solution 2 : curl_fetch_multi
 * 
 */
function curl_fetch_multi($urlArr=array(), $options=array()) {
	// 创建curl_multi句柄
	$mh = curl_multi_init();
	
	$res = array();
	$handleArr = array();
	
	foreach ($urlArr as $k => $url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt_array($ch, $options);
		curl_multi_add_handle($mh, $ch);
		$handleArr[$k] = $ch;
	}
	
	do {
		$mrc = curl_multi_exec($mh, $active);
	} while($mrc == CURLM_CALL_MULTI_PERFORM);
	
	while($active && $mrc == CURLM_OK) {
		if(curl_multi_select($mh) != -1)  usleep(100);
		do {
			$mrc = curl_multi_exec($mh, $active);
		} while($mrc == CURLM_CALL_MULTI_PERFORM);
	}
	
	foreach($handleArr as $k => $ch) {
		$res[$k] = curl_multi_getcontent($ch);
		curl_multi_remove_handle($mh, $ch);
		curl_close($ch);
	}
	
	curl_multi_close($mh);
	
	return $res;
}

?>
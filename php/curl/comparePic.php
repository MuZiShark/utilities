<?php

/**
 * -- ----------------------------
 * -- ----------------------------
 * -- 测试数据
 * -- ----------------------------
 * -- ----------------------------
 */

$url = "http://www.mama.cn/";

/**
 * -- ----------------------------
 * -- ----------------------------
 * -- 函数主体
 * -- ----------------------------
 * -- ----------------------------
 */

// 允许脚本运行的时间
set_time_limit(0);
// 配置
$options = array(
	CURLOPT_HEADER => 0,
	CURLOPT_RETURNTRANSFER => 1,
	CURLOPT_TIMEOUT => 3,
);
// 检测curl扩展是否开启
if(!in_array('curl', get_loaded_extensions())) {
	die('please add curl extension');
}
// 初始化curl
$ch = curl_init();
// 设置curl参数
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt_array($ch, $options);
// 执行curl句柄
$htmlContents = curl_exec($ch);
// 正则匹配，拼接图片url
if(preg_match_all('/<img.+src="?(.+\.(gif|jpg|png))"?.*>/i', $htmlContents, $matches)) {
	$imageLinks = array();
	foreach ($matches[1] as $item) {
		$suffix = pathinfo($item, PATHINFO_EXTENSION);
		if(in_array(strtolower($suffix), array('gif', 'jpg', 'png'))) {
			array_push($imageLinks, $item);
		}
	}
}
// 匹配为空，则退出
if(empty($imageLinks))  die('none');
// 匹配到的最终结果
$imageLinks = array_unique($imageLinks);
// 二次处理
// foreach ($imageLinks as &$link) {
// 	$link = '###'.$link;
// }

var_dump($imageLinks);

// 定义文件路径
$dir = "C:/save";
$dir2 = "C:/save2";
// 创建文件夹，存放图片
if(!is_dir($dir))  {
	@mkdir($dir, 0777, true);
}
if(!is_dir($dir2))  {
	@mkdir($dir2, 0777, true);
}

/**
 * Test 1 :
 *
 */

$time_begin = microtime_float();

foreach($imageLinks as $imageLink) {
	curl_fetchPic($imageLink, $options, $dir);
}

$time_end = microtime_float();

echo "total time : ".($time_end-$time_begin)."<br />";

/**
 * Test 2 :
 *
 */

$time_begin2 = microtime_float();

curl_fetchPic_multi($imageLinks, $options, $dir2);

$time_end2 = microtime_float();

echo "total time : ".($time_end2-$time_begin2)."<br />";

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
 * solution 1 : curl_fetchPic
 * 
 */
function curl_fetchPic($url, $options=array(), $dir=".") {
	// 创建curl句柄
	$ch = curl_init();
	// 设置参数
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt_array($ch, $options);
	// 执行句柄
	$res = curl_exec($ch);
	file_put_contents($dir.'/'.pathinfo($url, PATHINFO_BASENAME), $res);
	// 关闭句柄
	curl_close($ch);
}

/**
 * solution 2 : curl_fetchPic_multi
 * 
 */
function curl_fetchPic_multi($urlArr=array(), $options=array(), $dir=".") {
	
	$mh = curl_multi_init();
	
	$handleArr = array();
	foreach ($urlArr as $k => $url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt_array($ch, $options);
		curl_multi_add_handle($mh, $ch);
		$handleArr[$url] = $ch;
	}
	
	$active = null;
	do {
		$mrc = curl_multi_exec($mh, $active);
	} while($mrc == CURLM_CALL_MULTI_PERFORM);
	
	while($active && $mrc == CURLM_OK) {
		if(curl_multi_select($mh) != -1)  usleep(100);
		do {
			$mrc = curl_multi_exec($mh, $active);
		} while($mrc == CURLM_CALL_MULTI_PERFORM);
	}
	
	foreach($handleArr as $url => $ch) {
		$res = curl_multi_getcontent($ch);
		file_put_contents($dir.'/'.pathinfo($url, PATHINFO_BASENAME), $res);
		curl_multi_remove_handle($mh, $ch);
		curl_close($ch);
	}
	
	curl_multi_close($mh);
}

?>
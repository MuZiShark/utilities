<?php

$time_start = microtime_float();
async_get_images("http://www.mama.cn/");
$time_end = microtime_float();
$time = $time_end - $time_start;
 
echo "Time: $time seconds<br />";

function microtime_float() {
	list($usec, $sec) = explode(" ", microtime());
	return ((float)$usec + (float)$sec);
}

/**
 * 异步抓取图片
 * 
 */
function async_get_images($url, $dir="C:/save") {
	set_time_limit(0);
	ignore_user_abort(true);
	if(!in_array('curl', get_loaded_extensions())) {
		die('curl not supported');
	}
	$ch = curl_init();
	curl_setopt_array($ch, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_FOLLOWLOCATION => 1,
		CURLOPT_CONNECTTIMEOUT => 30,
		CURLOPT_REFERER => !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '',
		CURLOPT_USERAGENT => $_SERVER['HTTP_USER_AGENT'],
	));
	$htmlContent = curl_exec($ch);
	
	// 正则匹配，拼接图片url
	
	if(preg_match_all('/<img.+src="?(.+\.(gif|jpg|png))"?.*>/i', $htmlContent, $matches)) {
		$imageLinks = array();
		foreach ($matches[1] as $item) {
			$suffix = pathinfo($item, PATHINFO_EXTENSION);
			if(in_array(strtolower($suffix), array('gif', 'png', 'jpg'))) {
				array_push($imageLinks, $item);
			}
		}
	}
	if(empty($imageLinks))  die('none');
	// create $imageLinks
	$imageLinks = array_unique($imageLinks);
	
// 	foreach ($imageLinks as &$link) {
// 		$link = 'http://www.ezhou.gov.cn/'.$link;
// 	}
var_dump($imageLinks);
	
	// 创建文件夹，存放图片
	
	if(!file_exists($dir))  {
		@mkdir($dir, 0777, true);
	}
	
	// 初始化：curl_multi_init
	
	$mh = curl_multi_init();
	
	$handles = array();
	foreach ($imageLinks as $k => $link) {
		$handles[$k]['thread'] = curl_copy_handle($ch);
		$handles[$k]['filename'] = pathinfo($link, PATHINFO_BASENAME);
		curl_setopt($handles[$k]['thread'], CURLOPT_URL, $link);
		curl_multi_add_handle($mh, $handles[$k]['thread']);
	}
	
	// 执行：curl_multi_exec
	
	$active = null;
	do {
		$mrc = curl_multi_exec($mh, $active);
	} while($mrc == CURLM_CALL_MULTI_PERFORM);
	while($active && $mrc == CURLM_OK) {
		if(version_compare(PHP_VERSION, '5.4.3', '<')) {
			if(curl_multi_select($mh) != -1) {
				do {
					$mrc = curl_multi_exec($mh, $active);
				} while($mrc == CURLM_CALL_MULTI_PERFORM);
			}
		} else {
			if(curl_multi_select($mh) != -1)  usleep(100);
			do {
				$mrc = curl_multi_exec($mh, $active);
			} while($mrc == CURLM_CALL_MULTI_PERFORM);
		}
	}
	
	// 执行：curl_multi_getcontent
	
	$res = array();
	foreach($handles as $k => $item) {
		$res = curl_multi_getcontent($item['thread']);
		curl_multi_remove_handle($mh, $item['thread']);
		file_put_contents($dir.'/'.$item['filename'], $res);
		curl_close($item['thread']);
	}
	
	// 关闭：curl_multi_close
	curl_multi_close($mh);
	
	// 返回值
	return true;
}

?>
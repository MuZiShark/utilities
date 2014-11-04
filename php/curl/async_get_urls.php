<?php

$urls = array(
	"http://localhost/workspace/basic/curl/z.php?echo=request1",
	"http://localhost/workspace/basic/curl/z.php?echo=request2",
	"http://localhost/workspace/basic/curl/z.php?echo=request3",
);

$options = array(
	CURLOPT_HEADER => 0,
	CURLOPT_RETURNTRANSFER => 1,
	CURLOPT_TIMEOUT => 30,
);

$s = microtime(true);

$data = async_get_urls($urls, $options);

print_r($data);

print "<br />total time: ".round(microtime(true) - $s, 4)." seconds";

/**
 * parallel_get_urls
 * 
 *
 */

function async_get_urls($urls, $options) {
	$mh = curl_multi_init();
	$ch = array();
	$handles = array();
	foreach($urls as $k => $url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt_array($ch, $options);
		curl_multi_add_handle($mh, $ch);
		$handles[$url] = $ch;
	}
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
	$res = array();
	foreach($handles as $k => $ch) {
		$res[$k] = curl_multi_getcontent($ch);
		curl_multi_remove_handle($mh, $ch);
		curl_close($ch);
	}
	curl_multi_close($mh);
	return $res;
}

?>
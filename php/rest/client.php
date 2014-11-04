<?php

	function curl_request($url, $method='POST') {
		$ch = curl_init(); //初始化CURL句柄
		curl_setopt($ch, CURLOPT_URL, $url); //设置请求的URL
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method); //设置请求方式
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch); //执行预定义的CURL
		
		if(!curl_errno($ch)) {
			$info = curl_getinfo($ch);
			echo 'Use ' . $info['total_time'] . ' seconds to send a request to ' . $info['url'] . '<br /><br />';
		} else {
			echo 'Curl error: ' . curl_error($ch) . '<br /><br />';
		}
		curl_close($ch);
		return $result;
	}
	
	$url = 'http://localhost/workspace/utilities/rest/server.php';
	echo $return = curl_request($url, 'POST');

?>
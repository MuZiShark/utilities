<?php

	header("Content-Type:text/html;charset=utf-8");
	
	$redis = new Redis();
	
	$conn = $redis->connect('127.0.0.1', 6379);
	
	if(!$conn) {
		echo 'Redis服务器未开启';
		die();
	} else {
		return $conn;
	}
	
?>
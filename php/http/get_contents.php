<?php

	header("Content-type:text/html;charset=utf-8");

	$url = 'http://www.mama.cn/';
	var_dump(file_get_contents($url));

	$url = 'http://www.thinkphp.cn/';
	var_dump(file_get_contents($url));

?>
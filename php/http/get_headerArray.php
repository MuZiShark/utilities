<?php

	$url = 'http://www.baidu.com/';
	
	$headerArray = get_headers($url, 1);
	//var_dump($headerArray);
	
	// 将数组序列化后写入文件中
	$file = 'headerArray.txt';
	file_put_contents($file, serialize($headerArray));
	
	$headerArray2 = unserialize(file_get_contents($file));
	//var_dump($headerArray2);
	
	// 从文件中反序列化得到数组
	$handle = fopen($file, 'r');
	$headerArray3 = unserialize(fread($handle, filesize($file)));
	fclose($handle);
	//var_dump($headerArray3);
	
	echo 'Game Over';

?>
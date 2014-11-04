<?php

	$url = 'http://www.baidu.com/';

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_NOBODY, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$header = curl_exec($ch);
	//echo $header;

	$file = 'header.txt';
	file_put_contents($file, $header);

	$header2 = file_get_contents($file);
	//echo $header2;
	
	$handle = fopen($file, 'r');
	$header3 = fread($handle, filesize($file));
	fclose($handle);
	//echo $header3;
	
	echo 'Game Over';

?>
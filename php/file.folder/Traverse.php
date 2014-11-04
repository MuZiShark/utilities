<?php

function traverse($flag = true, $path = '.') {	//相对路径和绝对路径都支持，但不支持中文路径
	$handle = opendir($path);
	//echo $handle."<br />";
	while(($file = readdir($handle)) != false) {
		//echo $file."<br />";
		$filePath = $path.DIRECTORY_SEPARATOR.$file;
		if($file == '.' || $file == '..') {
			continue;
		} else if(is_dir($filePath)) {	//如果是目录，则递归
			echo 'Directory '.$file.':<br />';
			if($flag) traverse($flag, $filePath);
		} else if(is_file($filePath)) {	//如果是文件，则输出
			echo 'File in Directory '.$path.': '.$file.'<br />';
		}
	}
	closedir($handle);
}

$path = 'G:';

traverse(true, $path);

?>
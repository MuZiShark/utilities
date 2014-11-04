<?php

header("Content-type:text/html;charset=utf8");

function getWH($picurl){
	$imagesize = getimagesize($picurl);
	$info[0] = $imagesize[0];
	$info[1] = $imagesize[1];
	return $info;
}

function fileReName($path,$path2) {
	$handle = opendir($path);
	while(($file = readdir($handle)) !== false) {
		if($file == "." || $file == "..") {
			continue;
		} else {
			$srcFilePath = $path.DIRECTORY_SEPARATOR.$file;
			$imagesize = getWH($srcFilePath);
			$newfile = md5(serialize($file)).'_w'.$imagesize[0].'X'.$imagesize[1].'.jpg';
			$dstFilePath = $path2.DIRECTORY_SEPARATOR.$newfile;
			if(rename($srcFilePath, $dstFilePath)) {
				echo $srcFilePath.'正在重命名'.$dstFilePath.'<br />';
			}
		}
	}
	closedir($handle);
}

$path = 'E:\eat';
$path2 = 'E:\eat2';
fileReName($path,$path2);

?>
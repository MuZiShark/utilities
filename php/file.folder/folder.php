<?php

// 循环生成目录
// function create_folders($dir) {
// 	return is_dir($dir) || create_folders(dirname($dir) && mkdir($dir, 0777));
// }

// for ($i=1; $i<20; $i++) {
// 	$dir="folder".$i;
// 	if(is_dir($dir)==false) {
// 		mkdir($dir, 0777);
// 	}
// }



$dirname = 'upload/'.date('Ym', time()).'/'.date('d', time()).'/';

if(!is_dir($dirname) && !mkdir($dirname, 0777, true)) {
	die('报错 : 目录不可写!');
}





?>
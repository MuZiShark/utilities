<?php

	header("content-type:text/html;charset=utf-8");

	setcookie('name', 'lirui', time()+60);
	setcookie('password', '12345', time()+60);
	//setcookie('password', md5('12345'), time()+60);
	setcookie('university', '武汉科技大学', time()+60);
	//setcookie('university', '华中科技大学', time()+60);
	setcookie('hobby1', '听音乐', time()+300);
	setcookie('hobby2', '看电影');

	echo 'COOKIE设置成功！';

?>
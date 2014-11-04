<?php

	header("content-type:text/html;charset=utf-8");
	date_default_timezone_set('Asia/Shanghai');

	var_dump($_COOKIE);

	if(!empty($_COOKIE)) {
		echo '上次登录的时间为：'.$_COOKIE['last_login_time'];
		setcookie('last_login_time', date('Y-m-d H:i:s'), time()+24*3600*30);
	} else {
		echo '这是第一次登录！';
	}

?>
<?php

	header("content-type:text/html;charset=utf-8");
	date_default_timezone_set('Asia/Shanghai');

	setcookie('last_login_time', date('Y-m-d H:i:s'), time()+24*3600*30);
	echo 'COOKIE设置成功！';

?>
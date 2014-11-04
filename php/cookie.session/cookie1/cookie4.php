<?php

	header("content-type:text/html;charset=utf-8");

	//删除指定COOKIE
	//setcookie('university', '', time()-60);
	//echo 'COOKIE删除成功！';

	//清除全部COOKIE
	foreach($_COOKIE as $key=>$value) {
		setcookie($key, '', time()-3600);
	}

	echo 'COOKIE全部清除！';

?>
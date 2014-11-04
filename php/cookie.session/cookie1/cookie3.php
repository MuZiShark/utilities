<?php

	header("content-type:text/html;charset=utf-8");

	//更新指定COOKIE
	setcookie('university', '华中科技大学', time()+60);
	echo 'COOKIE更新成功！';

?>
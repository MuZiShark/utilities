<?php

	header("content-type:text/html;charset=utf-8");

	session_start();

	$_SESSION['name'] = '李瑞';

	echo 'SESSION更新成功！';

?>
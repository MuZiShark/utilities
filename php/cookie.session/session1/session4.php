<?php

	header("content-type:text/html;charset=utf-8");

	session_start();

	//unset($_SESSION['name']);

	session_destroy();

	echo 'SESSION删除成功！';

?>
<?php

	header("Content-type:text/html;charset=utf-8");
	
	var_dump($_POST);
	var_dump($_COOKIE);
	$key = isset($_GET['key'])?$_GET['key']:'';
	$token = md5($_SERVER['HTTP_USER_AGENT'].$_SERVER['REQUEST_TIME']);
	
	session_start();
	$_SESSION['token']  = $token;
	
	echo '<form method="post">';
	echo '<input type="text" name="key" value="'.$key.'"></input>';
	echo '<input type="hidden" name="token" value="'.$token.'"></input>';
	echo '<input type="submit" value="提交">';
	echo '</form>';

?>
<?php

	require '../demos/redis1/redis.php';
	
	$uid = $_GET['id'];
	
	$res = $redis->hdel('user:'.$uid, 'id', 'username', 'password', 'age', 'sex');
	
	header('Location:list.php');
	
?>
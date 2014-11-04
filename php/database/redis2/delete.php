<?php

	require '../demos/redis2/redis.php';
	
	$uid = $_GET['id'];
	
	$redis->del('user:'.$uid);
	
	$redis->lrem('uids', 0, $uid);
	
	header('Location:list.php');
	
?>
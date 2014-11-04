<?php

	require '../demos/redis2/redis.php';
	
	$username = $_POST['username'];
	$password = $_POST['password'];
	$age = $_POST['age'];
	$sex = $_POST['sex'];
	
	$uid = $redis->incr('uid');
	
	$redis->hmset('user:'.$uid, array(
		'id' => $uid,
		'username' => $username,
		'password' => md5($password),
		'age' => $age,
		'sex' => $sex,
	));
	
	$redis->rpush('uids', $uid);
	
	$redis->set('username:'.$username,$uid);
	
	header('Location:list.php');
	
?>
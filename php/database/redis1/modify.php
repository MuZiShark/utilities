<?php

	require '../demos/redis1/redis.php';
	
	$username = $_POST['username'];
	$password = $_POST['password'];
	$age = $_POST['age'];
	$sex = $_POST['sex'];
	
	$uid = $_POST['id'];
	
	$res = $redis->hmset('user:'.$uid, array(
		'id' => $uid,
		'username' => $username,
		'password' => $password,
		'age' => $age,
		'sex' => $sex,
	));
	
	header('Location:list.php');
	
?>
<?php

$redis = new Redis();
	
$redis->connect("localhost", 6379);

$redis->set('redis', 'Hello, Rdis!');

echo $redis->get('redis');

//var_dump($redis->keys("*"));

?>
<?php

	$data = array(
		'animals' => array('1'=>'dog', '2'=>'tiger', '3'=>'elephant'),
		'fruits' => array('1'=>'apple', '2'=>'banana', '3'=>'orange')
	);
	
	switch($_SERVER['REQUEST_METHOD']) {
		case "GET":
			$id=$_GET["id"];
			echo $data['animals'][$id];
			break;
		case "POST":
			echo json_encode($data);
			break;
		default:
			exit();
	}

?>
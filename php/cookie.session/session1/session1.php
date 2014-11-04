<?php

	header("content-type:text/html;charset=utf-8");

	require_once '../demos/session/session1/Dog.class.php';

	session_start();

	$_SESSION['name'] = 'lirui';
	$_SESSION['age'] = '12345';
	$_SESSION['sex'] = TRUE;

	$arr = array('武汉', '长沙', '成都');
	$_SESSION['arr'] = $arr;

/*	class Dog {
		private $name;
		private $age;
		private $intro;

		function __construct($name, $age, $intro) {
			$this->name = $name;
			$this->age = $age;
			$this->intro = $intro;
		}

	}*/

	$dog = new Dog('大黄', 5, '这是一只很调皮的狗！');

	$_SESSION['dog'] = $dog;

	echo 'SESSION保存成功！';

?>
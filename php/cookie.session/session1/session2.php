<?php

	header("content-type:text/html;charset=utf-8");

	require_once '../demos/session/session1/Dog.class.php';

	session_start();

	var_dump($_SESSION);

	if(!empty($_SESSION)) {

		echo '打印key的val<br />';

		echo 'name:'.$_SESSION['name'].'<br />';
		echo 'age:'.$_SESSION['age'].'<br />';
		echo 'sex:'.$_SESSION['sex'].'<br />';

		echo '打印arr的val<br />';

		$arr = $_SESSION['arr'];
		foreach($arr as $key=>$val) {
			echo $val.'<br />';
		}
		
/*		class Dog {

			private $name;
			private $age;
			private $intro;

			function __construct($name, $age, $intro) {
				$this->name = $name;
				$this->age = $age;
				$this->intro = $intro;
			}

			public function getName() {
				return $this->name;
			}

			public function getAge() {
				return $this->age;
			}

			public function getIntro() {
				return $this->intro;
			}

	}*/
		echo '打印obj的val<br />';

		$dog = $_SESSION['dog'];
		echo 'name:'.$dog->getName().'<br />';
		echo 'age:'.$dog->getAge().'<br />';
		echo 'intro:'.$dog->getIntro().'<br />';
	} else {
		echo 'SESSION为空！';
	}

?>
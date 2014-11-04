<?php

/**
 * PHP面向对象：类和对象
 *
 *
 */

class MyPC {
	
	private $name;
	
	function __construct($name = '') {
		return $this->name = $name;
	}
	
	function __get($key) {
		return $this->$key.'123';
	}
	
	function __set($key, $value) {
		$this->$key = $value;
	}
	
	private function power() {
		return $this->name.'打开电源，正在开机……';
	}
	
	function ok() {
		return $this->power().'开机成功！';
	}
	
}


$pc1 = new MyPC('我的电脑');

$pc1->name = '我的笔记本电脑';

echo $pc1->name;
//echo $pc1->power();
//echo $pc1->ok();


?>

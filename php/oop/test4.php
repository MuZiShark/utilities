<?php

/**
 * PHP面向对象：抽象方法和抽象类
 *
 *
 */

	abstract class Master {
		
		abstract function fun1();
		
		abstract function fun2();
		
		abstract function fun3();
		
		function ok() {
			echo 'ok'.'<br />';
		}
		
	}
	
	//$p = new Master();
	
	class Slave extends Master {
		
		function fun1() {
			echo 'fun1';
		}
		
		function fun2() {
			echo 'fun2';
		}
		
		function fun3() {
			echo 'fun3';
		}
		
		function okay() {
			echo 'okay'.'<br />';
		}
		
	}
	
	$p = new Slave();
	
	$p->ok();
	
	$p->okay();
	
	
?>

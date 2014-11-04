<?php

	/**
	 * PHP面向对象：继承与重载
	 * 
	 * 
	 */

	class Father {
		
		function f() {
			return 'Father printing...'.'<br />';
		}
	}

	class Son extends Father {
		
		function f() {
			return 'Son printing...'.Father::f().'<br />';
		}
	}
	
	$p = new Son();
	
	echo $p->f();
	
	$q = new Father();
	
	echo $q->f();









?>
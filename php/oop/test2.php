<?php

	/**
	 * PHP面向对象：继承
	 * 
	 * 
	 */

	class Father {
		
		function f() {
			return 'Father printing...'.'<br />';
		}
	}

	class Son extends Father {
		
		function s() {
			return 'Son printing...'.$this->f().'<br />';
		}
	}
	
	$p = new Son();
	
	echo $p->s();
	
	$q = new Father();
	
	echo $q->f();



?>
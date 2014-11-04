<?php

	/**
	 * PHP面向对象：继承
	 * 
	 * 
	 */

	class Staff {
		
		protected $name;
		protected $title;
		
		function __construct() {
			echo '<p>Staff constructor called!</p>';
		}
	}

	class Manager extends Staff {
		
		function __construct() {
			parent::__construct();
			echo '<p>Manager constructor called!</p>';
		}
	}
	
	$manager = new Manager();




?>
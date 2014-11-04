<?php

	/**
	 * PHP面向对象：继承
	 * 
	 * 
	 */

	class Book {
		
		private $title;
		private $isbn;
		private $copies;
		
		function __construct($isbn) {
			echo '<p>Book class instance created!</p>';
		}

		function __destruct() {
			echo '<p>Book class instance destroyed!</p>';
		}
		
	}
	
	$book = new Book();




?>
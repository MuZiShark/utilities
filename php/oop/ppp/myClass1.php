<?php

class myClass {
	
	public $public = 'public';
	private $private = 'private';
	protected $protected = 'protected';
	
	function say() {
		echo $this->public;
		echo $this->private;
		echo $this->protected;
	}
}

$obj = new myClass();

echo $obj->public;
// Fatal error: Cannot access private property MyClass::$private
//echo $obj->private;
// Fatal error: Cannot access protected property MyClass::$protected
//echo $obj->protected;
echo '<br />';

$obj->say();
echo '<br />';

?>
<?php

include_once 'myClass1.php';

class myClass2 extends myClass1 {
	
	protected $protected = 'protected2';
	
	function say() {
		echo $this->public;
		echo $this->protected;
	}
}

$obj2 = new myClass2();

echo $obj->public;
// Fatal error: Cannot access private property MyClass::$private
//echo $obj->private;
//  Fatal error: Cannot access protected property MyClass::$protected
echo $obj->protected;
echo '<br />';

echo $obj2->public;
// Notice: Undefined property: MyClass2::$private
//echo $obj2->private;
// Fatal error: Cannot access protected property MyClass2::$protected
//echo $obj2->protected;
echo '<br />';

$obj2->say();
echo '<br />';

?>
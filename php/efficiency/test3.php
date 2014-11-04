<?php

class dog {
	
	private $_name = "";
	
	function __set($property, $value) {
		if($property == "name") {
			$this->_name = $value;
		}
	}
	function __get($property) {
		if($property == "name") {
			return $this->_name;
		}
	}
}

$myDog = new dog();

for($x=0; $x<10; $x++) {
	$t = microtime(true);
	for($i=0; $i<100000; $i++) {
		$myDog->__set(name, "dog1");
		$myDog_name = $myDog->__get(name);
	}
	echo microtime(true) - $t;
	echo "\n";
}

?>
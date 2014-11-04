<?php

class dog {
	
	public $name = "";
	
	public function setName($name) {
		$this->name = $name;
	}
	public function getName() {
		return $this->name;
	}
}

$myDog = new dog();

for($x=0; $x<10; $x++) {
	$t = microtime(true);
	for($i=0; $i<100000; $i++) {
		$myDog->setName("dog1");
		$myDog_name = $myDog->getName();
	}
	echo microtime(true) - $t;
	echo "\n";
}

?>
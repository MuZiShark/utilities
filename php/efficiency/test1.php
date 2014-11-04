<?php

for($x=0; $x<10; $x++) {
	$t = microtime(true);
	for($i=0; $i<100000; $i++) {
		$myDog_name = "dog1";
	}
	echo microtime(true) - $t;
	echo "\n";
}

?>
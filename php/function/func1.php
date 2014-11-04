<?php

	function addition1($x, $y) {
		$x++;
		$y++;
		return $x+$y;
	}

	function addition2(&$x, &$y) {
		$x++;
		$y++;
		return $x+$y;
	}

	$a=1;
	$b=1;
	echo addition1($a, $b).'<br />',$a.'<br />',$b.'<br />';

	$a=2;
	$b=2;
	echo addition2($a, $b).'<br />',$a.'<br />',$b.'<br />';

?>
<?php

	function format1($string = 'This is a test', $length = 9, $dot = ' ...', $chartset = 'utf-8') {
		$out = '';
		$out .= 'string: '.$string.'<br />';
		$out .= 'length: '.$length.'<br />';
		$out .= 'dot: '.$dot.'<br />';
		$out .= 'chatset: '.$chartset.'<br />';
		return $out;
	}
	
	function format2($string = 'This is a test', $length = 9, $dot = ' ...', $chartset = 'utf-8', $link = NULL) {
		$out = '';
		$out .= 'string: '.$string.'<br />';
		$out .= 'length: '.$length.'<br />';
		$out .= 'dot: '.$dot.'<br />';
		$out .= 'chatset: '.$chartset.'<br />';
		$out .= 'link: '.$link.'<br />';
		return $out;
	}

	echo format1('', '', '', '');echo '<div style="color:red">==============================</div>';
	echo format1();echo '<div style="color:red">==============================</div>';
	echo format1('welcome to our school','1' ,'2' ,'3');echo '<div style="color:red">==============================</div>';

//	echo format1('welcome to our school');echo '<div style="color:red">==============================</div>';
//	echo format1('welcome to our school', 6);echo '<div style="color:red">==============================</div>';
//	echo format1('welcome to our school', 6, ' ---');echo '<div style="color:red">==============================</div>';
//	echo format1('welcome to our school', 6, ' ---', NULL);echo '<div style="color:red">==============================</div>';
//	echo format1('welcome to our school', NULL, NULL, NULL);echo '<div style="color:red">==============================</div>';

	echo format2('', '', '', '', '');echo '<div style="color:red">==============================</div>';
	echo format2();echo '<div style="color:red">==============================</div>';
	echo format2('welcome to our school','1', '2', '3', '4');echo '<div style="color:red">==============================</div>';

?>
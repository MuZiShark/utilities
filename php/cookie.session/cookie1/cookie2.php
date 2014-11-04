<?php

	header("content-type:text/html;charset=utf-8");

	echo '<pre>';
	print_r($_COOKIE);
	echo '</pre>';

	if (!empty($_COOKIE)) {
    	foreach ($_COOKIE as $key=>$value) {
        	echo "$key : $value <br />\n";
        }
    } else {
		echo 'COOKIE失效！';
	}

?>
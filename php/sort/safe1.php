<?php

	header("Content-type:text/html;charset=utf-8");
	
	$key = isset($_GET['keyword'])?$_GET['keyword']:'';
	
	echo '<form>';
	echo '<input type="text" name="keyword" value="'.$key.'"></input>';
	echo '<input type="submit" value="提交">';
	echo '</form>';

?>
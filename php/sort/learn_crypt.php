<?php

	header("Content-type:text/html;charset=utf-8");
	
	$salt = crypt('mypass');
	
	$mypass = isset($_POST['mypass'])?$_POST['mypass']:'';
	
	if(crypt($mypass, $salt) == $salt) {
		echo 'Password Verified!';
	} else {
		echo 'Password Failed!';
	}
	
	echo '<form method="post">';
	echo '<input type="password" name="mypass" />';
	echo '<input type="submit" value="提交">';
	echo '</form>';

?>
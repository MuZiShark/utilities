<?php

	setcookie('auth', '', time()-1);
	header('Location:list.php');
	
?>
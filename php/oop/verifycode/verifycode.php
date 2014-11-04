<?php

	session_start();
	
	include "../demos/object/verifycode/verifycode.class.php";
	$code = new verifyCode(80, 20, 4);
	$code->showImage();   //�����ҳ���й� ע����¼ʹ��
	$_SESSION["code"]=$code->getCheckCode();  //����֤�뱣�浽��������
	
?>
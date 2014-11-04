<?php

// 设置参数
$db_host = 'localhost';
$db_name = 'demos';
$db_user = 'root';
$db_pwd	= '';
$timezone="Asia/Shanghai";

// 建立连接
$conn = mysql_connect($db_host, $db_user, $db_pwd) or die('数据库连接失败！错误原因：'.mysql_error());

// 选择数据库
mysql_select_db($db_name, $conn) or die('数据库选择失败！错误原因：'.mysql_error());

mysql_query('set names utf8', $conn) or die(mysql_errno());

//mysql_query('truncate table student', $conn);

?>
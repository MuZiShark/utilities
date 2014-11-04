<?php

// 设置变量
$DB_HOST = 'localhost';
$DB_NAME = '';
$DB_USER = '';
$DB_PASSWORD = '';

// 建立连接
$conn = mysql_connect($DB_HOST, $DB_USER, $DB_PASSWORD) or die('数据库连接失败！错误原因：'.mysql_error());

// 选择数据库
mysql_select_db($DB_NAME, $conn) or die('数据库选择失败！错误原因：'.mysql_error());







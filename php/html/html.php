<?php

header("Content-type:text/html;charset=utf-8");

echo $str = '<a href="www.baidu.com">测试页面</a>'."John & 'Adams'";
echo "<br />";

echo htmlentities($str, ENT_COMPAT, "UTF-8"); //仅编码双引号（默认）
echo "<br />";
echo htmlentities($str, ENT_QUOTES, "UTF-8"); //编码双引号和单引号
echo "<br />";
echo htmlentities($str, ENT_NOQUOTES, "UTF-8"); //不编码任何引号
echo "<br />";

echo htmlspecialchars($str, ENT_COMPAT, "UTF-8"); //仅编码双引号（默认）
echo "<br />";
echo htmlspecialchars($str, ENT_QUOTES, "UTF-8"); //编码双引号和单引号
echo "<br />";
echo htmlspecialchars($str, ENT_NOQUOTES, "UTF-8"); //不编码任何引号
echo "<br />";

?>
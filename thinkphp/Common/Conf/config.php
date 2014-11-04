<?php
defined('THINK_PATH') or exit();

return array(
		//'配置项'=>'配置值'
);

/**
 * 对字符或者数组内的字符进行转义
 * @param unknown $value
 * @return Ambigous <multitype:, string>
 */
function stripslashes_wake($value)
{
	$value = is_array($value)?
	array_map('stripslashes_wake', $value):
	addslashes($value);
	//stripslashes($value);
	return $value;
}

/**
 * 对字符或者数组内的字符进行去除转义
 * @param unknown $value
 * @return Ambigous <multitype:, string>
 */
function stripslashes_deep($value)
{
	$value = is_array($value)?
	array_map('stripslashes_deep', $value):
	//addslashes($value);
	stripslashes($value);
	return $value;
}

// 如果没开转义，则开启自动转义
if (!get_magic_quotes_gpc()) {
	$_POST = array_map('stripslashes_wake', $_POST);
	$_GET = array_map('stripslashes_wake', $_GET);
	$_COOKIE = array_map('stripslashes_wake', $_COOKIE);
}

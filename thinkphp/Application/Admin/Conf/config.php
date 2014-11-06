<?php

defined('THINK_PATH') or exit();

require_once dirname(__FILE__) . '/ip.php';
require_once dirname(__FILE__) . '/mail.php';

return array_merge(array(
    'WEB_URL' => 'http://www.lirui.cn/',
    'WEB_TITLE' => '怀孕管家后台系统',

    /* DB设置 */
    'DB_TYPE' => 'mysql',		// 数据库类型
    'DB_HOST' => 'localhost',	// 服务器地址
    'DB_NAME' => 'lirui',		// 数据库名
    'DB_USER' => 'root',		// 用户名
    'DB_PWD' => '',				// 密码
    'DB_PORT' => '3306',		// 端口
    'DB_PREFIX' => 'lirui_',		// 数据库表前缀

    /* URL设置 */
    'URL_MODEL' => 1, // URL访问模式,可选参数0、1、2、3,代表以下四种模式：
    // 0 (普通模式); 1 (PATHINFO模式); 2 (REWRITE模式); 3 (兼容模式)  默认为PATHINFO 模式

    /* USER配置 */
    'USER_ALLOW_REGISTER'	=>	1,	// 注册开闭
    'USER_ADMINISTRATOR'	=>	'1',
), $ip, $mail);

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

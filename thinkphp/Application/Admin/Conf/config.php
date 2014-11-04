<?php

require_once dirname(__FILE__).'/ip_white.php';

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
), $ip_white);

<?php

// Admin入口文件

// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');
// 开启调试模式
define('APP_DEBUG', true);
// 关闭目录安全文件的生成
define('BUILD_DIR_SECURE', false);
// 定义根目录
define('ROOT_PATH', dirname(dirname(dirname(__FILE__))));

// 定义应用名称
define('APP_NAME', 'Application');
// 定义应用目录
define('APP_PATH', ROOT_PATH.'/'.APP_NAME.'/');
// 定义Common目录
define('COMMON_PATH', ROOT_PATH.'/Common/');
// 定义Public目录
define('PUBLIC_PATH', ROOT_PATH.'/Public/home');
// 定义Runtime目录
define('RUNTIME_PATH', ROOT_PATH.'/Runtime/home');

// 绑定Main模块到当前入口文件
define('BIND_MODULE', 'Home');

// 定义ThinkPHP框架路径
define('THINK_PATH', dirname(dirname(dirname(__FILE__))).'/ThinkPHP3.2.2/');
// 引入ThinkPHP入口文件
require THINK_PATH.'ThinkPHP.php';

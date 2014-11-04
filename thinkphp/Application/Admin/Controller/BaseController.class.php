<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Util;
class BaseController extends Controller {
	
	/**
	 * 后台控制器初始化
	 */
	protected function _initialize() {
		// 发送header, 修复 IE 浏览器在 iframe 下限制写入 cookie 的问题
		header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
		// 获取当前用户UID
		define('UID', is_login());
// 		// 检测当前用户是否为超级管理员
// 		define('IS_ROOT', is_administrator());
// 		if (is_login()) {
// 			// 检测IP地址是否禁用，超级管理员不检测，白名单开关默认关闭
// 			if (!IS_ROOT && C('IP_WHITE_ON')) {
// 				if (!in_array(get_client_ip(), C('IP_WHITE_LIST'))) {
// 					exit("<script>alert('您的IP地址禁止登录！');parent.parent.parent.window.location.href='".__MODULE__."/Public/login';</script>");
// 				}
// 			}
// 			// 检测访问权限
// 			$access = $this->accessControl();
// 			if($access === false) {
// 				// 检测动作权限
// 				$rule = strtolower(CONTROLLER_NAME.'/'.ACTION_NAME);
// 				if(!$this->checkRule($rule)) {
// 					$this->display(T('Public/refuse'));
// 					die();
// 				}
// 			}
// 		} else {
// 			exit('<script>parent.parent.window.location.href="'.__MODULE__.'/Public/login'.'";</script>');
// 		}
    }
    
//     /**
//      * action访问控制，在登陆成功后执行的第一项权限检测任务
//      * 如是超级管理员，则返回 true；如不是超级管理员，则检测是否让其进入首页
//      * 检测通过，则返回 true
//      * 检测不通过，则返回false
//      * @return boolean 返回值必须使用 `===` 进行判断
//      */
//     protected function accessControl() {
//     	if (IS_ROOT) {
//     		return true; //超级管理员允许访问任何页面
//     	}
//     	$allow = array(
//     		'frame/top',
//     		'frame/left',
//     		'frame/welcome',
//     		'index/welcome',
//     		'user/modifyNickname',
//     		'user/modifyPassword',
//     		'user/reg',
//     	);
//     	$check = CONTROLLER_NAME.'/'.ACTION_NAME;
//     	if (!empty($allow) && in_array_case($check, $allow)) {
//     		return true;
//     	}
//     	return false;
//     }
    
//     /**
//      * rule权限检测
//      * @param $rule
//      * @return boolean 返回true表示权限通过检测，false表示权限未通过检测
//      */
//     protected function checkRule($rule) {
//     	static $Auth = null;
//     	if (!$Auth) {
//     		$Auth = new \Admin\Util\Auth();
//     	}
//     	if (!$Auth->check($rule, UID)) {
//     		return false;
//     	}
//     	return true;
//     }
}
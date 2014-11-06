<?php
namespace Admin\Controller;
use User\Api\UserApi;
class PublicController extends \Think\Controller {

	/* 后台登录 */
	public function login() {
		$username = I('post.username');
		$password = I('post.password');
		// 判断是否提交登录表单
		if (IS_POST) { //若提交，则进行登录验证
			// 检测IP地址
			if (C('IP_WHITE_ON')) {
				if (!in_array(get_client_ip(), C('IP_WHITE_LIST'))) {
					$this->error('您的IP地址禁止登录！');
				}
			}
			// 验证用户名和密码，调用UC登录接口登录
			$User = new UserApi();
			$uid = $User->login($username, $password);
			if (0 < $uid) { //若UC登录成功，则登录后台
				$result = D('User')->login($uid);
				if($result) { //若后台登录成功，则跳转到后台首页
					redirect(__MODULE__.'/Index/welcome');
				} else { //若后台登录失败，则返回登录页面
					$error = D('User')->getError();
					$this->error($error, __MODULE__.'/Public/login');
				}
			} else { //若UC登录失败，则报错
				switch ($uid) {
					case -1: $error = '用户不存在或被禁用！'; break;
					case -2: $error = '密码不正确！'; break;
					default: $error = '未知错误';
				}
				$this->error($error, __MODULE__.'/Public/login');
			}
		}
		$this->display();
	}
	
	/* 退出登录 */
	public function logout() {
		if (is_login()) {
			D('User')->logout();
		}
		exit('<script>parent.parent.window.location.href="'.__MODULE__.'/Public/login'.'";</script>');
	}
}
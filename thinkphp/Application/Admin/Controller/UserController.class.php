<?php
namespace Admin\Controller;
use Think\Controller;
use User\Api\UserApi;
class UserController extends BaseController {
	
	/* 后台注册 */
	public function reg() {
		// 注册开关
		if(!C('USER_ALLOW_REGISTER')) {
			$this->error('注册已关闭');
		}
		// 获取post过来的参数
		$username = I('post.username');
		$password = I('post.password');
		$repassword = I('post.repassword');
		// 判断是否提交注册表单
		if(IS_POST) { //若提交，则进行注册
			// 检测两次密码
			if ($password != $repassword) {
				$this->error('两次密码不一致！');
			}
			// 注册用户，调用UC注册接口
			$User = new UserApi();
			$uid = $User->register($username, $password);
			if(0 < $uid) { //若UC注册成功，则写入数据库
				$user = array(
					'uid'      => $uid,
					'nickname' => $username,
					'reg_ip'   => get_client_ip(1),
					'reg_time' => NOW_TIME,
					'count'    => 0,
					'status'   => 1,
				);
				$result = D('User')->add($user);
				if($result) {
					$this->success('注册成功！', __MODULE__.'/Public/login');
				} else {
					$error = D('User')->getError();
					$this->error($error, __MODULE__.'/Public/login');
				}
			} else { //若UC注册失败，则报错
				$this->error($this->showRegError($uid));
			}
		} else { //显示注册表单
			$this->meta_title = '后台注册';
			$this->display();
		}
	}
	
	/**
	 * 获取用户注册错误信息
	 * @param  integer $code 错误编码
	 * @return string        错误信息
	 */
	private function showRegError($code = 0) {
		switch ($code) {
			case -1:  $error = '用户名长度必须在16个字符以内！'; break;
			case -2:  $error = '用户名被禁止注册！'; break;
			case -3:  $error = '用户名被占用！'; break;
			case -4:  $error = '邮箱格式不正确！'; break;
			case -5:  $error = '邮箱被禁止注册！'; break;
			case -6:  $error = '邮箱被占用！'; break;
			case -7:  $error = '手机号码格式不正确！'; break;
			case -8:  $error = '手机号码被禁止注册！'; break;
			case -9:  $error = '手机号码被占用！'; break;
			case -10: $error = '密码长度必须在6-30个字符之间！'; break;
			default:  $error = '未知错误';
		}
		return $error;
	}
	
	/* 修改昵称 */
	public function modifyNickname() {
		// 获取post过来的参数
		$nickname = I('post.nickname');
		$password = I('post.password');
		// 提交修改资料
		if(IS_POST) {
			// 检查必填项
			if (empty($nickname) || empty($password)) {
				$this->error('必填项不能为空！');
			}
			// 调用UC接口，对原密码进行验证
			$User = new UserApi();
			$uid = $User->login(UID, $password, 4);
			if($uid == -2) {
				$this->error('原密码不正确！');
			}
			// 修改昵称
			$data = array('nickname' => $nickname);
			if (!D('User')->create($data)) {
				$this->error(D('User')->getError());
			}
			$result = D('User')->where(array('uid'=>$uid))->save($data);
			if ($result) { //昵称修改成功，则更新session
				$user = session('user_auth');
				$user['username'] = $data['nickname'];
				session('user_auth', $user);
				session('user_auth_sign', data_auth_sign($user));
				$this->success('昵称修改成功！');
			} else {
				$this->error('昵称修改失败！');
			}
		}
		$this->meta_title = '修改昵称';
		$this->display();
	}
	
	/* 修改密码 */
	public function modifyPassword() {
		// 获取post过来的参数
		$old = I('post.old');
		$password = I('post.password');
		$repassword = I('post.repassword');
		// 提交修改资料
		if(IS_POST) {
			// 检查必填项
			if (empty($old) || empty($password) || empty($repassword)) {
				$this->error('必填项不能为空！');
			}
			// 检测两次密码
			if ($password != $repassword) {
				$this->error('两次密码不一致！');
			}
			// 调用UC接口，对原密码进行验证，同时修改密码
			$User = new UserApi();
			$data['password'] = think_ucenter_md5($password, UC_AUTH_KEY);
			$res = $User->updateInfo(UID, $old, $data);
			if ($res['status']) { //密码修改成功则退出，重新登录
				$this->success('密码修改成功！');
				exit('<script>parent.parent.window.location.href="'.__MODULE__.'/Public/login'.'";</script>');
			} else { //密码修改失败
				if ($res['info'] == -10) {
					$this->error('新密码长度必须在6-30个字符之间！');
				} else {
					$this->error($res['info']);
				}
			}
		}
		$this->meta_title = '修改密码';
		$this->display();
	}
}
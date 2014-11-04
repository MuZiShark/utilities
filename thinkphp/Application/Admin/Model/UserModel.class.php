<?php
namespace Admin\Model;
use Think\Model;
class UserModel extends Model {
	
	protected $tableName = 'admin_user';
	
	// 自动验证
	protected $_validate = array(
		array('nickname', '4,16', '昵称长度必须在4-16个字符之间！', self::EXISTS_VALIDATE, 'length'),
		array('nickname', '', '昵称被占用！', self::EXISTS_VALIDATE, 'unique'),
	);
	
	/**
	 * 用户登录
	 * @param  int     $uid 用户ID
	 * @return boolean ture-登录成功，false-登录失败
	 */
	public function login($uid, $password) {
		// 检测用户是否有效
		$user = $this->field(true)->find($uid);
		if(!$user || !$user['status']) {
			$this->error = '用户不存在或被禁用！';
			return false;
		}
		// 自动登录
		$this->autoLogin($user);
		return true;
	}
	
	// 自动登录用户
	public function autoLogin($user) {
		// 更新登录信息
		$data = array(
			'uid' => $user['uid'],
			'count' => array('exp', ' `count`+1 '),
			'last_login_ip' => get_client_ip(1),
			'last_login_time' => NOW_TIME,
		);
		// 写入数据库
		$this->save($data);
		// 记录session和cookies
		$auth = array(
			'uid' => $user['uid'],
			'username' => $user['nickname'],
			'last_login_ip' => $user['last_login_ip'],
			'last_login_time' => $user['last_login_time'],
		);
		session('user_auth', $auth);
		session('user_auth_sign', data_auth_sign($auth));
	}
	
	/**
	 * 注销当前用户
	 * @return void
	 */
	public function logout() {
		session('user_auth', null);
		session('user_auth_sign', null);
		session(null);
		session('[destroy]');
	}
}

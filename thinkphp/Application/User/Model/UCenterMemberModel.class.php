<?php
namespace User\Model;
use Think\Model;
/**
 * UCenter的Member模型
 */
class UCenterMemberModel extends Model {
	
	/**
	 * 数据表前缀
	 * @var string
	 */
	protected $tablePrefix = UC_TABLE_PREFIX;
	
	/**
	 * 数据表表名
	 * @var string
	 */
	protected $tableName = 'uc_member';
	
	/**
	 * 数据库连接
	 * @var string
	 */
	protected $connection = UC_DB_DSN;
	
	/* 自动验证 */
	protected $_validate = array(
		// 验证用户名
		array('username', '4,16', -1, self::EXISTS_VALIDATE, 'length'), //用户名长度不合法
		array('username', 'checkDenyMember', -2, self::EXISTS_VALIDATE, 'callback'), //用户名被禁止注册
		array('username', '', -3, self::EXISTS_VALIDATE, 'unique'), //用户名被占用,
		// 验证邮箱地址
		array('email', 'email', -4, self::EXISTS_VALIDATE), //邮箱格式不正确
		array('email', 'checkDenyEmail', -5, self::EXISTS_VALIDATE, 'callback'), //邮箱地址被禁止注册
		array('email', '', -6, self::EXISTS_VALIDATE, 'unique'), //邮箱地址被占用
		// 验证手机号码
		array('mobile', '//', -7, self::EXISTS_VALIDATE), //手机号码格式不正确
		array('mobile', 'checkDenyMobile', -8, self::EXISTS_VALIDATE, 'callback'), //手机号码被禁止注册
		array('mobile', '', -9, self::EXISTS_VALIDATE, 'unique'), //手机号码被占用
		// 验证密码
		array('password', '4,32', -10, self::EXISTS_VALIDATE, 'length'), //密码长度不合法
	);
	
	/* 自动完成 */
	protected $_auto = array(
		array('password', 'think_ucenter_md5', self::MODEL_BOTH, 'function', UC_AUTH_KEY),
		array('reg_time', NOW_TIME, self::MODEL_INSERT),
		array('reg_ip', 'get_client_ip', self::MODEL_INSERT, 'function', 1),
		array('update_time', NOW_TIME, self::MODEL_BOTH),
	);
	
	/**
	 * 检测用户信息
	 * @param  string  $field 用户名
	 * @param  integer $type  用户名类型：1-用户名，2-用户邮箱，3-用户电话
	 * @return integer        错误编号
	 */
	public function checkField($field, $type = 1) {
		$data = arrray();
		switch ($type) {
			case 1:
				$data['username'] = $field;
				break;
			case 2:
				$data['email'] = $field;
				break;
			case 3:
				$data['mobile'] = $field;
				break;
			default:
				return 0; //参数错误
		}
		return $this->create($data) ? 1 : $this->getError();
	}
	
	/**
	 * 检测用户名是不是被禁止注册
	 * @param  string $username 用户名
	 * @return boolean          ture - 未禁用，false - 禁止注册
	 */
	protected function checkDenyMember($username){
		return true; //TODO: 暂不限制，下一个版本完善
	}
	
	/**
	 * 检测邮箱地址是不是被禁止注册
	 * @param  string $email 邮箱地址
	 * @return boolean       ture - 未禁用，false - 禁止注册
	 */
	protected function checkDenyEmail($email){
		return true; //TODO: 暂不限制，下一个版本完善
	}
	
	/**
	 * 检测手机号码是不是被禁止注册
	 * @param  string $mobile 手机号码
	 * @return boolean        ture - 未禁用，false - 禁止注册
	 */
	protected function checkDenyMobile($mobile){
		return true; //TODO: 暂不限制，下一个版本完善
	}
	
	/**
	 * 用户注册
	 * @param  string $username 用户名
	 * @param  string $password 密码
	 * @param  string $email    邮箱地址
	 * @param  string $mobile   手机号码
	 * @return integer          注册成功-用户信息，注册失败-错误编号
	 */
	public function register($username, $password, $email, $mobile) {
		$data = array(
			'username' => $username,
			'password' => $password,
			'email'    => $email,
			'mobile'   => $mobile,
			'status'   => 1, //默认注册用户状态为启用
		);
		//验证邮箱地址
		if(empty($data['email']))    unset($data['email']);
		//验证手机号码
		if(empty($data['mobile']))    unset($data['mobile']);
		//添加用户
		if($this->create($data)) {
			$uid = $this->add();
			return $uid ? $uid : 0; //0-未知错误，大于0-注册成功
		} else {
			return $this->getError(); //错误信息详情见自动验证注释
		}
	}
	
	/**
	 * 用户登录
	 * @param  string  $username 用户名
	 * @param  string  $password 密码
	 * @param  integer $type     用户名类型 （1-用户名，2-邮箱，3-手机，4-UID）
	 * @return integer           登录成功-用户ID，登录失败-错误编号
	 */
	public function login($username, $password, $type = 1) {
		$map = array();
		switch ($type) {
			case 1: $map['username'] = $username; break;
			case 2: $map['email'] = $username; break;
			case 3: $map['mobile'] = $username; break;
			case 4: $map['id'] = $username; break;
			default: return 0; //参数错误
		}
		// 查找用户
		$user = $this->where($map)->find();
		// 若存在，则验证
		if (is_array($user) && $user['status']) {
			if (think_ucenter_md5($password, UC_AUTH_KEY) === $user['password']) {
				$this->updateLogin($user['id']); //更新用户登录信息
				return $user['id']; //登录成功，则返回用户ID
			} else {
				return -2; //密码错误
			}
		} else {
			return -1; //用户不存在或被禁用
		}
	}
	
	/**
	 * 更新用户登录信息
	 * @param integer $uid 用户ID
	 */
	public function updateLogin($uid) {
		$data = array(
			'id' => $uid,
			'last_login_ip' => get_client_ip(1),
			'last_login_time' => NOW_TIME,
		);
		$this->save($data);
	}
	
	/**
	 * 获取用户信息
	 * @param  string  $uid         用户ID或用户名
	 * @param  boolean $is_username 是否使用用户名查询
	 * @return array                用户信息
	 */
	public function getInfo($uid, $is_username = false) {
		$map = array();
		if ($is_username) { //通过用户名获取
			$map['username'] = $uid;
		} else {
			$map['id'] = $uid;
		}
		$user = $this->where($map)->field('id,username,email,mobile,status')->find();
		if(is_array($user) && $user['status'] = 1) {
			return array($user['id'], $user['username'], $user['email'], $user['mobile']);
		} else {
			return -1; //用户名不存在或被禁用
		}
	}
	
	/**
	 * 更新用户信息
	 * @param  int $uid         用户ID
	 * @param  string $password 密码
	 * @param  array $data      修改的字段数组
	 * @return boolean          true-修改成功，false-修改失败
	 */
	public function updateInfo($uid, $password, $data) {
		// 检查参数
		if (empty($uid) || empty($password) || empty($data)) {
			$this->error = '参数错误！';
			return false;
		}
		// 更新前验证用户密码
		if(!$this->verifyUser($uid, $password)) {
			$this->error = '密码不正确！';
			return false;
		}
		// 更新用户信息
		if ($this->create($data)) {
			return $this->where(array('id'=>$uid))->save($data);
		}
		return false;
	}
	
	/**
	 * 验证用户密码
	 * @param  int $uid     用户id
	 * @param  string $pass 密码
	 * @return boolean      true-验证成功，false-验证失败
	 */
	protected function verifyUser($uid, $password) {
		$old = $this->getFieldById($uid, 'password');
		if (think_ucenter_md5($password, UC_AUTH_KEY) === $old) {
			return true;
		}
		return false;
	}
}

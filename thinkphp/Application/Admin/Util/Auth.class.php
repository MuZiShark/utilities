<?php
namespace Admin\Util;

/**
 * 权限认证类
 * 
 * 功能特性：
 * 1、是对规则进行认证，不是对节点进行认证。用户可以把节点当作规则名称实现对节点进行认证。
 *      $auth=new Auth();  $auth->check('规则名称','用户id')
 * 2、可以同时对多条规则进行认证，并设置多条规则的关系（or或者and）
 *      $auth=new Auth();  $auth->check('规则1,规则2','用户id','or/and')
 *      当第三个参数为or时，表示用户值需要具备其中一个条件即可。默认为or。
 *      当第三个参数为and时，表示用户需要同时具有规则1和规则2的权限。 
 * 3、一个用户可以属于多个用户组。
 * 4、支持规则表达式。
 *      在pt_auth_rule 表中定义一条规则时，如果type为1，则 condition字段就可以定义规则表达式。
 *      如定义{score}>5 and {score}<100 表示用户的分数在5-100之间时这条规则才会通过。
 *      
 *      
 *      
 * 数据库表设计：
-- ----------------------------
-- 管理员用户信息表
-- pt_admin_user
-- ----------------------------
DROP TABLE IF EXISTS `pt_admin_user`;
CREATE TABLE `pt_admin_user` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户UID',
  `username` varchar(20) NOT NULL DEFAULT '' COMMENT '用户名称',
  `realname` varchar(20) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '密码',
  `addtime` int(10) unsigned NOT NULL DEFAULT '' COMMENT '注册时间',
  `last_login_ip` char(20) NOT NULL DEFAULT '' COMMENT '最后登录IP',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '' COMMENT '最后登录时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态[启用1禁用0]',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- ----------------------------
-- 菜单信息表
-- pt_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `pt_admin_menu`;
CREATE TABLE `pt_admin_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '菜单ID',
  `url` char(255) NOT NULL COMMENT '菜单URL',
  `name` char(20) NOT NULL COMMENT '菜单名称',
  `description` varchar(80) DEFAULT NULL COMMENT '菜单描述',
  `pid` int(10) unsigned NOT NULL COMMENT '菜单的父ID',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序[默认0]',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态[启用1禁用0]',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- ----------------------------
-- 权限规则表pt_auth_rule
-- rid:主键，menu_id：菜单id，status 状态：为1正常，为0禁用，condition：规则表达式，为空表示存在就验证，不为空表示按照条件验证
-- ----------------------------
DROP TABLE IF EXISTS `pt_auth_rule`;
CREATE TABLE `pt_auth_rule` (
  `rid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '权限id',
  `menu_id` int(10) unsigned NOT NULL COMMENT '菜单id',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '权限状态[启用1禁用0]',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `condition` char(100) NOT NULL DEFAULT '',  # 规则附件条件,满足附加条件的规则,才认为是有效的规则
  PRIMARY KEY (`rid`),
  UNIQUE KEY `rid_menu_id` (`rid`,`menu_id`) USING BTREE,
  KEY `rid` (`rid`),
  KEY `menu_id` (`menu_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- ----------------------------
-- pt_auth_group
-- 管理员分组信息表，
-- id：主键， title:用户组中文名称， rules：用户组拥有的规则id， 多个规则","隔开，status 状态：为1正常，为0禁用
-- ----------------------------
DROP TABLE IF EXISTS `pt_auth_group`;
CREATE TABLE `pt_auth_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理员分组ID',
  `name` char(20) NOT NULL COMMENT '管理员分组名称',
  `description` varchar(80) DEFAULT NULL COMMENT '描述',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态[启用1禁用0]',
  `rules` varchar(255) NOT NULL COMMENT '权限id列表，逗号隔开',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- ----------------------------
-- pt_auth_group_access
-- 用户分组明细表
-- ----------------------------
DROP TABLE IF EXISTS `pt_auth_group_access`;
CREATE TABLE `pt_auth_group_access` (
  `uid` int(10) unsigned NOT NULL COMMENT '管理员用户UID',
  `group_id` int(10) unsigned NOT NULL COMMENT '管理员分组GROUP_ID',
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
*/

class Auth {
	
	protected $_config = array(
		//--------表pt_admin_group_access：用户和用户组关系-------
		'AUTH_GROUP_ACCESS' => 'pt_admin_group_access', //对应表pt_admin_group_access
		'GROUP_ACCESS_UID' => 'uid', //用户uid
		'GROUP_ACCESS_GROUPID' => 'group_id', //group字段，表pt_admin_group的id
		
		
		//--------表pt_admin_group：用户组---------------------
		'AUTH_GROUP' => 'pt_admin_group', //对应表pt_admin_group
		'GROUP_ID' => 'id', //用户组id
		'GROUP_STATUS' => 'status', //用户组status
		'GROUP_RULES' => 'rules', //对应表pt_admin_rule中的权限rid
		
		
		//--------表pt_admin_rule：权限------------------------
		'AUTH_RULE' => 'pt_admin_rule', //对应表pt_admin_rule
		'RULE_ID' => 'rid', //权限rid
		'RULE_STATUS' => 'status', //权限status
		'RULE_MENUID' => 'menu_id', //对应表pt_admin_menu中的菜单id
		
		
		//--------表pt_admin_menu：菜单------------------------
		'MENU' => 'pt_admin_menu', //对应表pt_admin_menu
		'MENU_ID' => 'id', //菜单id
		'MENU_URL' => 'url', //菜单url
		'MENU_STATUS' => 'status', //菜单status
		
		
		// 开启验证
		'AUTH_ON' => true,
		//验证方式:1-实时验证，2-登录验证（存放在session中）
		'AUTH_TYPE' => 1
	);
	
	//检查用户$uid的$rule规则是否允许
	public function check($rule, $uid, $mode='url', $relation='or') {
		if(!$this->_config['AUTH_ON'])
			return true;
		// 获取用户$uid需要验证的所有有效规则列表
		$auth_list = $this->getAuthList($uid);
		if(is_string($rule)) {
			$rule = strtolower($rule);
			if(strpos($rule, ',') !== false) {
				$rule = explode(',', $rule);
			} else {
				$rule = array($rule);
			}
		}
		// 保存验证通过的规则名
		$list = array();
		if($mode == 'url') {
			$REQUEST = unserialize(strtolower(serialize($_REQUEST)));
		}
		foreach($auth_list as $auth) {
			$query = preg_replace('/^.+?/U', '', $auth);
			// url模式
			if($mode == 'url' && $query != $auth) {
				// 解析规则中的param
				parse_str($query, $param);
				$auth = preg_replace('/\?.*$/U', '', $auth);
				$intersect = array_intersect_assoc($REQUEST, $query);
				if(in_array($auth,$rule) && $intersect==$param) {
					$list[] = $auth;
				}
			} else if(in_array($auth, $rule)) {
				$list[] = $auth;
			}
		}
		// 逻辑or
		if($relation=='or' && !empty($list)) {
			return true;
		}
		// 找出差集
		$diff_arr = array_diff($rule, $list);
		// 逻辑and
		if($relation=='and' && empty($diff_arr)){
			return true;
		}
		return false;
	}
	
	/*
	 * 获得权限列表
	 * @param integer $uid  用户id  
	 */
	protected function getAuthList($uid) {
		// 保存用户验证通过的权限
		static $_authList = array();
		// 若权限列表已存在则返回
		if(isset($_authList[$uid])) {
			return $_authList[$uid];
		}
		// 若AUTH_TYPE为2，则检查session返回其数据
		if( $this->_config['AUTH_TYPE'] == 2 && isset($_SESSION['_AUTH_LIST_'.$uid])) {
			return $_SESSION['_AUTH_LIST_'.$uid];
		}
		// 读取用户所属的用户组
		$groups = $this->getGroups($uid);
		// 保存用户所属用户组设置的所有权限规则id
		$rule_ids = array();
		foreach($groups as $item) {
			$rule_ids = array_merge($rule_ids, explode(',', trim($item[$this->_config['GROUP_RULES']], ',')));
		}
		// 去除重复的rule_id
		$rule_ids = array_unique($rule_ids);
		if(empty($rule_ids)) {
			$_authList[$uid] = array();
			return array();
		}
		// 通过rule_id获取权限规则，先获取菜单id
		$where = array(
			$this->_config['RULE_ID'] => array("in", $rule_ids),
			$this->_config['RULE_STATUS'] => 1
		);
		$menu_ids = D($this->toTableName($this->_config['AUTH_RULE']))
			->where($where)->getField($this->_config['RULE_MENUID'], true);
		// 获取权限规则$rules
		$where = array(
			$this->_config['MENU_ID'] => array("in", $menu_ids),
			$this->_config['MENU_STATUS'] => 1
		);
		$field = $this->_config['MENU_URL'];
		$rules = D($this->toTableName($this->_config['MENU']))
			->where($where)->field($field)->select();
		// 统一小写格式
		$authList = array();
		foreach($rules as $val) {
			$authList[] = strtolower($val[$this->_config['MENU_URL']]);
		}
		//存入保存权限的静态数组中
		$_authList[$uid] = array_unique($authList);
		//若为登录验证，则写入session中
		if($this->_config['AUTH_TYPE'] == 2) {
			$_SESSION["_AUTH_LIST_".$uid] = $authList;
		}
		return array_unique($authList);
	}
	
	/*
	* 获得用户所属的用户组
	* @param integer $uid  用户id
	*/
	protected function getGroups($uid) {
		static $groups = array();//保存用户组
		if(isset($groups[$uid])) {
			return $groups[$uid];
		}
		//获得所在组的group_id
		$where = array(
			$this->_config['GROUP_ACCESS_UID'] => $uid
		);
		$field = $this->_config['GROUP_ACCESS_GROUPID'];
		$group_ids = D($this->toTableName($this->_config['AUTH_GROUP_ACCESS']))
			->where($where)->field($field)->select();
		foreach($group_ids as $k=>$g) {
			if(isset($g[$this->_config['GROUP_ACCESS_GROUPID']])) {
				$where = array(
					$this->_config['GROUP_ID'] => $g[$this->_config['GROUP_ACCESS_GROUPID']],
					$this->_config['GROUP_STATUS'] => 1
				);
				$field = $this->_config['GROUP_RULES'];
				$group_ids[$k][$this->_config['GROUP_RULES']] = D($this->toTableName($this->_config['AUTH_GROUP']))
					->where($where)->getField($field);
				//去除该用户组下不存在的rule_id
				$group_ids[$k][$this->_config['GROUP_RULES']] = $this->CheckRuleId($group_ids[$k][$this->_config['GROUP_RULES']],$g[$this->_config['GROUP_ACCESS_GROUPID']]);
			}	
		}
		$groups[$uid] = $group_ids ? $group_ids : array();
		return $groups[$uid];
	}
	
	/*
	 *将数据库表名转换成可用M，D查询的名称 
	 */
	protected function toTableName($tableName) {
		if($tableName) {
			// 去除表前缀
			$tableName = str_replace(C('DB_PREFIX'), '', $tableName);
			// 保存转换后的名称
			$name_arr = array();
			$name_arr = explode('_', $tableName);
			if(!empty($name_arr)) {
				foreach($name_arr as $name) {
					$rename .= ucfirst($name);
				}
			} else {
				$rename = ucfirst($name_arr);
			}
			return $rename;
		}
	}
	
	/*
	 * 去除用户组权限不存在的rule_id
	*/
	protected function CheckRuleId($rule_ids,$groupid){
		//转化为数组
		if(!is_array($rule_ids)) $rule_ids = explode(',',trim($rule_ids,','));
		//查找权限表对应存在的权限id
		$where = array(
				$this->_config['RULE_ID'] => array("in",$rule_ids),
		);
		$field = $this->_config['RULE_ID'];
		$result_rid = D($this->toTableName($this->_config['AUTH_RULE']))->where($where)->getField($field,true);
		//对比，若有不存在的ruledd_id，则修改用户组存放的rule集合
		$result_str = implode(',',$result_rid);
		if(array_diff($rule_ids,$result_rid)){
			//修改
			$where[$this->_config['GROUP_ID']] = $groupid;
			$data = array(
					$this->_config['GROUP_RULES'] => $result_str
			);
			D($this->toTableName($this->_config['AUTH_GROUP']))->where($where)->save($data);
		}
		return $result_str;
	}
}
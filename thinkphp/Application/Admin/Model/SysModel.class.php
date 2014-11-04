<?php
namespace Admin\Model;
use Think\Model;
class SysModel extends Model {
	const ADMIN_USER         = 'admin_user'; //用户信息表
	const ADMIN_GROUP        = 'admin_group'; //用户组信息表
	const ADMIN_GROUP_ACCESS = 'admin_group_access'; //用户和组的关系映射
	const ADMIN_GROUP_RULE   = 'admin_group_rule'; //用户组权限表
	const ADMIN_SYS_MENU     = 'admin_sys_menu'; //系统菜单
	
	
}
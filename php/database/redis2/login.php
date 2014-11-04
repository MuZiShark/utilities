<?php

	require '../demos/redis2/redis.php';
	
	$uname = isset($_POST['username'])?$_POST['username']:'';
	$upass = isset($_POST['password'])?$_POST['password']:'';
	$id = $redis->get('username:'.$uname);
	if(!empty($id)) {
		$password = $redis->hget('user:'.$id, 'password');
		if(md5($upass) == $password) {
			$auth = md5(time().$uname.rand());
			$redis->set('auth:'.$auth, $id);
			setcookie('auth', $auth, time()+86400);
			header('Location:list.php');
		}
	}
	
?>
<form action="" method="post">
<p>用户名称：<input type="text" name="username" /></p>
<p>用户密码：<input type="password" name="password" /></p>
<p><input type="submit" value="登录">&nbsp;&nbsp;<input type="reset" value="重填"></p>
</form>
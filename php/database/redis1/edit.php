<?php

	header("Content-Type:text/html;charset=utf-8");
	
	require '../demos/redis1/redis.php';
	
	$uid = $_GET['id'];
	
	$user = $redis->hgetall('user:'.$uid);
	
?>

<form action="modify.php" method="post">
<p>用户名称：<input type="text" name="username" value="<?php echo $user['username']; ?>" /></p>
<p>用户密码：<input type="password" name="password" value="<?php echo $user['password']; ?>" /></p>
<p>用户年龄：<input type="text" name="age" value="<?php echo $user['age']; ?>" /></p>
<p>用户性别：<input type="radio" name="sex" value="0" <?php if($user['sex']) echo ''; else echo 'checked="checked"'; ?> />男
			<input type="radio" name="sex" value="1" <?php if($user['sex']) echo 'checked="checked"'; else echo ''; ?> />女</p>
<p><input type="hidden" name="id" value="<?php echo $user['id']; ?>" /></p>
<p><input type="submit" value="编辑"></p>
</form>
<?php

	header("Content-Type:text/html;charset=utf-8");
	
	require '../demos/redis2/redis.php';
	
	// 计算总的记录条数
	$total = $redis->llen('uids');
	
	// 设置每页显示的记录条数
	$page_size = 3;
	
	// 计算总的页数
	$page_count = ceil($total/$page_size);
	
	// 计算当前页码
	$now = (!empty($_GET['page']))?$_GET['page']:1;
	
	//上一页
	$prev_page = (($now-1) < 1) ? 1 : ($now-1);
	
	// 下一页
	$next_page = (($now+1) > $page_count) ? $page_count : ($now+1);
	
	$uids = $redis->lrange('uids', ($now-1)*$page_size, $now*$page_size-1);
	
	foreach($uids as $uid) {
		$data[] = $redis->hgetall('user:'.$uid);
	}
	
	//过滤掉数组中的空元素
	$data = array_filter($data);
?>

<p><a href="add.php">添加用户</a></p>
<?php
	if(!empty($_COOKIE['auth'])) {
		$id = $redis->get('auth:'.$_COOKIE['auth']);
		echo $username = $redis->hget('user:'.$id, 'username');
?>，欢迎访问本站！&nbsp;&nbsp;<a href="logout.php">退出</a>
<?php
	} else {
?>
<a href="login.php">登录</a>
<?php
	}
?>

<table border="1" cellpadding="1" cellspacing="1">
	<tr>
		<th>uid</th>
		<th>username</th>
		<th>password</th>
		<th>age</th>
		<th>sex</th>
		<th width="80">操作</th>
	</tr>
	<?php foreach($data as $row) { ?>
	<tr>
		<td><?php echo $row['id']; ?></td>
		<td><?php echo $row['username']; ?></td>
		<td><?php echo $row['password']; ?></td>
		<td><?php echo $row['age']; ?></td>
		<td><?php if($row['sex']) echo '女'; else echo '男'; ?></td>
		<td><a href="edit.php?id=<?php echo $row['id']; ?>">修改</a>&nbsp;&nbsp;<a href="delete.php?id=<?php echo $row['id']; ?>">删除</a></td>
	</tr>
	<?php } ?>
	<tr>
		<td colspan="6">
		总共<?php echo $total; ?>条记录
		当前<?php echo $now; ?>/<?php echo $page_count; ?>页
		<a href="?page=1">首页</a>
		<a href="?page=<?php echo $prev_page; ?>">上一页</a>
		<a href="?page=<?php echo $next_page; ?>">下一页</a>
		<a href="?page=<?php echo $page_count; ?>">尾页</a>
		</td>
	</tr>
</table>
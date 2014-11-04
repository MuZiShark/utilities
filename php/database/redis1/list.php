<?php

	header("Content-Type:text/html;charset=utf-8");
	
	require '../demos/redis1/redis.php';
	
	$uid = $redis->get('uid');
	for($i=1; $i<=$uid; $i++) {
		$data[] = $redis->hgetall('user:'.$i);
	}
	
	//过滤掉数组中的空元素
	$data = array_filter($data);
	
?>

<p><a href="add.php">添加用户</a></p>

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
</table>
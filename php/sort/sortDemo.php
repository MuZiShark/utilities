<?php

require_once('sort.php');

$config = array (
		'arr' => array(23, 22, 41, 18, 20, 12, 200303,2200,1192) ,   //需要排序的数组值
		'sort' => 'select',                          //可能值: insert, select, bubble, quick
		'debug' => TRUE                              //可能值: TRUE, FALSE
);

$sort = new Sort($config);

var_dump($config['arr']);

var_dump($sort->display());

/*End of php*/

?>
<?php

header("Content-type:text/html;charset=utf-8");

$user = array(
		'0' => array('id'=>'10001', 'name'=>'Alex', 'link'=>'http://www.apple.com/', 'tid'=>'838801', 'summary'=>'好孩子！'),
		'1' => array('id'=>'10002', 'name'=>'Jack', 'link'=>'http://www.baidu.com/', 'tid'=>'838802', 'summary'=>'好同学！'),
		'2' => array('id'=>'10003', 'name'=>'Leon', 'link'=>'http://www.facebook.com/', 'tid'=>'838803', 'summary'=>'好同事！'),
		'3' => array('id'=>'10004', 'name'=>'Mike', 'link'=>'http://www.google.com/', 'tid'=>'838804', 'summary'=>'好老公！'),
		'4' => array('id'=>'10005', 'name'=>'Robert', 'link'=>'http://www.youtube.com/', 'tid'=>'838805', 'summary'=>'好儿子！'),
);


$activity = array('0'=>array('aid'=>'12301', 'tid'=>'838801','subject'=>'活动主题1','summary'=>'活动总结1'),
				  '1'=>array('aid'=>'12302', 'tid'=>'838802','subject'=>'活动主题2','summary'=>'活动总结2'),
				  '2'=>array('aid'=>'12303', 'tid'=>'838803','subject'=>'活动主题3','summary'=>'活动总结3'),
				  '3'=>array('aid'=>'12304', 'tid'=>'838804','subject'=>'活动主题4','summary'=>'活动总结4'),
				  '4'=>array('aid'=>'12305', 'tid'=>'838805','subject'=>'活动主题5','summary'=>'活动总结5'),
);


$temp = array();
foreach ($user as $v) $temp[$v['tid']] = $v;unset($v);
foreach ($activity as &$v) $v = array_merge($v, $temp[$v['tid']]);unset($v);
var_dump($activity);

//$temp = array();
//foreach ($activity as $v) $temp[$v['tid']] = $v;unset($v);
//foreach ($user as &$v) $v = array_merge($v, $temp[$v['tid']]);unset($v);
//var_dump($user);

?>
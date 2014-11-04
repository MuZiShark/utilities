<?php

include_once 'days.php';

show("2014-01-31");die();

function format($startDate, $endDate) {
	//检查两个日期大小，默认前小后大，如果前大后小则交换位置以保证前小后大
	if (strtotime($startDate) > strtotime($endDate)) {
		list($startDate, $endDate) = array($endDate, $startDate);
	}
	$start = strtotime($startDate);
	$end = strtotime($endDate);
	$d = ($end-$start)/86400;
	$res['a'] = $d;
	//计算
	if ($end < strtotime('+1 year', $start)) { //一年
		$res['y'] = 0;
		$res['m'] = floor($d/30);
		$res['d'] = ceil($d%30)+1;
	} else { //超过一年
		$res['y'] = 1;
		unest($res['m']);
		unest($res['d']);
	}
	return $res;
}
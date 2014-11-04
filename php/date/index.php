<?php

include_once 'days.php';

show("2014-02-01", 2002);die();

function format($startDate, $endDate) {
	// 检查两个日期大小，默认前小后大，如果前大后小则交换位置以保证前小后大
	if (strtotime($startDate) > strtotime($endDate)) {
		list($startDate, $endDate) = array($endDate, $startDate);
	}
	// 起始时间的时间戳
	$start = strtotime($startDate);
	$end = strtotime($endDate);
	// 起始时间的时间差（同一天为0，但要在结果里显示1）
	$extend = ($end-$start) / 86400;
	// 存储时间差y-m-d格式化后的数组（第一天在结果里显示1，每个月的第一天在结果里也要显示1）
	$result = array();
	$result['a'] = $extend + 1;
	// 计算
	if ($extend>=0 && $extend<=31) {
		if ($end == strtotime($startDate.'+1 month')) {
			$result['y'] = 0;
			$result['m'] = 1;
			$result['d'] = 1;
		} else {
			$result['y'] = 0;
			$result['m'] = 0;
			$result['d'] = $extend + 1;
		}
	} else {
		$y = floor($extend/365);
		if ($y >= 1) {
			$start = strtotime($startDate.'+'.$y.'year');
			$startDate = date('Y-m-d', $start);
			if ($start > $end) {
				$startDate = date('Y-m-d', strtotime($startDate.'-1 month'));
				$m = 11;
				$y--;
			}
			$extend = ($end-strtotime($startDate)) / 86400;
		}
		if (isset($m)) {
			$d = $extend;
		} else {
			$m = isset($m) ? $m : round($extend/30);
			$end >= strtotime($startDate.'+'.$m.'month') ? $m : $m--;
			if ($end >= strtotime($startDate.'+'.$m.'month')) {
				$d = ($end-strtotime($startDate.'+'.$m.'month')) / 86400;
			}
		}
		$result['y'] = (int)$y;
		$result['m'] = (int)$m;
		$result['d'] = isset($d) ? $d+1 : 1;
	}
	$result['w'] = ceil($result['a']/7);
	$result['i'] = date('m.d', strtotime($startDate.'+'.$result['m'].' month'));
	$result['j'] = date('m.d', strtotime($startDate.'+'.($result['m']+1).' month'));
	return array_filter($result);
}

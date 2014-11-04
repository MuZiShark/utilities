<?php

ini_set("error_reporting","E_ALL & ~E_NOTICE");

include_once 'days2.php';

$birthday = "2014-10-01";

show($birthday, 2014);
show($birthday, 2015);

die();

function format($startDate, $endDate) {
	// 检查两个日期大小，默认前小后大，如果前大后小则交换位置以保证前小后大
	if (strtotime($startDate) > strtotime($endDate)) {
		list($startDate, $endDate) = array($endDate, $startDate);
	}
	$start = strtotime($startDate);
	$end = strtotime($endDate);
	$extends = ($end-$start) / 86400;
	$res = array();
	$res['a'] = $extends;
	$res['w'] = ceil(($extends+1)/7);
	$res['y'] = 0;
	$res['m'] = 0;
	$res['d'] = 0;
	if (existNextMonthToday($startDate) === false) {
		$existNextMonthToday = 1;
		$gap = (strtotime(getNextMonthFirstDay($startDate))-strtotime($startDate)) / 86400;
	}
	while ($end >= strtotime('+1 year', $start)) {
		$getStartParams = getdate(strtotime($start));
		$end = strtotime('-1 year', $end);
		$res['y'] += 1;
	}
	while (strtotime($startDate) <= $end) {
		$startNext = existNextMonthToday($startDate);
		if ($startNext === false) { //如果生日那天存在下月的当天，则从下个月的第一天开始计算
			$startNext = getNextMonthFirstDay($startDate);
			if ($end > strtotime($startNext)) {
				$res['d'] += (strtotime($startNext)-strtotime($startDate)) / 86400;
			} else {
				$res['d'] += ($end-strtotime($startDate)) / 86400;
			}
			$res['i'] = date('Y-m-d', strtotime($startDate));
			$res['j'] = date('Y-m-d', strtotime(getNextMonthFirstDay($startNext)));
		} else { //如果生日那天存在下月的当天，则从下个月的当天继续进行计算
			$startNextParams = getdate(strtotime($startNext));
			$endParams = getdate($end);
			if ($startNextParams['year'] == $endParams['year'] && $startNextParams['mon'] == $endParams['mon']) {
				if ($startNextParams['mday'] > $endParams['mday']) {
					$res['d'] += ($end-strtotime($startDate)) / 86400;
				} else {
					$res['m'] += 1;
				}
			} elseif ($startNextParams['year'] == $endParams['year'] && $startNextParams['mon'] < $endParams['mon']) {
				$res['m'] += 1;
			} elseif ($startNextParams['year'] == $endParams['year'] && $startNextParams['mon'] > $endParams['mon']) {
				if ($existNextMonthToday == 1) {
					if ($res['m'] == 0) {
						$res['d'] += 0;
					} else {
						$res['d'] -= $gap;
					}
				}
				$startParams = getdate(strtotime($startDate));
				if ($startParams['mon'] == $endParams['mon']) {
					$res['d'] += $endParams['mday'] - $startParams['mday'];
				} else {
					$res['m'] += 1;
				}
			} elseif ($startNextParams['year'] > $endParams['year'] && $startNextParams['mon'] < $endParams['mon']) {
				$startParams = getdate(strtotime($startDate));
				$res['d'] += $endParams['mday'] - $startParams['mday'];
				if ($existNextMonthToday == 1) { //如果生日那天不存在下月的当天
					if ($res['m'] == 0) {
						$res['d'] += 0;
					} else {
						$res['d'] -= $gap;
					}
				}
			} elseif ($startNextParams['year'] > $endParams['year'] && $startNextParams['mon'] >= $endParams['mon']) {
				$res['m'] += 1;
			} elseif ($startNextParams['year'] < $endParams['year'] && $startNextParams['mon'] >= $endParams['mon']) {
				$res['m'] += 1;
			}
			$res['i'] = date('Y-m-d', strtotime($startDate));
			$res['j'] = date('Y-m-d', strtotime($startNext));
		}
		if ($res['m'] ==0) {
			if ($existNextMonthToday) {
				$res['i'] = date('Y-m-d', $start);
			}
		}
		$startDate = $startNext;
	}
	$res['a'] = (int)$res['a'];
	$res['w'] = (int)$res['w'];
	$res['y'] = (int)$res['y'];
	$res['m'] = (int)$res['m'];
	$res['d'] = (int)$res['d']+1;
	return $res;
}

/**
 * 判断是否是闰年
 * @param year
 */
function isLeapYear($year) { //年份YYYY
	return (($year%4==0 && $year%100!=0) || $year%400==0);
}

function existNextMonthToday($date) { //日期YYYY-mm-dd
	$dateParams = getdate(strtotime($date));
	$year = $dateParams['year'];
	$mon = $dateParams['mon'];
	$mday = $dateParams['mday'];
	switch ($mon) {
		case 1:
			if (isLeapYear($year)) {
				if ($mday > 29) {
					return false;
				}
				return $year.'-'.($mon+1).'-'.$mday;
			} else {
				if ($mday > 28) {
					return false;
				}
				return $year.'-'.($mon+1).'-'.$mday;
			}
		case 3:
		case 5:
		case 8:
		case 10:
			if ($mday > 30) {
				return false;
			}
			return $year.'-'.($mon+1).'-'.$mday;
		case 2:
		case 4:
		case 6:
		case 7:
		case 9:
		case 11:
			return $year.'-'.($mon+1).'-'.$mday;
		case 12:
			return ($year+1).'-1-'.$mday;
	}
}

function getNextMonthFirstDay($date) { //日期YYYY-mm-dd
	$dateParams = getdate(strtotime($date));
	$year = $dateParams['year'];
	$mon = $dateParams['mon'];
	$mday = $dateParams['mday'];
	if ($mon>=1 && $mon<=11) {
		return $year.'-'.($mon+1).'-1';
	}
	elseif ($mon == 12) {
		return ($year+1).'-1-1';
	}
}

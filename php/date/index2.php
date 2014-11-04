<?php

/**
 * 根据宝宝生日获取宝宝的年龄
 * @param  date   $bb_birthday 宝宝生日(格式:YYYY-mm-dd)
 * @return string $res         宝宝年龄
 */
function get_baby_age_by_birthday($bb_birthday) {
	$age = format($bb_birthday, date('Y-m-d'));
	if (isset($age['y'])) {
		$res = '已满一周岁';
	} else {
		if (isset($age['m'])) {
			$res = '的第'.$age['m'].'月'.$age['d'].'天';
		} else {
			$res = '的第'.$age['d'].'天';
		}
	}
	return $res;
}

/**
 * 根据宝宝生日获取宝宝的阶段
 * @param  date   $bb_birthday 宝宝生日(格式:YYYY-mm-dd)
 * @return string $res      宝宝阶段
 */
function get_baby_period_by_birthday($bb_birthday) {
	$age = format($bb_birthday, date('Y-m-d'));
	$res = $age[i].'~'.$age[j];
	return $res;
}

/**
 * 根据宝宝生日获取宝宝出生的天数
 * @param  date    $bb_birthday 宝宝生日(格式:YYYY-mm-dd)
 * @return integer $days        宝宝出生的天数(范围:>0)
 */
function get_baby_days_by_birthday($bb_birthday) {
	$age = format($bb_birthday, date('Y-m-d'));
	$days = $age['a'];
	return $days;
}

/**
 * 根据宝宝生日获取宝宝出生的周数（返回1周~52周，对应：育1周到育52周）
 * @param  date    $birthday 宝宝生日(格式:YYYY-mm-dd)
 * @return integer $week     宝宝出生周数(范围:1~52)
 */
function get_baby_week_by_birthday($bb_birthday) {
	$age = format($bb_birthday, date('Y-m-d'));
	$week = $age['w'];
	if($week >= 52) $week = 52;
	return $week; //一岁之内的宝宝，返回1周~52周；大于一岁的宝宝，返回52周
}

/**
 * 根据宝宝生日获取宝宝出生的月数（返回1月~12月，对应：育1周到育52周）
 * @param  date    $birthday 宝宝生日(格式:YYYY-mm-dd)
 * @return integer $month    宝宝出生月数(范围:1~12)
 */
function get_baby_month_by_birthday($bb_birthday) {
	$age = format($bb_birthday, date('Y-m-d'));
	$month = $age['m'];
	if ($age['y'] >= 1) $month = 11;
	return $month+1; //一岁之内的宝宝，返回1月~12月；大于一岁的宝宝，返回12月
}

/**
 * 两个日期间隔的天数、月数、年数
 * @param  date  $startDate 任意日期(格式:YYYY-mm-dd)
 * @param  date  $endDate   任意日期(格式:YYYY-mm-dd)
 * @return array $result    两个日期间隔的天数、周数、月数、年数
 */
function format($startDate, $endDate) {
	// 检查两个日期大小，默认前小后大，如果前大后小则交换位置以保证前小后大
	if (strtotime($startDate) > strtotime($endDate)) {
		list($startDate, $endDate) = array($endDate, $startDate);
	}
	// 起始时间的时间戳
	$start = strtotime($startDate);
	$end = strtotime($endDate);
	// 起始时间的时间差（同一天为0，但要在结果里显示1）
	$extend = ($end-$start)/86400;
	// 存储时间差y-m-d格式化后的数组（第一天在结果里显示1，每个月的第一天在结果里也要显示1）
	$result = array();
	$result['a'] = $extend+1;
	// 时间差y-m-d格式化
	if ($extend >= 0 && $extend<=31) { //一个月以内
		if ($end == strtotime($startDate.'+1 month')) {
			$result['y'] = 0;
			$result['m'] = 1;
			$result['d'] = 1;
		} else {
			$result['y'] = 0;
			$result['m'] = 0;
			$result['d'] = $extend+1;
		}
	} else { //一个月以上
		$y = floor($extend/365);
		if ($y >= 1) { //一年以上
			$start = strtotime($startDate.'+'.$y.'year');
			$startDate = date('Y-m-d', $start);
			if ($start > $end) {
				$startDate = date('Y-m-d', strtotime($startDate.'-1 month'));
				$m = 11;
				$y--;
			}
			$extend = ($end-strtotime($startDate))/86400;
		}
		if (isset($m)) { //一年以上，一个月以内
			$d = $extend;
		} else { //一年以上，一个月以上
			$m = isset($m) ? $m:round($extend/30);
			$end >= strtotime($startDate.'+'.$m.'month') ? $m:$m--;
			if ($end >= strtotime($startDate.'+'.$m.'month')) {
				$d = ($end-strtotime($startDate.'+'.$m.'month'))/86400;
			}
		}
		$result['y'] = (int)$y;
		$result['m'] = (int)$m;
		$result['d'] = isset($d) ? $d+1:1;
	}
	$result['w'] = ceil($result['a']/7);
	$result['i'] = date('m.d', strtotime($startDate.'+'.$result['m'].' month'));
	$result['j'] = date('m.d', strtotime($startDate.'+'.($result['m']+1).' month'));;
	return array_filter($result);
}

?>
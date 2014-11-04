<?php

header("content-type:text/html; charset=utf-8");

include_once 'days.php';

$birthday = "2012-01-31";
$year1 = 2011;
$year2 = 2012;
$year3 = 2013;
$year4 = 2014;
$year5 = 2015;
show($birthday, $year2);


die();

/**
 * 判断是否闰年
 * @param year
 */
function isLeapYear($year) { //年份YYYY
    return (($year%4==0 && $year%100!=0) || $year%400==0);
}

/**
 * 打印参数
 * @param $birthday
 */
function display($startDate, $endDate) {
    $str = '';
    $str .= get_baby_age_by_birthday($startDate, $endDate);
    $str .= '<font color="red">'.get_baby_period_by_birthday($startDate, $endDate).'</font>';
    $str .= get_baby_days_by_birthday($startDate, $endDate);
    $str .= '<font color="red">'.get_baby_week_by_birthday($startDate, $endDate).'</font>';
    $str .= get_baby_month_by_birthday($startDate, $endDate);
    echo $str;
}

/**
 * 根据宝宝生日获取宝宝的年龄
 * @param  date   $bb_birthday 宝宝生日(格式:YYYY-mm-dd)
 * @return string $res         宝宝年龄
 */
function get_baby_age_by_birthday($startDate, $endDate) {
	$age = format($startDate, $endDate);
    if(false === $age) {
        return;
    }
	if ($age['y'] >= 1) {
		$res = '已满一周岁';
	} else {
		if ($age['m'] >= 1) {
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
function get_baby_period_by_birthday($startDate, $endDate) {
	$age = format($startDate, $endDate);
    if(false === $age) {
        return;
    }
    $res = $age['i'].'~'.$age['j'];
	return $res;
}

/**
 * 根据宝宝生日获取宝宝出生的天数
 * @param  date    $bb_birthday 宝宝生日(格式:YYYY-mm-dd)
 * @return integer $days        宝宝出生的天数(范围:从1开始算)
 */
function get_baby_days_by_birthday($startDate, $endDate) {
	$age = format($startDate, $endDate);
    if(false === $age) {
        return;
    }
    $days = $age['a'];
	return $days;
}

/**
 * 根据宝宝生日获取宝宝出生的周数（返回1周~52周，对应：育1周到育52周）
 * @param  date    $birthday 宝宝生日(格式:YYYY-mm-dd)
 * @return integer $week     宝宝出生周数(范围:1~52)
 */
function get_baby_week_by_birthday($startDate, $endDate) {
	$age = format($startDate, $endDate);
    if(false === $age) {
        return;
    }
    $week = $age['w'];
	if ($week >= 52) {
		return 52; //满一周岁的宝宝，返回52
	} else {
		return $week; //不满一周岁的宝宝，返回1~52
	}
}

/**
 * 根据宝宝生日获取宝宝出生的月数（返回1月~12月，对应：育1周到育52周）
 * @param  date    $birthday 宝宝生日(格式:YYYY-mm-dd)
 * @return integer $month    宝宝出生月数(范围:1~12)
 */
function get_baby_month_by_birthday($startDate, $endDate) {
	$age = format($startDate, $endDate);
    if(false === $age) {
        return;
    }
    $year = $age['y'];
	$month = $age['m'];
	if ($year >= 1) {
		return 12; //满一岁的宝宝，返回12
	} else {
		return $month+1; //不满一岁的宝宝，返回1~12
	}
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
		return false;
	}
	// 计算
	$start = new DateTime($startDate);
	$end = new DateTime($endDate);
	$diff = $start->diff($end);
	$res['a'] = $diff->format('%a')+1;
	$res['w'] = ceil($res['a']/7);
	$res['y'] = $diff->format('%y');
	$res['m'] = $diff->format('%m');
	$res['d'] = $diff->format('%d');
	$res['i'] = date('m.d', strtotime('+ '.($res['y']).' year'.'+ '.($res['m']).' month', strtotime($startDate)));
	$res['j'] = date('m.d', strtotime('+ '.($res['y']).' year'.'+ '.($res['m']+1).' month', strtotime($startDate)));
	$res['a'] = (int)$res['a'];
	$res['w'] = (int)$res['w'];
	$res['y'] = (int)$res['y'];
	$res['m'] = (int)$res['m'];
	$res['d'] = (int)$res['d']+1;
    return $res;
    //return array_filter($res);
}

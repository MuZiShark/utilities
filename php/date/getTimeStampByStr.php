<?php

/**
 * @作者：li_rui@mama.cn 2014/09/22
 * 
 */

date_default_timezone_set('Asia/Shanghai');

$data = getTimeStampByStr('today');

var_dump($data);die();

/**
 * 函数名称：getTimestampByStr
 * 函数功能：根据时间关键字获取指定时间段的开始和结束时间戳
 * @param string $str 时间关键字
 * @return array $data 返回包含若干时间戳的数组
 */
function getTimeStampByStr($str) {
	// 排除参数为空的情况
	if(empty($str))  return false;
	// 定义一个空数组
	$data = array();
	// 判断
	switch($str) {
		case 'today':
			$data['begin_time'] = strtotime(date("Y").'-'.date("m").'-'.date("d"));
			$data['end_time'] = $data['begin_time']+24*60*60;
			$data['begin'] = date('Y-m-d H:i:s', $data['begin_time']);
			$data['end'] = date('Y-m-d H:i:s', $data['end_time']);
			break;
// 			'begin_time' => int 1411315200
// 			'end_time' => int 1411401600
// 			'begin' => string '2014-09-22 00:00:00' (length=19)
// 			'end' => string '2014-09-23 00:00:00' (length=19)
		case 'yesterday':
			$data['end_time'] = strtotime(date("Y").'-'.date("m").'-'.date("d"));
			$data['begin_time'] = $data['end_time']-24*60*60;
			$data['begin'] = date('Y-m-d H:i:s', $data['begin_time']);
			$data['end'] = date('Y-m-d H:i:s', $data['end_time']);
			break;
// 			'end_time' => int 1411315200
// 			'begin_time' => int 1411228800
// 			'begin' => string '2014-09-21 00:00:00' (length=19)
// 			'end' => string '2014-09-22 00:00:00' (length=19)
		case 'thisweek':
			// 判断当天是星期几，0表示星期天，1表示星期一，6表示星期六
			// echo $today = date('w'); // 取值范围：0（表示星期天）到 6（表示星期六）
			$data['begin_time'] = strtotime('+0 week Monday');
			$data['end_time'] = strtotime('+0 week Monday') + 7*24*60*60-1;
			$data['begin'] = date('Y-m-d H:i:s', $data['begin_time']);
			$data['end'] = date('Y-m-d H:i:s', $data['end_time']);
			break;
// 			'begin_time' => int 1411315200
// 			'end_time' => int 1411919999
// 			'begin' => string '2014-09-22 00:00:00' (length=19)
// 			'end' => string '2014-09-28 23:59:59' (length=19)
		case 'lastweek':
			// 判断当天是星期几，0表示星期天，1表示星期一，6表示星期六
			// echo $today = date('w'); // 取值范围：0（表示星期天）到 6（表示星期六）
			$data['begin_time'] = strtotime('-1 week Monday');
			$data['end_time'] = strtotime('-1 week Monday') + 7*24*60*60-1;
			$data['begin'] = date('Y-m-d H:i:s', $data['begin_time']);
			$data['end'] = date('Y-m-d H:i:s', $data['end_time']);
			break;
// 			'begin_time' => int 1410710400
// 			'end_time' => int 1411315199
// 			'begin' => string '2014-09-15 00:00:00' (length=19)
// 			'end' => string '2014-09-21 23:59:59' (length=19)
		case 'thismonth':
			$thismonth = getdate(strtotime('+0 month'));
			$nextmonth = getdate(strtotime('+1 month'));
			$data['begin_time'] = strtotime($thismonth['year'].'-'.$thismonth['mon'].'-01');
			$data['end_time'] = strtotime($nextmonth['year'].'-'.$nextmonth['mon'].'-01')-1;
			$data['begin'] = date('Y-m-d H:i:s', $data['begin_time']);
			$data['end'] = date('Y-m-d H:i:s', $data['end_time']);
			break;
// 			'begin_time' => int 1409500800
// 			'end_time' => int 1412092799
// 			'begin' => string '2014-09-01 00:00:00' (length=19)
// 			'end' => string '2014-09-30 23:59:59' (length=19)
		case 'lastmonth':
			$thismonth = getdate(strtotime('+0 month'));
			$lastmonth = getdate(strtotime('-1 month'));
			$data['begin_time'] = strtotime($lastmonth['year'].'-'.$lastmonth['mon'].'-01');
			$data['end_time'] = strtotime($thismonth['year'].'-'.$thismonth['mon'].'-01')-1;
			$data['begin'] = date('Y-m-d H:i:s', $data['begin_time']);
			$data['end'] = date('Y-m-d H:i:s', $data['end_time']);
			break;
// 			'begin_time' => int 1406822400
// 			'end_time' => int 1409500799
// 			'begin' => string '2014-08-01 00:00:00' (length=19)
// 			'end' => string '2014-08-31 23:59:59' (length=19)
	}
	return $data;
}

?>
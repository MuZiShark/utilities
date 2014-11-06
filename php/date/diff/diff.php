<?php

include_once 'days.php';

$birthday = "2012-01-01";

show($birthday, 2012);
show($birthday, 2013);
show($birthday, 2014);

die();

function format($startDate, $endDate) {
    // 检查两个日期大小，默认前小后大，如果前大后小则交换位置以保证前小后大
    if (strtotime($startDate) > strtotime($endDate)) {
        list($startDate, $endDate) = array($endDate, $startDate);
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
    $res['i'] = date('Y-m-d', strtotime('+ '.($res['y']).' year'.'+ '.($res['m']).' month', strtotime($startDate)));
    $res['j'] = date('Y-m-d', strtotime('+ '.($res['y']).' year'.'+ '.($res['m']+1).' month', strtotime($startDate)));
    $res['a'] = (int)$res['a'];
    $res['w'] = (int)$res['w'];
    $res['y'] = (int)$res['y'];
    $res['m'] = (int)$res['m'];
    $res['d'] = (int)$res['d']+1;
    return $res;
}
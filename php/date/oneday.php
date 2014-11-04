<?php

for($i=1; $i<=52; $i++) {
	echo ceil($i/4);
}

die();







date_default_timezone_set("Asia/Shanghai");

$today['start'] = date('Y-m-d H:i:s', strtotime(date('Y-m-d')));
$today['end'] = date('Y-m-d H:i:s', strtotime($today['start'])+24*60*60);

$today['now'] = date('Y-m-d H:i:s');


var_dump($today);die();

<?php

/**
 * 判断是否闰年
 * @param year
 */
function isLeapYear($year) { //年份YYYY
	return (($year%4==0 && $year%100!=0) || $year%400==0);
}

function show($birthday, $year) { //生日YYYY-mm-dd
	//计算二月的天数
	if(isLeapYear($year)) {
		$j = 29;
	} else {
		$j = 28;
	}

	$jan = $year."-01-";
	for($i=1; $i<=31; $i++) {
		$diff = format($birthday, $jan.$i);
		echo $jan.$i;
		var_dump($diff);
	}

	$feb = $year."-02-";
	for($i=1; $i<=$j; $i++) {
		$diff = format($birthday, $feb.$i);
		echo $feb.$i;
		var_dump($diff);
	}

	$mar = $year."-03-";
	for($i=1; $i<=31; $i++) {
		$diff = format($birthday, $mar.$i);
		echo $mar.$i;
		var_dump($diff);
	}

	$apr = $year."-04-";
	for($i=1; $i<=30; $i++) {
		$diff = format($birthday, $apr.$i);
		echo $apr.$i;
		var_dump($diff);
	}

	$may = $year."-05-";
	for($i=1; $i<=31; $i++) {
		$diff = format($birthday, $may.$i);
		echo $may.$i;
		var_dump($diff);
	}

	$jun = $year."-06-";
	for($i=1; $i<=30; $i++) {
		$diff = format($birthday, $jun.$i);
		echo $jun.$i;
		var_dump($diff);
	}

	$jul = $year."-07-";
	for($i=1; $i<=31; $i++) {
		$diff = format($birthday, $jul.$i);
		echo $jul.$i;
		var_dump($diff);
	}

	$aug = $year."-08-";
	for($i=1; $i<=31; $i++) {
		$diff = format($birthday, $aug.$i);
		echo $aug.$i;
		var_dump($diff);
	}

	$sep = $year."-09-";
	for($i=1; $i<=30; $i++) {
		$diff = format($birthday, $sep.$i);
		echo $sep.$i;
		var_dump($diff);
	}

	$oct = $year."-10-";
	for($i=1; $i<=31; $i++) {
		$diff = format($birthday, $oct.$i);
		echo $oct.$i;
		var_dump($diff);
	}

	$nov = $year."-11-";
	for($i=1; $i<=30; $i++) {
		$diff = format($birthday, $nov.$i);
		echo $nov.$i;
		var_dump($diff);
	}

	$dec = $year."-12-";
	for($i=1; $i<=31; $i++) {
		$diff = format($birthday, $dec.$i);
		echo $dec.$i;
		var_dump($diff);
	}
}
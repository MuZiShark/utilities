<?php

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
		echo $jan.$i;display($birthday, $jan.$i);
		var_dump($diff);
	}

	$feb = $year."-02-";
	for($i=1; $i<=$j; $i++) {
		$diff = format($birthday, $feb.$i);
		echo $feb.$i;display($birthday, $feb.$i);
		var_dump($diff);
	}

	$mar = $year."-03-";
	for($i=1; $i<=31; $i++) {
		$diff = format($birthday, $mar.$i);
		echo $mar.$i;display($birthday, $mar.$i);
		var_dump($diff);
	}

	$apr = $year."-04-";
	for($i=1; $i<=30; $i++) {
		$diff = format($birthday, $apr.$i);
		echo $apr.$i;display($birthday, $apr.$i);
		var_dump($diff);
	}

	$may = $year."-05-";
	for($i=1; $i<=31; $i++) {
		$diff = format($birthday, $may.$i);
		echo $may.$i;display($birthday, $may.$i);
		var_dump($diff);
	}

	$jun = $year."-06-";
	for($i=1; $i<=30; $i++) {
		$diff = format($birthday, $jun.$i);
		echo $jun.$i;display($birthday, $jun.$i);
		var_dump($diff);
	}

	$jul = $year."-07-";
	for($i=1; $i<=31; $i++) {
		$diff = format($birthday, $jul.$i);
		echo $jul.$i;display($birthday, $jul.$i);
		var_dump($diff);
	}

	$aug = $year."-08-";
	for($i=1; $i<=31; $i++) {
		$diff = format($birthday, $aug.$i);
		echo $aug.$i;display($birthday, $aug.$i);
		var_dump($diff);
	}

	$sep = $year."-09-";
	for($i=1; $i<=30; $i++) {
		$diff = format($birthday, $sep.$i);
		echo $sep.$i;display($birthday, $sep.$i);
		var_dump($diff);
	}

	$oct = $year."-10-";
	for($i=1; $i<=31; $i++) {
		$diff = format($birthday, $oct.$i);
		echo $oct.$i;display($birthday, $oct.$i);
		var_dump($diff);
	}

	$nov = $year."-11-";
	for($i=1; $i<=30; $i++) {
		$diff = format($birthday, $nov.$i);
		echo $nov.$i;display($birthday, $nov.$i);
		var_dump($diff);
	}

	$dec = $year."-12-";
	for($i=1; $i<=31; $i++) {
		$diff = format($birthday, $dec.$i);
		echo $dec.$i;display($birthday, $dec.$i);
		var_dump($diff);
	}
}

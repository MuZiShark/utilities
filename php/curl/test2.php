<?php

// create an array for the urls

$urlArr = array(
	"http://www.cnwust.com/Show/270",
	"http://www.cnwust.com/News/72916",
	"http://www.cnwust.com/News/73185",
);

// initial an array for the individual curl handles

$handleArr = array();

// set curl options

$options = array();
if(!$options) {
	$options = array(
		CURLOPT_HEADER=>0,
		CURLOPT_RETURNTRANSFER=>1,
	);
}

// add curl options to each handle

foreach ($urlArr as $k => $url) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt_array($ch, $options);
	$handleArr[$url] = $ch;
}

// init the multi curl

$mh = curl_multi_init();

foreach ($handleArr as $k => $handle) {
	curl_multi_add_handle($mh, $handle);
}

// execute the handles

$active = null;

do { // While we're still active, execute curl
	$mrc = curl_multi_exec($mh, $active);
} while ($mrc == CURLM_CALL_MULTI_PERFORM);

while ($active && $mrc == CURLM_OK) { // check for results and execute until everything is done
	if (curl_multi_select($mh) != -1)  usleep(100); // Wait for activity on any curl connection; if it returns -1, wait a bit, but go forward anyways!
	do { // Continue to exec until curl is ready to give us more data
		$mrc = curl_multi_exec($mh, $active);
	} while ($mrc == CURLM_CALL_MULTI_PERFORM);
}

// iterate through the handles and get your content

foreach ($handleArr as $k => $ch) {
	$res[$k] = curl_multi_getcontent($ch);
	curl_multi_remove_handle($mh, $ch);
	curl_close($ch);
}

curl_multi_close($mh);

var_dump($res);

?>
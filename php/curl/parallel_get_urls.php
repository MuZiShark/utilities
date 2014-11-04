<?php

$urls = array(
	"http://localhost/workspace/demos2/curl/z.php?echo=request1",
	"http://localhost/workspace/demos2/curl/z.php?echo=request2",
	"http://localhost/workspace/demos2/curl/z.php?echo=request3"
);

$options = array(
		CURLOPT_HEADER => 0,
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_TIMEOUT => 30,
);

$s = microtime(true);

$parallel = new parallel_get_urls($urls);

print "<br />total time: ".round(microtime(true) - $s, 4)." seconds";

/**
 * parallel_get_urls
 * 
 * 
 */

class parallel_get_urls {
	function __construct($urls) {
		$mh = curl_multi_init();
		$ch = array();
		foreach($urls as $k => $url) {
			$ch[$k] = curl_init($url);
			curl_setopt($ch[$k], CURLOPT_RETURNTRANSFER, 1);
			curl_multi_add_handle($mh, $ch[$k]);
		}
		$active = null;
		do {
			$mrc = curl_multi_exec($mh, $active);
		} while($mrc == CURLM_CALL_MULTI_PERFORM);
		while($active && $mrc == CURLM_OK) {
			if(version_compare(PHP_VERSION, '5.4.3', '<')) {
				if(curl_multi_select($mh) != -1) {
					// Pull in any new data, or at least handle timeouts
					do {
						$mrc = curl_multi_exec($mh, $active);
					} while ($mrc == CURLM_CALL_MULTI_PERFORM);
				}
			} else {
				if (curl_multi_select($mh) != -1)  usleep(100);
				// Pull in any new data, or at least handle timeouts
				do {
					$mrc = curl_multi_exec($mh, $active);
				} while ($mrc == CURLM_CALL_MULTI_PERFORM);
			}
		}
		if($mrc != CURLM_OK) {
			trigger_error("Curl multi read error $mrc\n", E_USER_WARNING);
		}
		foreach($urls as $k => $url)
		{
			// Check for errors
			$curlError = curl_error($ch[$k]);
			if($curlError == "") {
				$res[$k] = curl_multi_getcontent($ch[$k]);
			} else {
				print "Curl error on handle $k: $curlError\n";
			}
			curl_multi_remove_handle($mh, $ch[$k]);
			curl_close($ch);
		}
		curl_multi_close($mh);
		print_r($res);
	}
}

?>
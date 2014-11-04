<?php

/**
 * 正则匹配example1
 * 
 */

// $pattern = "/(^[a-zA-Z_.+-]+)@([a-zA-Z_-]+).([a-zA-Z]{2,4}$)/i";
// $subject = "jeff@nowhere.com";
// preg_match($pattern, $subject, $matches);
// var_dump($matches);

/**
 * 正则匹配example2
 *
 */

// $pattern = "/(^[a-zA-Z]+)\s+([0-9]{1,2}),\s*([0-9]{4}$)/";
// $subject = "February 23, 1988";
// $subject = "September 12, 2014";
// preg_match($pattern, $subject, $matches);
// var_dump($matches);

/**
 * 正则匹配example3
 *
 */

// $pattern = "/<img.+src=\"?(.+\.(bmp|gif|jpg|png))\"?.+>/i";
// $pattern = '/<img.+src="?(.+\.(bmp|gif|jpg|png))"?.*>/i';
// $subject = " <img width=\"320\" height=\"240\" src=\"http:\/\/images.ad.bjmama.net\/s\/1409\/090015nfjxf6tebsbrwle0.jpg\" border=\"0\"> ";
// $subject = ' <img width="320" height="240" src="http://images.ad.bjmama.net/s/1409/090015nfjxf6tebsbrwle0.jpg" border="0"> ';
// preg_match($pattern, $subject, $matches);
// var_dump($matches);

?>
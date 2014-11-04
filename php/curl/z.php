<?php

/**
 * This script runs a variable amount of time and generates a variable amount of data
 * 
 */

// Output a random amount of blank space
$s = microtime(true);
$m = rand(5000, 10000);
for($i = 0; $i < $m; $i++) {
  print "         \n";
  usleep(10);
}

// Print time taken and the value of the "echo" parameter
print isset($_REQUEST["echo"]) ? $_REQUEST["echo"] : "";
print " in ";
print round(microtime(true) - $s, 4)." seconds";
exit();
?>
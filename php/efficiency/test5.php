<?php

// longest
if ($a == $b) {
$str .= $a;
} else {
$str .= $b;
}

// longer
if ($a == $b) {
$str .= $a;
}

$str .= $b;
// short
$str .= ($a == $b ? $a : $b);

?>
<?php

$m = new Memcache();

$m->connect('127.0.0.1', 11211);

$m->set('memcache', 'Hello, Memcache!');

echo $m->get('memcache');

?>
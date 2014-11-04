<?php

$m = new Memcached();

$m->addserver('127.0.0.1', 11211);

$m->set('memcached', 'Hello, Memcached!');

echo $m->get('memcached');

?>
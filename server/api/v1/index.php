<?php

require __DIR__ . '/../source/Jacwright/RestServer/RestServer.php';
require 'pp.php';

$server = new \Jacwright\RestServer\RestServer('debug');
$server->addClass('pp');
$server->handle();

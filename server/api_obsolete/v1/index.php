<?php

require __DIR__ . '/../source/Jacwright/RestServer/RestServer.php';


require __DIR__ . '/../source/Brush/Brush.php';

	use \Brush\Pastes\Draft;
	use \Brush\Accounts\Developer;
	use \Brush\Exceptions\BrushException;

require 'pp.php';

$server = new \Jacwright\RestServer\RestServer('debug');
$server->addClass('pp');
$server->handle();
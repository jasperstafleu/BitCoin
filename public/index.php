<?php
chdir('..');
require_once 'config/config.php';

\Stafleu\Events\Dispatcher::trigger(
		array_filter(explode('/', $_GET['uri']))
	, $_REQUEST
);

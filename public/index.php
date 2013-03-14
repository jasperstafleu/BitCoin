<?php
chdir('..');
require_once 'config/config.php';

\Events\Dispatcher::trigger(array_filter(explode('/', $_REQUEST['uri'])), $_REQUEST);

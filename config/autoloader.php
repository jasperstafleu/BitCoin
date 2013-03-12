<?php
function autoloader($class) {
	$cwd = getcwd();
	chdir(BASEDIR);
	$filename = implode(DIRECTORY_SEPARATOR, explode('\\', $class)) . '.php';

	require_once($filename);
	chdir($cwd);

	return class_exists($class);
} // autoloader();

spl_autoload_register('autoloader');

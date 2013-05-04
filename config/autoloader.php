<?php
function autoloader($class)
{
    $cwd = getcwd();
    chdir(BASEDIR);

    $namespaces = explode('\\', $class);
    $classname = explode('_', array_pop($namespaces));

    $psr0Path = array_merge($namespaces, $classname);

    $filename = implode(DIRECTORY_SEPARATOR, $psr0Path) . '.php';

    require_once($filename);
    chdir($cwd);

    return class_exists($class);
} // autoloader();

spl_autoload_register('autoloader');

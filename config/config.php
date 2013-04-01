<?php
define('BASEDIR', getcwd() . DIRECTORY_SEPARATOR);
define('CLASS_BITCOINRATESERVICE', 'MtGoxService');

session_set_cookie_params(30*60, '/', '', false, true);
ini_set('session.cookie_httponly', 'On');

require BASEDIR . 'config/autoloader.php';
session_start();

<?php
define('BASEDIR', getcwd() . DIRECTORY_SEPARATOR);
define('CLASS_BITCOINRATESERVICE', 'MtGoxService');

session_set_cookie_params(30*60, '/', '', true);
session_start();

require BASEDIR . 'config/autoloader.php';
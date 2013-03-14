<?php
define('BASEDIR', getcwd() . DIRECTORY_SEPARATOR);
define('CLASS_BITCOINTICKERSERVICE', 'MtGoxService');

session_set_cookie_params(30*60, '/', '', true);
session_start();

require BASEDIR . 'config/autoloader.php';
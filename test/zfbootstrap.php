<?php
set_include_path(get_include_path() . ':' . PATH_TO_ZEND_FRAMEWORK);
// Set autoloader to autoload libraries
require_once 'Zend/Loader/Autoloader.php';
$autoloader = Zend_Loader_Autoloader::getInstance();

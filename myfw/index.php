<?php
// Define base url
define('BASE_URL', 'http://development.local/projects/myfw/');

// Define base path
define('BASE_PATH', realpath(dirname(__FILE__)));

// Define path to application directory
define('APPLICATION_PATH', BASE_PATH . '/app');

// Define path to library directory
define('LIBRARY_PATH', BASE_PATH . '/library');

// Define application environment
define('APPLICATION_ENV', 'development');


/** Zend_Application */
require_once BASE_PATH . '/library/Core/Application.php';

// Create application, bootstrap, and run
$application = new Core_Application(
    APPLICATION_ENV,
    include_once APPLICATION_PATH . '/config/app.php'
);

$application->run();
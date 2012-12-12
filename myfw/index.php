<?php
// Define base url
define('BASE_URL', 'http://site.local/development/myfw');

// Define base path
define('BASE_PATH', str_replace('\\', '/', realpath(dirname(__FILE__))));

// Define path to application directory
define('APPLICATION_PATH', BASE_PATH . '/app');

// Define path to library directory
define('LIBRARY_PATH', BASE_PATH . '/library');

// Define application environment
define('APPLICATION_ENV', 'development');

set_include_path(LIBRARY_PATH);

/** Core_Application */
require_once BASE_PATH . '/library/Core/Application.php';

// Create application, and run
$application = new Core_Application(
    APPLICATION_ENV,
    include_once APPLICATION_PATH . '/config/app.php'
);

$application->run();
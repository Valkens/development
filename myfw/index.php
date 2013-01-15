<?php
// Define base url
define('BASE_URL', 'http://github.local/development/myfw');

// Admin url suffix
define('ADMIN_URL_SUFFIX', 'admin');

// Define base path
define('BASE_PATH', str_replace('\\', '/', realpath(dirname(__FILE__))));

// Define path to application directory
define('APPLICATION_PATH', BASE_PATH . '/app');

// Define path to cache directory
define('CACHE_PATH', APPLICATION_PATH . '/cache');

// Define path to library directory
define('LIBRARY_PATH', BASE_PATH . '/library');

// Define application environment
define('APPLICATION_ENV', 'development');

// Core_Application
require_once BASE_PATH . '/library/Core/Application.php';

set_include_path(get_include_path() . PATH_SEPARATOR . LIBRARY_PATH);

// Create application, and run
$application = new Core_Application(
    APPLICATION_ENV,
    include_once APPLICATION_PATH . '/config/app.php'
);

$application->run();
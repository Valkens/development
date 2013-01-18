<?php
// Define base url
define('BASE_URL', 'http://web.local/github/development/myfw');

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
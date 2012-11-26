<?php
// DB
define('DB_DRIVER', 'mysql');
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('DB_DATABASE', 'opencart');
define('DB_PREFIX', '');

// HTTP
define('HTTP_IMAGE', 'http://site.local/development/opencart/image/');

// HTTPS
define('HTTPS_IMAGE', 'http://site.local/development/opencart/image/');

// DIR
define('DIR_ROOT', dirname(dirname(__FILE__)));
define('DIR_SYSTEM', DIR_ROOT  . '/system/');
define('DIR_DATABASE', DIR_ROOT  . '/system/database/');
define('DIR_CONFIG', DIR_ROOT  . '/system/config/');
define('DIR_IMAGE', DIR_ROOT  . '/image/');
define('DIR_CACHE', DIR_ROOT  . '/system/cache/');
define('DIR_DOWNLOAD', DIR_ROOT  . '/download/');
define('DIR_LOGS', DIR_ROOT  . '/system/logs/');

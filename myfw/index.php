<?php
require_once 'constant.php';

// Core_Application
require_once BASE_PATH . '/library/Core/Application.php';

set_include_path(get_include_path() . PATH_SEPARATOR . LIBRARY_PATH);

// Create application, and run
$application = new Core_Application(
    APPLICATION_ENV,
    include_once APPLICATION_PATH . '/config/app.php'
);

$application->run();
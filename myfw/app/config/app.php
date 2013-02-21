<?php
return array(
    'resources' => array(
        'db' => array(
            'mysql' => array(
                'host' => 'localhost',
                'username' => 'root',
                'password' => 'root',
                'dbname' => 'dev_blog',
                'prefix' => 'dev_'
            ),
            'sqlite' => array(
                'dbfile' => APPLICATION_PATH . '/db/db',
                'prefix' => 'dev_'
            )
        ),
        'view' => array(
            'minify' => 1, // Only effect for combine
            'combineCss' => 1,
            'combineJs' => 1,
            'theme' => 'default'
        )
    ),
    'phpSettings' => array(
        'production' => array(
            'date.timezone' => 'Asia/Ho_Chi_Minh',
            'display_startup_errors' => 0,
            'display_errors' => 0,
            'error_reporting' => 0,
            'error_log' => APPLICATION_PATH . '/log/error'
        ),
        'development' => array(
            'date.timezone' => 'Asia/Ho_Chi_Minh',
            'display_startup_errors' => 1,
            'display_errors' => 1,
            'error_reporting' => E_ALL,
            'error_log' => APPLICATION_PATH . '/log/error'
        )
    ),
    'modules' => array(
		'Base',
        'Default',
        'Category',
        'Post',
        'User',
        'Tag',
        'System'
    ),
    'libraries' => array(
        'Core',
        'Zend',
        'Min'
    )
);
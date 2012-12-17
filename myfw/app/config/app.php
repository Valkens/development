<?php
return array(
    'resources' => array(
        'db' => array(
            'mysql' => array(
                'host' => 'localhost',
                'username' => 'root',
                'password' => 'root',
                'dbname' => 'phong',
                'persistent' => false,
                'collate' => 'utf8_unicode_ci',
                'charset'=>'utf8'
            ),
            'sqlite' => array(
                'dbname' => APPLICATION_PATH . '/db/db'
            )
        ),
        'view' => array(
            'options' => array(
                'minify' => 0,
                'combineJs' => 0,
                'combineCss' => 0
            ),
            'layoutParams' => array(
                'dir' => APPLICATION_PATH . '/module/Default/View/Layout'
            )
        )
    ),
    'phpSettings' => array(
        'production' => array(
            'display_startup_errors' => 0,
            'display_errors' => 0,
            'error_reporting' => 0
        ),
        'development' => array(
            'display_startup_errors' => 1,
            'display_errors' => 1,
            'error_reporting' => E_ALL
        )
    ),
    'modules' => array(
        'Default'
    ),
    'libraries' => array(
        'Core',
        'Zend',
        'Twig'
    )
);
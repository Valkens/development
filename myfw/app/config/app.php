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
                'options' => array(
                    'collate' => 'utf8_unicode_ci',
                    'charset'=>'utf8'
                )
            ),
            'sqlite' => array(
                'dbname' => APPLICATION_PATH . '/db/db'
            )
        ),
        'view' => array(
            'Twig' => array(
                'options' => array(
                    'cache' => APPLICATION_PATH . '/cache/Twig',
                    'auto_reload' => true
                ),
                'layoutParams' => array(
                    'dir' => APPLICATION_PATH . '/module/Default/View/Layout'
                )
            )
        )
    ),
    'phpSettings' => array(
        'production' => array(
            'display_startup_errors' => 0,
            'display_errors' => 0
        ),
        'development' => array(
            'display_startup_errors' => 1,
            'display_errors' => 1
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
<?php
return array(
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
        'Zend'
    )
);
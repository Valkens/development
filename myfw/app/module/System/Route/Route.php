<?php
return array(
    array(
        'name' => 'route_admin_system_cache',
        'method' => 'GET|POST',
        'route'  => '/' . ADMIN_URL_SUFFIX . '/system/cache',
        'target' => array('module' => 'System', 'controller' => 'Admin', 'action' => 'clearCache')
    ),
    array(
        'name' => 'route_admin_system_log',
        'method' => 'GET|POST',
        'route'  => '/' . ADMIN_URL_SUFFIX . '/system/log',
        'target' => array('module' => 'System', 'controller' => 'Admin', 'action' => 'viewLog')
    ),
    array(
        'name' => 'route_admin_system_setting',
        'method' => 'GET|POST',
        'route'  => '/' . ADMIN_URL_SUFFIX . '/system/setting',
        'target' => array('module' => 'System', 'controller' => 'Admin', 'action' => 'setting')
    )
);
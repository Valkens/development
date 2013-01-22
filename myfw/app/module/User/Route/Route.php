<?php
return array(
    array(
        'name' => 'route_admin',
        'method' => 'GET|POST',
        'route'  => '/' . ADMIN_URL_SUFFIX,
        'target' => array('module' => 'User', 'controller' => 'Admin', 'action' => 'index')
    ),
    array(
        'name' => 'route_admin_login',
        'method' => 'POST',
        'route'  => '/' . ADMIN_URL_SUFFIX . '/login',
        'target' => array('module' => 'User', 'controller' => 'Admin', 'action' => 'login')
    ),
    array(
        'name' => 'route_admin_logout',
        'method' => 'GET',
        'route'  => '/' . ADMIN_URL_SUFFIX . '/logout',
        'target' => array('module' => 'User', 'controller' => 'Admin', 'action' => 'logout')
    )
);
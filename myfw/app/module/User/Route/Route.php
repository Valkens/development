<?php
return array(
    array(
        'name' => 'route_admin',
        'method' => 'GET',
        'route'  => '/' . ADMIN_URL_SUFFIX,
        'target' => array('module' => 'User', 'controller' => 'Admin', 'action' => 'index')
    ),
    array(
        'name' => 'route_user_auth',
        'method' => 'POST',
        'route'  => '/' . ADMIN_URL_SUFFIX . '/auth',
        'target' => array('module' => 'User', 'controller' => 'Auth', 'action' => 'auth')
    ),
    array(
        'name' => 'route_user_logout',
        'method' => 'GET',
        'route'  => '/' . ADMIN_URL_SUFFIX . '/logout',
        'target' => array('module' => 'User', 'controller' => 'Auth', 'action' => 'logout')
    )
);
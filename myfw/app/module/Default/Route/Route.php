<?php
return array(
    array(
        'name' => 'route_home',
        'method' => 'GET',
        'route'  => '/',
        'target' => array('module' => 'Default', 'controller' => 'Index', 'action' => 'Index')
    ),
    array(
        'name' => 'route_user',
        'method' => 'GET',
        'route'  => '/user/[i:id][/]?',
        'target' => array('module' => 'Default', 'controller' => 'Index', 'action' => 'Index')
    ),
    array(
        'name' => 'route_error_404',
        'method' => 'GET',
        'route'  => '/error/404',
        'target' => array('module' => 'Default', 'controller' => 'Error', 'action' => 'error404')
    )
);
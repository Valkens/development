<?php
return array(
    array(
        'name' => 'route_home',
        'method' => 'GET',
        'route'  => '/',
        'target' => array('module' => 'Default', 'controller' => 'Index', 'action' => 'index')
    ),
    array(
        'name' => 'route_get_site',
        'method' => 'GET',
        'route'  => '/getsite/[:url](/)?',
        'target' => array('module' => 'Default', 'controller' => 'Index', 'action' => 'getsite'),
    ),
    array(
        'name' => 'route_error_404',
        'method' => 'GET',
        'route'  => '/error/404',
        'target' => array('module' => 'Default', 'controller' => 'Error', 'action' => 'error404')
    )
);
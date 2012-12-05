<?php
return array(
    array(
        'name' => 'route_home',
        'method' => 'GET',
        'route'  => '/',
        'target' => array('module' => 'Default', 'controller' => 'Index', 'action' => 'Index')
    ),
    array(
        'name' => 'route_user_list',
        'method' => 'GET',
        'route'  => '/user[/]?',
        'target' => array('module' => 'User', 'controller' => 'Index', 'action' => 'Index')
    )
);
<?php
return array(
    array(
        'name' => 'route_admin_ckfinder_popup',
        'method' => 'GET',
        'route'  => '/' . ADMIN_URL_SUFFIX . '/ckfinder/popup',
        'target' => array('module' => 'Base', 'controller' => 'Ckfinder', 'action' => 'popup')
    ),
    array(
        'name' => 'route_admin_ckfinder_connect',
        'method' => 'GET|POST',
        'route'  => '/' . ADMIN_URL_SUFFIX . '/ckfinder/connect',
        'target' => array('module' => 'Base', 'controller' => 'Ckfinder', 'action' => 'connect')
    )
);
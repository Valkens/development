<?php
return array(
    array(
        'name' => 'route_admin_ckfinder_connect',
        'method' => 'GET|POST',
        'route'  => '/' . ADMIN_URL_SUFFIX . '/ckfinder/connect',
        'target' => array('module' => 'Base', 'controller' => 'Ckfinder', 'action' => 'connect')
    )
);
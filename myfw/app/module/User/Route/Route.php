<?php
return array(
    array(
        'name' => 'route_admin_user_login',
        'method' => 'GET|POST',
        'route'  => '/' . ADMIN_URL_SUFFIX . '/login',
        'target' => array('module' => 'User', 'controller' => 'Admin', 'action' => 'login')
    )
);
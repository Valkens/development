<?php
return array(
    array(
        'name' => 'route_admin_post',
        'method' => 'GET',
        'route'  => '/' . ADMIN_URL_SUFFIX . '/post',
        'target' => array('module' => 'Post', 'controller' => 'Admin', 'action' => 'index')
    ),
    array(
        'name' => 'route_admin_post_pagination',
        'method' => 'GET',
        'route'  => '/' . ADMIN_URL_SUFFIX . '/post/page/[i:page]',
        'target' => array('module' => 'Post', 'controller' => 'Admin', 'action' => 'index')
    ),
    array(
        'name' => 'route_admin_post_add',
        'method' => 'GET|POST',
        'route'  => '/' . ADMIN_URL_SUFFIX . '/post/add',
        'target' => array('module' => 'Post', 'controller' => 'Admin', 'action' => 'add')
    ),
    array(
        'name' => 'route_admin_post_edit',
        'method' => 'GET|POST',
        'route'  => '/' . ADMIN_URL_SUFFIX . '/post/edit/[i:id]',
        'target' => array('module' => 'Post', 'controller' => 'Admin', 'action' => 'edit'),
    ),
);
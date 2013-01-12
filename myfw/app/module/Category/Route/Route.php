<?php
return array(
    array(
        'name' => 'route_admin_category',
        'method' => 'GET',
        'route'  => '/' . ADMIN_URL_SUFFIX . '/category',
        'target' => array('module' => 'Category', 'controller' => 'Admin', 'action' => 'index')
    ),
    array(
        'name' => 'route_admin_category_add',
        'method' => 'GET|POST',
        'route'  => '/' . ADMIN_URL_SUFFIX . '/category/add',
        'target' => array('module' => 'Category', 'controller' => 'Admin', 'action' => 'add')
    ),
    array(
        'name' => 'route_admin_category_edit',
        'method' => 'GET|POST',
        'route'  => '/' . ADMIN_URL_SUFFIX . '/category/edit/[i:id]',
        'target' => array('module' => 'Category', 'controller' => 'Admin', 'action' => 'edit'),
    ),
);
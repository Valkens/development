<?php
return array(
    array(
        'name' => 'route_admin_tag_suggest',
        'method' => 'GET',
        'route'  => '/' . ADMIN_URL_SUFFIX . '/tag/suggest',
        'target' => array('module' => 'Tag', 'controller' => 'Admin', 'action' => 'suggest')
    )
);
<?php return array (
    'package' =>
        array (
        'type' => 'module',
        'name' => 'book',
        'version' => '1.0.0',
        'path' => 'application/modules/Book',
        'title' => 'Books',
        'description' => 'Book store management',
        'author' => 'duclh',
        'callback' =>
        array (
          'class' => 'Engine_Package_Installer_Module',
        ),
        'actions' =>
        array (
          0 => 'install',
          1 => 'upgrade',
          2 => 'refresh',
          3 => 'enable',
          4 => 'disable',
        ),
        'callback' => array(
            'path' => 'application/modules/Book/settings/install.php',
            'class' => 'Book_Installer',
        ),
        'directories' =>
        array (
          0 => 'application/modules/Book',
        ),
        'files' =>
        array (
          0 => 'application/languages/en/book.csv',
        ),
    ),
    // Hooks ---------------------------------------------------------------------
    'hooks' => array(
        array(
            'event' => 'onUserDeleteBefore',
            'resource' => 'Book_Plugin_Core',
        ),
    ),
    // Items ---------------------------------------------------------------------
    'items' => array(
        'book',
        'book_param'
    ),
    // Routes --------------------------------------------------------------------
    'routes' => array(
        'book_general' => array(
            'route' => 'book/:action',
            'defaults' => array(
                'module' => 'book',
                'controller' => 'index',
                'action' => 'index',
            ),
            'reqs' => array(
                'action' => '(index|manage|add|cart|checkout|transaction)',
            ),
        ),
        // Public
        'book_specific' => array(
            'route' => 'book/:action/:book_id',
            'defaults' => array(
                'module' => 'book',
                'controller' => 'index',
                'action' => 'index',
            ),
            'reqs' => array(
                'book_id' => '\d+',
                'action' => '(delete|edit|view)',
            ),
        ),
        // Public
        'book_pagination' => array(
            'route' => 'book/:action/page/:page',
            'defaults' => array(
                'module' => 'book',
                'controller' => 'index',
                'action' => 'index',
            ),
            'reqs' => array(
                'action' => '(index|manage)',
                'page' => '\d+',
            ),
        ),
        // Public
        'book_payment' => array(
            'route' => 'book/payment/:action',
            'defaults' => array(
                'module' => 'book',
                'controller' => 'payment',
                'action' => 'index',
            ),
            'reqs' => array(
                'action' => '(index|success|notify)'
            ),
        ),
        // Public
        'book_transaction' => array(
            'route' => 'book/transaction/:id',
            'defaults' => array(
                'module' => 'book',
                'controller' => 'index',
                'action' => 'transaction',
            ),
            'reqs' => array(
                'id' => '\d+',
            ),
        ),
    ),

); ?>
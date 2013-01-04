<?php

/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Blog
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.net/license/
 * @version    $Id: manifest.php 7371 2010-09-14 03:33:35Z john $
 * @author     John
 */
return array(
    // Package -------------------------------------------------------------------
    'package' => array(
        'title' => 'Advanced Blog',
        'author' => 'YouNet Company',
        'type' => 'module',
        'name' => 'blog',
        'version' => '4.05p2',
        'path' => 'application/modules/Blog',
        'repository' => 'se4demo.modules2buy.com',
        'meta' => array(
            'title' => 'Advanced Blogs',
            'description' => 'Advanced Blogs',
            'author' => 'YouNet Company',
        ),
        'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.1.2',
            ),
        ),
        'actions' => array(
            'install',
            'upgrade',
            'refresh',
            'enable',
            'disable',
        ),
        'callback' => array(
            'path' => 'application/modules/Blog/settings/install.php',
            'class' => 'Blog_Installer',
        ),
        'directories' => array(
            'application/modules/Blog',
        ),
        'files' => array(
            'application/languages/en/blog.csv',
        ),
    ),
    // Hooks ---------------------------------------------------------------------
    'hooks' => array(
        array(
            'event' => 'onStatistics',
            'resource' => 'Blog_Plugin_Core'
        ),
        array(
            'event' => 'onUserDeleteBefore',
            'resource' => 'Blog_Plugin_Core',
        ),
    ),
    // Items ---------------------------------------------------------------------
    'items' => array(
        'blog',
        'blog_param',
        'blog_feature'
    ),
    // Routes --------------------------------------------------------------------
    'routes' => array(
        // redierect to blog_rdit
        'blog_edit' => array(
            'route' => 'blogs/:action/:blog_id/*',
            'defaults' => array(
                'module' => 'blog',
                'controller' => 'index',
                'action' => 'edit',
            ),
            'reqs' => array(
                'blog_id' => '\d+',
                'action' => '(delete|edit)',
            ),
        ),
        // Public
        'blog_specific' => array(
            'route' => 'blogs/:action/:blog_id/*',
            'defaults' => array(
                'module' => 'blog',
                'controller' => 'index',
                'action' => 'index',
            ),
            'reqs' => array(
                'blog_id' => '\d+',
                'action' => '(delete|edit)',
            ),
        ),
        'blog_general' => array(
            'route' => 'blogs/:action/*',
            'defaults' => array(
                'module' => 'blog',
                'controller' => 'index',
                'action' => 'index',
            ),
            'reqs' => array(
                'action' => '(featured-ajax|featured-old-ajax|listing|index|create|manage|style|tag|become|rss)',
            ),
        ),
        'blog_view' => array(
            'route' => 'blogs/:user_id/*',
            'defaults' => array(
                'module' => 'blog',
                'controller' => 'index',
                'action' => 'list',
            ),
            'reqs' => array(
                'user_id' => '\d+',
            ),
        ),
        'blog_entry_view' => array(
            'route' => 'blogs/:user_id/:blog_id/:slug',
            'defaults' => array(
                'module' => 'blog',
                'controller' => 'index',
                'action' => 'view',
                'slug' => '',
            ),
            'reqs' => array(
                'user_id' => '\d+',
                'blog_id' => '\d+'
            ),
        ),
    ),
);

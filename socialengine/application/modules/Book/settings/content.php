<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Book
 * @copyright  Copyright 2012 Younet Developments
 * @license    http://www.socialengine.net/license/
 * @version    $Id: Content.php SE-1488 duclh $
 * @author     duclh
 */

return array(
    array(
        'title' => 'Menu Books',
        'description' => 'Displays menu books on browse books page.',
        'category' => 'Books',
        'type' => 'widget',
        'name' => 'book.menu-books',
    ),
    array(
        'title' => 'Recent Added Books',
        'description' => 'Displays recent added books.',
        'category' => 'Books',
        'type' => 'widget',
        'name' => 'book.recent-added-books',
        'defaultParams' => array(
            'title' => 'Recent Added Books',
        ),
        'adminForm' => array(
            'elements' => array(
                array(
                    'Text',
                    'title',
                    array(
                        'label' => 'Title',
                    )
                ),
                array(
                    'Text',
                    'max',
                    array(
                        'label' => 'Number of Books show on page.',
                        'value' => 8,
                    )
                ),
            )
        ),
    ),
    array(
        'title' => 'All Books',
        'description' => 'Displays all books.',
        'category' => 'Books',
        'type' => 'widget',
        'name' => 'book.all-books',
        'defaultParams' => array(
            'title' => 'All books',
            'titleCount' => true,
        ),
    ),
    array(
        'title' => 'Most viewed books',
        'description' => 'Displays most viewed books.',
        'category' => 'Books',
        'type' => 'widget',
        'name' => 'book.most-viewed-books',
        'defaultParams' => array(
            'title' => 'Most viewed books',
        ),
        'adminForm' => array(
            'elements' => array(
                array(
                    'Text',
                    'title',
                    array(
                        'label' => 'Title',
                    )
                ),
                array(
                    'Text',
                    'max',
                    array(
                        'label' => 'Number of Books show on page.',
                        'value' => 8,
                    )
                ),
            )
        ),
    ),
    array(
        'title' => 'Book detail',
        'description' => 'Displays book detail.',
        'category' => 'Books',
        'type' => 'widget',
        'name' => 'book.detail-books',
        'defaultParams' => array(
            'title' => 'Book detail',
            'titleCount' => true,
        ),
    ),
    array(
        'title' => 'Best sell books',
        'description' => 'Displays best sell books.',
        'category' => 'Books',
        'type' => 'widget',
        'name' => 'book.best-sell-books',
        'defaultParams' => array(
            'title' => 'Best sell books',
        ),
        'adminForm' => array(
            'elements' => array(
                array(
                    'Text',
                    'title',
                    array(
                        'label' => 'Title',
                    )
                ),
                array(
                    'Text',
                    'max',
                    array(
                        'label' => 'Number of Books show on page.',
                        'value' => 8,
                    )
                ),
            )
        ),
    ),
) ?>
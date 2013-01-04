<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Blog
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.net/license/
 * @version    $Id: content.php 7244 2010-09-01 01:49:53Z john $
 * @author     John
 */
return array(
  array(
    'title' => 'Profile Blogs',
    'description' => 'Displays a member\'s blog entries on their profile.',
    'category' => 'Blogs',
    'type' => 'widget',
    'name' => 'blog.profile-blogs',
    'defaultParams' => array(
      'title' => 'Blogs',
      'titleCount' => true,
    ),
  ),
  array(
    'title' => 'Recent Blog Entries',
    'description' => 'Displays a list of recently posted blog entries.',
    'category' => 'Blogs',
    'type' => 'widget',
    'name' => 'blog.list-recent-blogs',
    'defaultParams' => array(
      'title' => 'Recent Blog Entries',
    ),
  ),
  array(
    'title' => 'Popular Blog Entries',
    'description' => 'Displays a list of most viewed blog entries.',
    'category' => 'Blogs',
    'type' => 'widget',
    'name' => 'blog.list-popular-blogs',
    'defaultParams' => array(
      'title' => 'Popular Blog Entries',
    ),
  ),
  
   array(
    'title' => 'Menu Blogs',
    'description' => 'Displays menu blogs on browse blogs page.',
    'category' => 'Blogs',
    'type' => 'widget',
    'name' => 'blog.menu-blogs',
  ),
    array(
    'title' => 'Top Blogs',
    'description' => 'Displays top blogs on browse blogs page.',
    'category' => 'Blogs',
    'type' => 'widget',
    'name' => 'blog.top-blogs',
    'defaultParams' => array(
      'title' => 'Top Blogs',
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
            'label' => 'Number of Blogs show on page.',
            'value' => 8,
            
          )
        ),
      )
    ),
  ),
   array(
    'title' => 'New Blogs',
    'description' => 'Displays new blogs on browse blogs page.',
    'category' => 'Blogs',
    'type' => 'widget',
    'name' => 'blog.new-blogs',
    'defaultParams' => array(
      'title' => 'New Blogs',
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
             'label' => 'Number of Blogs show on page.',
            'value' => 8,
            
          )
        ),
      )
    ),
  ),
   array(
    'title' => 'Most Viewed Blogs',
    'description' => 'Displays most viewed blogs on browse blogs page.',
    'category' => 'Blogs',
    'type' => 'widget',
    'name' => 'blog.most-view-blogs',
    'defaultParams' => array(
      'title' => 'Most Viewed Blogs',
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
            'label' => 'Number of Blogs show on page.',
            'value' => 4,
            
          )
        ),
      )
    ),
  ),
   array(
    'title' => 'Most Commented Blogs',
    'description' => 'Displays most commented blogs on browse blogs page.',
    'category' => 'Blogs',
    'type' => 'widget',
    'name' => 'blog.most-comment-blogs',
    'defaultParams' => array(
      'title' => 'Most Commented Blogs',
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
             'label' => 'Number of Blogs show on page.',
            'value' => 4,
            
          )
        ),
      )
    ),
  ),
  array(
    'title' => 'Featured Blogs',
    'description' => 'Displays featured blogs on browse blogs page.',
    'category' => 'Blogs',
    'type' => 'widget',
    'name' => 'blog.featured-blogs',
      'defaultParams' => array(
      'title' => 'Featured Blogs',
    ),
  ),
   array(
    'title' => 'Categories Blogs',
    'description' => 'Displays categories on browse blogs page.',
    'category' => 'Blogs',
    'type' => 'widget',
    'name' => 'blog.categories-blogs',
        'defaultParams' => array(
      'title' => 'Categories',
    ),
    ),
  array(
    'title' => 'Search Blogs',
    'description' => 'Displays search blogs on browse blogs page.',
    'category' => 'Blogs',
    'type' => 'widget',
    'name' => 'blog.search-blogs',
  	'defaultParams' => array(
      'title' => 'Search Blogs',
    ),
  ),
   array(
    'title' => 'Listing Blogs',
    'description' => 'Displays listing blogs page.',
    'category' => 'Blogs',
    'type' => 'widget',
    'name' => 'blog.listing-blogs',
  ),
   array(
    'title' => 'Statistics Blogs',
    'description' => 'Displays statistic blogs on browse blogs page.',
    'category' => 'Blogs',
    'type' => 'widget',
    'name' => 'blog.statistics-blogs',
  ),
   array(
    'title' => 'Top Bloggers',
    'description' => 'Displays top bloggers on browse blogs page.',
    'category' => 'Blogs',
    'type' => 'widget',
    'name' => 'blog.top-bloggers',
    'defaultParams' => array(
      'title' => 'Top Bloggers',
    ),
    ),
     array(
    'title' => 'View By Date',
    'description' => 'Displays view by date on browse blogs page.',
    'category' => 'Blogs',
    'type' => 'widget',
    'name' => 'blog.view-by-date-blogs',
    ),
    array(
    'title' => 'Tags',
    'description' => 'Displays tags on browse blogs page.',
    'category' => 'Blogs',
    'type' => 'widget',
    'name' => 'blog.tags-blogs',
    ),
) ?>
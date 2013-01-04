<?php
class Blog_Installer extends Engine_Package_Installer_Module
{
  function onInstall()
  {
    //
    // install content areas
    //
    $db     = $this->getDb();
    $select = new Zend_Db_Select($db);

    // profile page
    $select
      ->from('engine4_core_pages')
      ->where('name = ?', 'user_profile_index')
      ->limit(1);
    $page_id = $select->query()->fetchObject()->page_id;


    // blog.profile-blogs

    // Check if it's already been placed
    $select = new Zend_Db_Select($db);
    $select
      ->from('engine4_core_content')
      ->where('page_id = ?', $page_id)
      ->where('type = ?', 'widget')
      ->where('name = ?', 'blog.profile-blogs')
      ;
    $info = $select->query()->fetch();

    if( empty($info) ) {

      // container_id (will always be there)
      $select = new Zend_Db_Select($db);
      $select
        ->from('engine4_core_content')
        ->where('page_id = ?', $page_id)
        ->where('type = ?', 'container')
        ->limit(1);
      $container_id = $select->query()->fetchObject()->content_id;

      // middle_id (will always be there)
      $select = new Zend_Db_Select($db);
      $select
        ->from('engine4_core_content')
        ->where('parent_content_id = ?', $container_id)
        ->where('type = ?', 'container')
        ->where('name = ?', 'middle')
        ->limit(1);
      $middle_id = $select->query()->fetchObject()->content_id;

      // tab_id (tab container) may not always be there
      $select
        ->reset('where')
        ->where('type = ?', 'widget')
        ->where('name = ?', 'core.container-tabs')
        ->where('page_id = ?', $page_id)
        ->limit(1);
      $tab_id = $select->query()->fetchObject();
      if( $tab_id && @$tab_id->content_id ) {
          $tab_id = $tab_id->content_id;
      } else {
        $tab_id = null;
      }

      // tab on profile
      $db->insert('engine4_core_content', array(
        'page_id' => $page_id,
        'type'    => 'widget',
        'name'    => 'blog.profile-blogs',
        'parent_content_id' => ($tab_id ? $tab_id : $middle_id),
        'order'   => 6,
        'params'  => '{"title":"Blogs","titleCount":true}',
      ));

    }
     //Browse Blogs
     $select = new Zend_Db_Select($db);
    $select
      ->from('engine4_core_pages')
      ->where('name = ?', 'blog_index_index')
      ->limit(1);
      ;
    $info = $select->query()->fetch();
    if($info){
      $db->query("DELETE FROM `engine4_core_pages` where `engine4_core_pages`.`page_id` =".$info['page_id']);
      $db->query("DELETE FROM `engine4_core_content` where `engine4_core_content`.`page_id` =".$info['page_id']);
    }
      $db->insert('engine4_core_pages', array(
        'name' => 'blog_index_index',
        'displayname' => 'Browse Blogs',
        'title' => 'Browse Blogs',
        'description' => 'This is browse blogs page.',
      ));
      $page_id = $db->lastInsertId('engine4_core_pages');

      // containers
       $db->insert('engine4_core_content', array(
        'page_id' => $page_id,
        'type' => 'container',
        'name' => 'top',
        'parent_content_id' => null,
        'order' => 1,
        'params' => '',
      ));
      $top_id = $db->lastInsertId('engine4_core_content');
       $db->insert('engine4_core_content', array(
        'page_id' => $page_id,
        'type' => 'container',
        'name' => 'middle',
        'parent_content_id' => $top_id,
        'order' => 6,
        'params' => '',
      ));
       $middle_id = $db->lastInsertId('engine4_core_content');  
       $db->insert('engine4_core_content', array(
        'page_id' => $page_id,
        'type' => 'widget',
        'name' => 'blog.menu-blogs',
        'parent_content_id' => $middle_id,
        'order' => 3,
        'params' => '',
      ));
      $db->insert('engine4_core_content', array(
        'page_id' => $page_id,
        'type' => 'container',
        'name' => 'main',
        'parent_content_id' => null,
        'order' => 2,
        'params' => '',
      ));
      $container_id = $db->lastInsertId('engine4_core_content');

      $db->insert('engine4_core_content', array(
        'page_id' => $page_id,
        'type' => 'container',
        'name' => 'middle',
        'parent_content_id' => $container_id,
        'order' => 6,
        'params' => '',
      ));
      $middle_id = $db->lastInsertId('engine4_core_content');
      
      $db->insert('engine4_core_content', array(
        'page_id' => $page_id,
        'type' => 'container',
        'name' => 'right',
        'parent_content_id' => $container_id,
        'order' => 5,
        'params' => '',
      ));
      $right_id = $db->lastInsertId('engine4_core_content');
      // middle column
      $db->insert('engine4_core_content', array(
        'page_id' => $page_id,
        'type' => 'widget',
        'name' => 'blog.featured-blogs',
        'parent_content_id' => $middle_id,
        'order' => 6,
        'params' => '',
      ));
       $db->insert('engine4_core_content', array(
        'page_id' => $page_id,
        'type' => 'widget',
        'name' => 'core.container-tabs',
        'parent_content_id' => $middle_id,
        'order' => 8,
        'params' => '{"max":"6","title":"","name":"core.container-tabs"}',
      ));
       $tab1_id = $db->lastInsertId('engine4_core_content'); 
       $db->insert('engine4_core_content', array(
        'page_id' => $page_id,
        'type' => 'widget',
        'name' => 'blog.new-blogs',
        'parent_content_id' => $tab1_id,
        'order' => 9,
        'params' => '{"title":"New Blogs"}',
      ));
       $db->insert('engine4_core_content', array(
        'page_id' => $page_id,
        'type' => 'widget',
        'name' => 'blog.top-blogs',
        'parent_content_id' => $tab1_id,
        'order' => 10,
        'params' => '{"title":"Top Blogs"}',
      ));
      
       $db->insert('engine4_core_content', array(
        'page_id' => $page_id,
        'type' => 'widget',
        'name' => 'core.container-tabs',
        'parent_content_id' => $middle_id,
        'order' => 12,
        'params' => '{"max":"6"}',
      )); 
      $tab2_id = $db->lastInsertId('engine4_core_content');
      $db->insert('engine4_core_content', array(
        'page_id' => $page_id,
        'type' => 'widget',
        'name' => 'blog.most-view-blogs',
        'parent_content_id' => $tab2_id,
        'order' => 13,
        'params' => '{"title":"Most Viewed Blogs"}',
      )); $db->insert('engine4_core_content', array(
        'page_id' => $page_id,
        'type' => 'widget',
        'name' => 'blog.most-comment-blogs',
        'parent_content_id' => $tab2_id,
        'order' => 14,
        'params' => '{"title":"Most Commented Blogs"}',
      )); 
     
      // right column
      
      $db->insert('engine4_core_content', array(
        'page_id' => $page_id,
        'type' => 'widget',
        'name' => 'blog.search-blogs',
        'parent_content_id' => $right_id,
        'order' => 17,
        'params' => '{"title":"Search Blogs"}',
      ));
      $db->insert('engine4_core_content', array(
        'page_id' => $page_id,
        'type' => 'widget',
        'name' => 'blog.categories-blogs',
        'parent_content_id' => $right_id,
        'order' => 18,
        'params' => '{"title":"Categories"}',
      ));
      $db->insert('engine4_core_content', array(
        'page_id' => $page_id,
        'type' => 'widget',
        'name' => 'blog.view-by-date-blogs',
        'parent_content_id' => $right_id,
        'order' => 19,
        'params' => '',
      ));
      $db->insert('engine4_core_content', array(
        'page_id' => $page_id,
        'type' => 'widget',
        'name' => 'blog.tags-blogs',
        'parent_content_id' => $right_id,
        'order' => 20,
        'params' => '',
      ));
       $db->insert('engine4_core_content', array(
        'page_id' => $page_id,
        'type' => 'widget',
        'name' => 'blog.statistics-blogs',
        'parent_content_id' => $right_id,
        'order' => 21,
        'params' => '',
      ));
      
     //Listing Blogs
     $select = new Zend_Db_Select($db);
    $select
      ->from('engine4_core_pages')
      ->where('name = ?', 'blog_index_listing')
      ->limit(1);
      ;
    $info = $select->query()->fetch();

    if( empty($info) ) {
      $db->insert('engine4_core_pages', array(
        'name' => 'blog_index_listing',
        'displayname' => 'Listing Blogs',
        'title' => 'Listing Blogs',
        'description' => 'This is listing blogs page.',
      ));
      $page_id = $db->lastInsertId('engine4_core_pages');

      // containers
       
      $db->insert('engine4_core_content', array(
        'page_id' => $page_id,
        'type' => 'container',
        'name' => 'main',
        'parent_content_id' => null,
        'order' => 2,
        'params' => '',
      ));
      $container_id = $db->lastInsertId('engine4_core_content');

      $db->insert('engine4_core_content', array(
        'page_id' => $page_id,
        'type' => 'container',
        'name' => 'middle',
        'parent_content_id' => $container_id,
        'order' => 6,
        'params' => '',
      ));
      $middle_id = $db->lastInsertId('engine4_core_content');
      
      $db->insert('engine4_core_content', array(
        'page_id' => $page_id,
        'type' => 'container',
        'name' => 'right',
        'parent_content_id' => $container_id,
        'order' => 5,
        'params' => '',
      ));
      $right_id = $db->lastInsertId('engine4_core_content');
      // middle column
      $db->insert('engine4_core_content', array(
        'page_id' => $page_id,
        'type' => 'widget',
        'name' => 'blog.listing-blogs',
        'parent_content_id' => $middle_id,
        'order' => 6,
        'params' => '',
      ));
      // right column
      
       $db->insert('engine4_core_content', array(
        'page_id' => $page_id,
        'type' => 'widget',
        'name' => 'blog.search-blogs',
        'parent_content_id' => $right_id,
        'order' => 17,
        'params' => '{"title":"Search Blogs"}',
      ));
      $db->insert('engine4_core_content', array(
        'page_id' => $page_id,
        'type' => 'widget',
        'name' => 'blog.categories-blogs',
        'parent_content_id' => $right_id,
        'order' => 18,
        'params' => '{"title":"Categories"}',
      ));
      $db->insert('engine4_core_content', array(
        'page_id' => $page_id,
        'type' => 'widget',
        'name' => 'blog.view-by-date-blogs',
        'parent_content_id' => $right_id,
        'order' => 19,
        'params' => '',
      ));
      $db->insert('engine4_core_content', array(
        'page_id' => $page_id,
        'type' => 'widget',
        'name' => 'blog.tags-blogs',
        'parent_content_id' => $right_id,
        'order' => 20,
        'params' => '',
      ));
       $db->insert('engine4_core_content', array(
        'page_id' => $page_id,
        'type' => 'widget',
        'name' => 'blog.statistics-blogs',
        'parent_content_id' => $right_id,
        'order' => 21,
        'params' => '',
      )); 
    }
    parent::onInstall();
    try {
      $db->query("ALTER TABLE `engine4_blog_blogs` ADD `become_count` INT( 11 ) NOT NULL DEFAULT '0' AFTER `comment_count`;");
      $db->query("ALTER TABLE `engine4_blog_becomes` ADD CONSTRAINT blog_user UNIQUE (blog_id, user_id);");
    }
    catch(Exception $e){
    }
  }
}
?>
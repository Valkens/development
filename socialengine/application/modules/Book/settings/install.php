<?php
class Book_Installer extends Engine_Package_Installer_Module
{
    function onInstall()
    {
        /**
         * Install content areas
         */
        $db     = $this->getDb();
        $select = new Zend_Db_Select($db);

        // Book homepage
        $select = new Zend_Db_Select($db);
        $select->from('engine4_core_pages')
               ->where('name = ?', 'book_index_index')
               ->limit(1);
        $info = $select->query()->fetch();

        // Delete book homepage if exists
        if ($info) {
            $db->query("DELETE FROM `engine4_core_pages` where `engine4_core_pages`.`page_id` =".$info['page_id']);
            $db->query("DELETE FROM `engine4_core_content` where `engine4_core_content`.`page_id` =".$info['page_id']);
        }

        /**
         * Insert book homepage
         */
        $db->insert('engine4_core_pages', array(
            'name' => 'book_index_index',
            'displayname' => 'Books Homepage',
            'title' => 'Books Homepage',
            'description' => 'This is book homepage',
        ));
        $page_id = $db->lastInsertId('engine4_core_pages');

        // Containers
        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'container',
            'name' => 'main',
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

        // Book menu
        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'book.menu-books',
            'parent_content_id' => $middle_id,
            'order' => 3,
            'params' => '[]',
        ));
        // Tabs
        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'core.container-tabs',
            'parent_content_id' => $middle_id,
            'order' => 4,
            'params' => '{"max":6}',
        ));
        $tab_id = $db->lastInsertId('engine4_core_content');
        // All book
        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'book.all-books',
            'parent_content_id' => $tab_id,
            'order' => 7,
            'params' => '{"title":"All books","titleCount":true}',
        ));
        // Recent added
        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'book.recent-added-books',
            'parent_content_id' => $tab_id,
            'order' => 6,
            'params' => '{"title":"Recent Added Books"}',
        ));
        // Most viewed
        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'book.most-viewed-books',
            'parent_content_id' => $tab_id,
            'order' => 5,
            'params' => '{"title":"Most viewed books"}',
        ));

        /**
         * Insert book detail page
         */
        $select = new Zend_Db_Select($db);
        $select
            ->from('engine4_core_pages')
            ->where('name = ?', 'book_index_view')
            ->limit(1);
        ;
        $info = $select->query()->fetch();

        if( empty($info) ) {
            $db->insert('engine4_core_pages', array(
                'name' => 'book_index_view',
                'displayname' => 'Book Detail Page',
                'title' => 'Book Detail Page',
                'description' => 'This is book detail page.',
            ));
        }
        $page_id = $db->lastInsertId('engine4_core_pages');

        // Container
        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'container',
            'name' => 'main',
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

        // Book menu
        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'book.menu-books',
            'parent_content_id' => $middle_id,
            'order' => 3,
            'params' => '[]',
        ));

        // Detail
        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'book.detail-books',
            'parent_content_id' => $middle_id,
            'order' => 4,
            'params' => '{"title":"Book detail"}',
        ));

        // Tabs
        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'core.container-tabs',
            'parent_content_id' => $middle_id,
            'order' => 5,
            'params' => '{"max":6}',
        ));
        $tab_id = $db->lastInsertId('engine4_core_content');

        // All book
        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'book.all-books',
            'parent_content_id' => $tab_id,
            'order' => 8,
            'params' => '{"title":"All books","titleCount":true}',
        ));
        // Recent added
        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'book.recent-added-books',
            'parent_content_id' => $tab_id,
            'order' => 7,
            'params' => '{"title":"Recent Added Books"}',
        ));
        // Most viewed
        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'book.most-viewed-books',
            'parent_content_id' => $tab_id,
            'order' => 6,
            'params' => '{"title":"Most viewed books"}',
        ));


        parent::onInstall();
    }
}
?>
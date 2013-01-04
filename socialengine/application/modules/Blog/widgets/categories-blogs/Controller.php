<?php
class Blog_Widget_CategoriesBlogsController extends Engine_Content_Widget_Abstract
{
	public function indexAction()
  {
       $table = Engine_Api::_()->getDbtable('categories', 'blog');
       $Name = $table->info('name');
       $select = $table->select()->from($Name);
      $this->view->categories =  $table->fetchAll($select);
  }
}
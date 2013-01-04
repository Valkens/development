<?php
class Blog_Widget_TopBloggersController extends Engine_Content_Widget_Abstract
{
	public function indexAction()
  {
       $table = Engine_Api::_()->getDbtable('blogs', 'blog');
       $Name = $table->info('name');
       $select = $table->select()->from($Name)
        ->group("$Name.owner_id")
       ->order("Count($Name.owner_id) DESC");
      $this->view->bloggers =  $table->fetchAll($select);
  }
}
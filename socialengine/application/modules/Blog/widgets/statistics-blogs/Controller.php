<?php
class Blog_Widget_StatisticsBlogsController extends Engine_Content_Widget_Abstract
{
	public function indexAction()
  {
       $table  = Engine_Api::_()->getDbTable('blogs', 'blog');
       $select = new Zend_Db_Select($table->getAdapter());
       $select->from($table->info('name'), 'COUNT(*) AS count');
       $this->view->count_blogs =  $select->query()->fetchColumn(0);
       
       $table = Engine_Api::_()->getDbtable('blogs', 'blog');
       $Name = $table->info('name');
       $select = $table->select()->from($Name,'owner_id')->distinct();
       $this->view->count_bloggers =  count($table->fetchAll($select));
  }
}
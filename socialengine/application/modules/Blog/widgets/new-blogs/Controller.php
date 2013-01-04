<?php
class Blog_Widget_NewBlogsController extends Engine_Content_Widget_Abstract
{
	public function indexAction()
  {
    if($this->_getParam('max') != '' && $this->_getParam('max') >= 0){       
    $limitNblog = $this->_getParam('max');
    }else{
    $limitNblog = 8; }
    $b_table = Engine_Api::_()->getDbtable('blogs', 'blog');
    $bName = $b_table->info('name');
    $select = $b_table->select()->from($bName)  ;
    $select  ->order('creation_date DESC');
    $select ->where("search = ?","1");
    $select ->where("draft = ?","0");
    $select->limit($limitNblog);    
	$this->view->blogs = $b_table->fetchAll($select);  
    $this->view->limit = $limitNblog;
  }
}

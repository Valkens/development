<?php
class Blog_Widget_MostViewBlogsController extends Engine_Content_Widget_Abstract
{
	public function indexAction()
  {
    if($this->_getParam('max') != ''  && $this->_getParam('max') >= 0){       
    $limitMVblog = $this->_getParam('max');
    }else{
    $limitMVblog = 4; }
    $table = Engine_Api::_()->getDbtable('blogs', 'blog');
    $Name = $table->info('name');
    $select = $table->select()->from($Name) ;
    $select  ->order('view_count DESC');
    $select ->where("search = ?","1");
    $select ->where("draft = ?","0");
    $select ->where("view_count > ?","0");
    $select->limit($limitMVblog);       
	$this->view->blogs = $table->fetchAll($select);
    $this->view->limit = $limitMVblog;
  }
}
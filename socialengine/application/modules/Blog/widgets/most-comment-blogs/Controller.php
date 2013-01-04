<?php
class Blog_Widget_MostCommentBlogsController extends Engine_Content_Widget_Abstract
{
	public function indexAction()
  {
     if($this->_getParam('max') != '' && $this->_getParam('max') >= 0){       
    $limitMCblog = $this->_getParam('max');
    }else{
    $limitMCblog = 4; }
    $b_table = Engine_Api::_()->getDbtable('blogs', 'blog');
    $bName = $b_table->info('name');
    $select = $b_table->select()->from($bName)  ;
    $select  ->order('comment_count DESC');
    $select ->where("search = ?","1"); 
    $select ->where("draft = ?","0"); 
    $select ->where("comment_count > ?","0");  
    $select->limit($limitMCblog);      
    $this->view->blogs = $b_table->fetchAll($select);
    $this->view->limit = $limitMCblog;
  }
}
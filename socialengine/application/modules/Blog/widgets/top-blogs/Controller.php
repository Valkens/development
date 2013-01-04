<?php
class Blog_Widget_TopBlogsController extends Engine_Content_Widget_Abstract
{
	public function indexAction()
  {
     if($this->_getParam('max') != '' && $this->_getParam('max') >= 0){       
    $this->view->limit = $this->_getParam('max');
    }else{
    $this->view->limit = 8; }
    $btable = Engine_Api::_()->getDbtable('blogs', 'blog');
    $ltable  = Engine_Api::_()->getDbtable('likes', 'core');
    $bName = $btable->info('name');
    $lName = $ltable->info('name');
    $select = $btable->select()->from($bName)  ;
    $select
    ->joinLeft($lName, "resource_id = blog_id",'')
    ->where("resource_type  LIKE 'blog'")        
    ->group("resource_id")
    ->order("Count(resource_id) DESC");
    $select ->where("search = ?","1"); 
    $select ->where("draft = ?","0");
    $this->view->blogs = $btable->fetchAll($select);
  }
}
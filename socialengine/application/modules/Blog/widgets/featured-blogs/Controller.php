<?php
class Blog_Widget_FeaturedBlogsController extends Engine_Content_Widget_Abstract
{
	public function indexAction()
  {
    if($this->_getParam('max') != '' && $this->_getParam('max') >= 0){
    $limitFblog = $this->_getParam('max');
    }else{
    $limitFblog = 4; }
    $btable = Engine_Api::_()->getDbtable('blogs', 'blog');
    $ftable  = Engine_Api::_()->getDbtable('features', 'blog');
    $bName = $btable->info('name');
    $fName = $ftable->info('name');
    $select = $btable->select()->from($bName)  ;
    $select->joinLeft($fName, "$fName.blog_id = $bName.blog_id",'');
    $select ->where("$bName.search = ?","1");
    $select ->where("$bName.draft = ?","0");
    $select ->where("$fName.blog_good = ?","1"); 
    $select->limit($limitFblog);     
    $this->view->blogs = $btable->fetchAll($select);
  }
}
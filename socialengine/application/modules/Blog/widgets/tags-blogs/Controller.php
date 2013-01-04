<?php
class Blog_Widget_TagsBlogsController extends Engine_Content_Widget_Abstract
{
	public function indexAction()
  {
    $t_table = Engine_Api::_()->getDbtable('tags', 'core');
    $tName = $t_table->info('name');
    $select = $t_table->select()->from($tName,array("$tName.*","Count($tName.tag_id) as count"));
    $select->joinLeft("engine4_core_tagmaps", "engine4_core_tagmaps.tag_id = $tName.tag_id",''); 
    $select  ->order("$tName.text");
    $select  ->group("$tName.text");
    $select ->where("engine4_core_tagmaps.resource_type = ?","blog");
    $this->view->tags = $t_table->fetchAll($select);
  }
}
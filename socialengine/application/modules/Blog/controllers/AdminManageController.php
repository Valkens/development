<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Blog
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.net/license/
 * @version    $Id: AdminManageController.php 7244 2010-09-01 01:49:53Z john $
 * @author     Jung
 */

/**
 * @category   Application_Extensions
 * @package    Blog
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.net/license/
 */
class Blog_AdminManageController extends Core_Controller_Action_Admin
{
  public function indexAction()
  {
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('blog_admin_main', array(), 'blog_admin_main_manage');
      
    $page = $this->_getParam('page',1);
    $this->view->paginator = Engine_Api::_()->blog()->getBlogsPaginator(array(
      'orderby' => 'blog_id',
    ));
    $this->view->paginator->setItemCountPerPage(4);
    $this->view->paginator->setCurrentPageNumber($page);
  }

  public function deleteAction()
  {
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $id = $this->_getParam('id');
    $this->view->blog_id=$id;
    // Check post
    if( $this->getRequest()->isPost() )
    {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();

      try
      {
        $blog = Engine_Api::_()->getItem('blog', $id);
        // delete the blog entry into the database
        $blog->delete();
        $db->commit();
      }

      catch( Exception $e )
      {
        $db->rollBack();
        throw $e;
      }

      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh'=> 10,
          'messages' => array('')
      ));
    }

    // Output
    $this->renderScript('admin-manage/delete.tpl'); //can them vao di se4 bi loi.
  }

  public function deleteselectedAction()
  {
    $this->view->ids = $ids = $this->_getParam('ids', null);
    $confirm = $this->_getParam('confirm', false);
    $this->view->count = count(explode(",", $ids));

    // Save values
    if( $this->getRequest()->isPost() && $confirm == true )
    {
      $ids_array = explode(",", $ids);
      foreach( $ids_array as $id ){
        $blog = Engine_Api::_()->getItem('blog', $id);
        if( $blog ) $blog->delete();
      }

      $this->_helper->redirector->gotoRoute(array('action' => 'index'));
    }

  }
  //hfsdjsdgsdhffgsdfhsdghjsdgfhjdgsdhgsdh
  public function featuredAction()
  {
      $blog_id = $this->_getParam('blog_id'); 
      $blog_good = $this->_getParam('good'); 
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      $ftable = Engine_Api::_()->getDbtable('features', 'blog');
      $fName = $ftable->info('name'); 
      $select = $ftable->select()->from($fName)->where("blog_id = ?",$blog_id); 
      $features = $ftable->fetchAll($select); 
      if(count($features) > 0)
      {
          $feature_id = $features[0]-> feature_id;
          $feature = Engine_Api::_()->getItem('blog_feature', $feature_id); 
          $feature->blog_good =  $blog_good;
          $feature->save(); 
      }
      else
      {
          $feature = Engine_Api::_()->getDbtable('features', 'blog')->createRow(); 
          $feature->blog_id = $blog_id;
          $feature->blog_good = $blog_good;
          $feature->save();
      }
      $db->commit();    
  }
}
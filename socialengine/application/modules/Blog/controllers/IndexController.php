<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Blog
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.net/license/
 * @version    $Id: IndexController.php 7281 2010-09-03 03:46:33Z john $
 * @author     Jung
 */

/**
 * @category   Application_Extensions
 * @package    Blog
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.net/license/
 */
class Blog_IndexController extends Core_Controller_Action_Standard
{
  public function init()
  {
    // only show to member_level if authorized
    if( !$this->_helper->requireAuth()->setAuthParams('blog', null, 'view')->isValid() ) return;
  }

  public function indexAction()
  {
      $array = $this->getRequest()->getPost();
      $subject = Engine_Api::_()->getItem('blog_param', 1);
       if (isset($array['show']))
           {
               $subject->show = NULL;
           }
           $subject->search = NULL;
           $subject->orderby = NULL;
           $subject->show = 1;
           $subject->category = 0;
           $subject->page = NULL;
           $subject->tag = NULL;
           $subject->start_date = NULL;
           $subject->end_date = NULL;
           $subject->date = NULL;
           $subject->save();
       $search = $sort = $category_id = $show = $tag =  null;
       if($array)
       {
           $subject->search = $array['search'];
           $subject->orderby = $array['orderby'];

           // Text box 'show' only appears after user log in
           // This "if" is for the case the viewer hasn't log in yet.
           if (isset($array['show']))
           {
               $subject->show = $array['show'];
               $show = $subject->show;
           }

           $subject->category = $array['category'];
           $subject->page = $array['page'];
           $subject->tag = $array['tag'];
           $subject->start_date = $array['start_date'];
           $subject->end_date = $array['end_date'];
           $subject->date = NULL;
           if($array['tag'] != '')
           {
               $subject->search = '';
           }
           $subject->save();
           $tag =  $subject->tag;
           $search = $subject->search;

           $sort = $subject->orderby;
           $category_id = $subject->category;

           if($search != '' || $sort != '' || $category_id != '' || $show != '' || $tag != '')
           {
               $this->_redirect('blogs/listing');
           }
       }

             $this->_helper->content
               ->setNoRender()
                ->setEnabled()
                ;
  }
   public function listingAction()
  {
        if( !$this->_helper->requireAuth()->setAuthParams('blog', null, 'view')->isValid() ) return;
        if($this->_getParam('category') != '' || $this->_getParam('page') != ''|| $this->_getParam('orderby') != '' || $this->_getParam('show') != '' || $this->_getParam('tag') != '' || $this->_getParam('date') != '')
        {
              $subject = Engine_Api::_()->getItem('blog_param', 1);
              $subject->search = '';
              $subject->show = $this->_getParam('show');
              $subject->category = $this->_getParam('category');
              $subject->page = $this->_getParam('page');
              $subject->orderby = $this->_getParam('orderby');
              $subject->tag = $this->_getParam('tag');
              $subject->date = $this->_getParam('date');
              $subject->save();
        }
             $this->_helper->content
               ->setNoRender()
                ->setEnabled()
                ;
  }
   public function featuredAjaxAction()
  {
      //tat di layout
       $this->_helper->layout->disableLayout();
       //khong su dung view
       $this->_helper->viewRenderer->setNoRender(TRUE);
       $blog     = Engine_Api::_()->getItem('blog', $this->getRequest()->getParam('blog_id'));
       echo $this->view->partial('ajax/_featured_ajax.tpl', array('blog'=>$blog));
       return;
  }
   public function featuredOldAjaxAction()
  {
      //tat di layout
       $this->_helper->layout->disableLayout();
       //khong su dung view
       $this->_helper->viewRenderer->setNoRender(TRUE);
       $blog     = Engine_Api::_()->getItem('blog', $this->getRequest()->getParam('blog_id'));
        $btable = Engine_Api::_()->getDbtable('blogs', 'blog');
        $ftable  = Engine_Api::_()->getDbtable('features', 'blog');
        $bName = $btable->info('name');
        $fName = $ftable->info('name');
        $select = $btable->select()->from($bName)  ;
        $select->joinLeft($fName, "$fName.blog_id = $bName.blog_id",'');
        $select ->where("$bName.search = ?","1");
        $select ->where("$bName.draft = ?","0");
        $select ->where("$fName.blog_good = ?","1");
        $select->limit(4);
        $blogs = $btable->fetchAll($select);
       echo $this->view->partial('ajax/_featured_old_ajax.tpl', array('blog'=>$blog,'blogs'=>$blogs));
       return;
  }
  public function viewAction()
  {
    // Check permission
    $viewer = Engine_Api::_()->user()->getViewer();
    $blog = Engine_Api::_()->getItem('blog', $this->_getParam('blog_id'));
    if( $blog ) {
      Engine_Api::_()->core()->setSubject($blog);
    }

    if( !$this->_helper->requireSubject()->isValid() ) return;
    if( !$this->_helper->requireAuth()->setAuthParams($blog, $viewer, 'view')->isValid()) return;

    // Get navigation
    $this->view->gutterNavigation = $gutterNavigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('blog_gutter');

    // Prepare data
    $archiveList = Engine_Api::_()->blog()->getArchiveList($blog->owner_id);

    $this->view->archive_list = $this->_handleArchiveList($archiveList);
    $this->view->viewer = $viewer;
    $blog->view_count++;
    $this->view->blog = $blog;
    $blog->save();
    $this->view->blogTags = $blog->tags()->getTagMaps();
   // $this->view->userTags = $blog->tags()->getTagsByTagger($blog->getOwner());

    if($blog->category_id !=0) $this->view->category = Engine_Api::_()->blog()->getCategory($blog->category_id);
    $this->view->userCategories = Engine_Api::_()->blog()->getUserCategories($this->view->blog->owner_id);

    // Get styles
    $this->view->owner = $user = $blog->getOwner();

    $t_table = Engine_Api::_()->getDbtable('tags', 'core');
    $tName = $t_table->info('name');
    $select = $t_table->select()->from($tName,array("$tName.*","Count($tName.tag_id) as count"))
        ->joinLeft("engine4_core_tagmaps", "engine4_core_tagmaps.tag_id = $tName.tag_id",'')
         ->order("$tName.text")
         ->group("$tName.text")
         ->where("engine4_core_tagmaps.tagger_id = ?", $blog->owner_id)
         ->where("engine4_core_tagmaps.resource_type = ?","blog");
    $this->view->userTags = $t_table->fetchAll($select);
  }

  // USER SPECIFIC METHODS
  public function manageAction()
  {
    if( !$this->_helper->requireUser()->isValid() ) return;

    // Get navigation
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('blog_main');

    // Get quick navigation
    $this->view->quickNavigation = $quickNavigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('blog_quick');

    // Prepare data
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->form = $form = new Blog_Form_Search();
    $this->view->canCreate = $this->_helper->requireAuth()->setAuthParams('blog', null, 'create')->checkRequire();

    $form->removeElement('show');

    // Populate form
    $this->view->categories = $categories = Engine_Api::_()->blog()->getCategories();
    foreach( $categories as $category )
    {
      $form->category->addMultiOption($category->category_id, $category->category_name);
    }

    // Process form
    $form->isValid($this->getRequest()->getPost());
    $values = $form->getValues();
    $values['user_id'] = $viewer->getIdentity();

    // Get paginator
    $this->view->paginator = $paginator = Engine_Api::_()->blog()->getBlogsPaginator($values);
    $items_per_page = Engine_Api::_()->getApi('settings', 'core')->blog_page;
    $paginator->setItemCountPerPage($items_per_page);
    $this->view->paginator = $paginator->setCurrentPageNumber( $values['page'] );
  }

  public function listAction()
  {
    // Preload info
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->owner = $owner = Engine_Api::_()->getItem('user', $this->_getParam('user_id'));
    $this->view->archive_list = $archiveList = Engine_Api::_()->blog()->getArchiveList($owner);

    // Get navigation
    $this->view->gutterNavigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('blog_gutter', array('user_id' => $owner->getIdentity()));

    // Make form
    $this->view->form = $form = new Blog_Form_Search();
    $form->removeElement('show');

    // Populate form
    $this->view->categories = $categories = Engine_Api::_()->blog()->getCategories();
    foreach( $categories as $category ) {
      $form->category->addMultiOption($category->category_id, $category->category_name);
    }

    // Process form
    $form->isValid($this->getRequest()->getPost());
    $values = $form->getValues();
    $owner_id = $values['user_id'] = $owner->getIdentity();
    $values['draft'] = "0";
    $values['visible'] = "1";


    $this->view->assign($values);

    // Get paginator
    $this->view->paginator = $paginator = Engine_Api::_()->blog()->getBlogsPaginator($values);
    $items_per_page = Engine_Api::_()->getApi('settings', 'core')->blog_page;
    $paginator->setItemCountPerPage($items_per_page);

    $this->view->paginator = $paginator->setCurrentPageNumber( $values['page'] );

  //  $this->view->userTags = Engine_Api::_()->getDbtable('tags', 'core')->getTagsByTagger('blog', $owner);
    $this->view->userCategories = Engine_Api::_()->blog()->getUserCategories($owner->getIdentity());

    $this->view->owner = $owner;

    $t_table = Engine_Api::_()->getDbtable('tags', 'core');
    $tName = $t_table->info('name');
    $select = $t_table->select()->from($tName,array("$tName.*","Count($tName.tag_id) as count"))
        ->joinLeft("engine4_core_tagmaps", "engine4_core_tagmaps.tag_id = $tName.tag_id",'')
         ->order("$tName.text")
         ->group("$tName.text")
         ->where("engine4_core_tagmaps.tagger_id = ?", $owner_id)
         ->where("engine4_core_tagmaps.resource_type = ?","blog");
    $this->view->userTags = $t_table->fetchAll($select);

  }

  public function createAction()
  {
    if( !$this->_helper->requireUser()->isValid() ) return;
    if( !$this->_helper->requireAuth()->setAuthParams('blog', null, 'create')->isValid()) return;

    // Get navigation
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('blog_main');

    // Prepare form
    $this->view->form = $form = new Blog_Form_Create();

    // If not post or form not valid, return
    if( !$this->getRequest()->isPost() ) {
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }


    // Process
    $table = Engine_Api::_()->getItemTable('blog');
    $db = $table->getAdapter();
    $db->beginTransaction();

    try
    {
      // Create blog
      $viewer = Engine_Api::_()->user()->getViewer();
      $values = array_merge($form->getValues(), array(
        'owner_type' => $viewer->getType(),
        'owner_id' => $viewer->getIdentity(),
      ));

      $blog = $table->createRow();
      $blog->setFromArray($values);

      $blog->save();

      // Auth
      $auth = Engine_Api::_()->authorization()->context;
      $roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'everyone');

      if( empty($values['auth_view']) ) {
        $values['auth_view'] = 'everyone';
      }

      if( empty($values['auth_comment']) ) {
        $values['auth_comment'] = 'everyone';
      }

      $viewMax = array_search($values['auth_view'], $roles);
      $commentMax = array_search($values['auth_comment'], $roles);

      foreach( $roles as $i => $role ) {
        $auth->setAllowed($blog, $role, 'view', ($i <= $viewMax));
        $auth->setAllowed($blog, $role, 'comment', ($i <= $commentMax));
      }

      // Add tags
      $tags = preg_split('/[,]+/', $values['tags']);
      $blog->tags()->addTagMaps($viewer, $tags);

      // Add activity only if blog is published
      if( $values['draft'] == 0 ) {
        $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $blog, 'blog_new');

        // make sure action exists before attaching the blog to the activity
        if( $action ) {
          Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $blog);
        }

      }

      // Send notifications for subscribers
      Engine_Api::_()->getDbtable('subscriptions', 'blog')
          ->sendNotifications($blog);

      // Commit
      $db->commit();
    }

    catch( Exception $e )
    {
      $db->rollBack();
      throw $e;
    }

    return $this->_helper->redirector->gotoRoute(array('action' => 'manage'));
  }

  public function editAction()
  {
    if( !$this->_helper->requireUser()->isValid() ) return;

    $viewer = Engine_Api::_()->user()->getViewer();
    $blog = Engine_Api::_()->getItem('blog', $this->_getParam('blog_id'));
    if( !Engine_Api::_()->core()->hasSubject('blog') ) {
      Engine_Api::_()->core()->setSubject($blog);
    }

    if( !$this->_helper->requireSubject()->isValid() ) return;
    if( !$this->_helper->requireAuth()->setAuthParams($blog, $viewer, 'edit')->isValid() ) return;

    // Get navigation
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('blog_main');

    // Prepare form
    $this->view->form = $form = new Blog_Form_Edit();

    // Populate form
    $form->populate($blog->toArray());

    $tagStr = '';
    foreach( $blog->tags()->getTagMaps() as $tagMap ) {
      $tag = $tagMap->getTag();
      if( !isset($tag->text) ) continue;
      if( '' !== $tagStr ) $tagStr .= ', ';
      $tagStr .= $tag->text;
    }
    $form->populate(array(
      'tags' => $tagStr,
    ));
    $this->view->tagNamePrepared = $tagStr;

    $auth = Engine_Api::_()->authorization()->context;
    $roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'everyone');

    foreach( $roles as $role ) {
      if( $auth->isAllowed($blog, $role, 'view') ) {
        $form->auth_view->setValue($role);
      }
      if( $auth->isAllowed($blog, $role, 'comment') ) {
        $form->auth_comment->setValue($role);
      }
    }

    // hide status change if it has been already published
    if( $blog->draft == "0" ) {
      $form->removeElement('draft');
    }


    // Check post/form
    if( !$this->getRequest()->isPost() ) {
      return;
    }
    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }


    // Process
    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();

    try
    {
      $values = $form->getValues();

      $blog->setFromArray($values);
      $blog->modified_date = date('Y-m-d H:i:s');
      $blog->save();

      // Auth
      if( empty($values['auth_view']) ) {
        $values['auth_view'] = 'everyone';
      }

      if( empty($values['auth_comment']) ) {
        $values['auth_comment'] = 'everyone';
      }

      $viewMax = array_search($values['auth_view'], $roles);
      $commentMax = array_search($values['auth_comment'], $roles);

      foreach( $roles as $i => $role ) {
        $auth->setAllowed($blog, $role, 'view', ($i <= $viewMax));
        $auth->setAllowed($blog, $role, 'comment', ($i <= $commentMax));
      }

      // handle tags
      $tags = preg_split('/[,]+/', $values['tags']);
      $blog->tags()->setTagMaps($viewer, $tags);

      // insert new activity if blog is just getting published
      $action = Engine_Api::_()->getDbtable('actions', 'activity')->getActionsByObject($blog);
      if( count($action->toArray()) <= 0 && $values['draft'] == '0' ) {
        $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $blog, 'blog_new');
          // make sure action exists before attaching the blog to the activity
        if( $action != null ) {
          Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $blog);
        }
      }

      // Rebuild privacy
      $actionTable = Engine_Api::_()->getDbtable('actions', 'activity');
      foreach( $actionTable->getActionsByObject($blog) as $action ) {
        $actionTable->resetActivityBindings($action);
      }

      $db->commit();

    }
    catch( Exception $e )
    {
      $db->rollBack();
      throw $e;
    }

    return $this->_helper->redirector->gotoRoute(array('action' => 'manage'));
  }

  public function deleteAction()
  {
    // Check permissions
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->blog = $blog = Engine_Api::_()->getItem('blog', $this->_getParam('blog_id'));

    if( !$this->_helper->requireUser()->isValid() ) return;
    if( !$this->_helper->requireAuth()->setAuthParams($blog, $viewer, 'delete')->isValid() ) return;

    // Get navigation
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('blog_main');

    // Check post/form
    if( !$this->getRequest()->isPost() ) {
      return;
    }
    //if( !$form->isValid($this->getRequest()->getPost()) ) {
    //  return;
    //}

    $table = $blog->getTable();
    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();

    try {
      $blog->delete();
      $db->commit();
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }

    return $this->_helper->redirector->gotoRoute(array('action' => 'manage'));
  }

  public function styleAction()
  {
    if( !$this->_helper->requireUser()->isValid() ) return;
    if( !$this->_helper->requireAuth()->setAuthParams('blog', null, 'style')->isValid()) return;

    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');

    // Require user
    if( !$this->_helper->requireUser()->isValid() ) return;
    $user = Engine_Api::_()->user()->getViewer();

    // Make form
    $this->view->form = $form = new Blog_Form_Style();

    // Get current row
    $table = Engine_Api::_()->getDbtable('styles', 'core');
    $select = $table->select()
      ->where('type = ?', 'user_blog') // @todo this is not a real type
      ->where('id = ?', $user->getIdentity())
      ->limit(1);

    $row = $table->fetchRow($select);

    // Check post
    if( !$this->getRequest()->isPost() )
    {
      $form->populate(array(
        'style' => ( null === $row ? '' : $row->style )
      ));
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()) )
    {
      return;
    }

    // Cool! Process
    $style = $form->getValue('style');

    // Save
    if( null == $row )
    {
      $row = $table->createRow();
      $row->type = 'user_blog'; // @todo this is not a real type
      $row->id = $user->getIdentity();
    }

    $row->style = $style;
    $row->save();

    $this->view->draft = true;
    $this->view->message = Zend_Registry::get('Zend_Translate')->_("Your changes have been saved.");
    $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => true,
        'parentRefresh' => false,
        'messages' => array(Zend_Registry::get('Zend_Translate')->_('Your changes have been saved.'))
    ));
  }




  // Utility

  /**
   * Returns an array of dates where a given user created a blog entry
   *
   * @param Zend_Db_Table_Select collection of dates
   * @return Array Dates
   */
  protected function _handleArchiveList($results)
  {
    $localeObject = Zend_Registry::get('Locale');

    $blog_dates = array();
    foreach ($results as $result)
      $blog_dates[] = strtotime($result->creation_date);

    // GEN ARCHIVE LIST
    $time = time();
    $archive_list = array();

    foreach( $blog_dates as $blog_date )
    {
      $ltime = localtime($blog_date, TRUE);
      $ltime["tm_mon"] = $ltime["tm_mon"] + 1;
      $ltime["tm_year"] = $ltime["tm_year"] + 1900;

      // LESS THAN A YEAR AGO - MONTHS
      if( $blog_date+31536000>$time )
      {
        $date_start = mktime(0, 0, 0, $ltime["tm_mon"], 1, $ltime["tm_year"]);
        $date_end = mktime(0, 0, 0, $ltime["tm_mon"]+1, 1, $ltime["tm_year"]);
        //$label = date('F Y', $blog_date);
        $type = 'month';

        $dateObject = new Zend_Date($blog_date);
        $format = $localeObject->getTranslation('MMMMd', 'dateitem', $localeObject);
        $label = $dateObject->toString($format, $localeObject);
      }

      // MORE THAN A YEAR AGO - YEARS
      else
      {
        $date_start = mktime(0, 0, 0, 1, 1, $ltime["tm_year"]);
        $date_end = mktime(0, 0, 0, 1, 1, $ltime["tm_year"]+1);
        //$label = date('Y', $blog_date);
        $type = 'year';

        $dateObject = new Zend_Date($blog_date);
        $format = $localeObject->getTranslation('yyyy', 'dateitem', $localeObject);
        if( !$format ) {
          $format = $localeObject->getTranslation('y', 'dateitem', $localeObject);
        }
        $label = $dateObject->toString($format, $localeObject);
      }

      if( !isset($archive_list[$date_start]) )
      {
        $archive_list[$date_start] = array(
          'type' => $type,
          'label' => $label,
          'date_start' => $date_start,
          'date_end' => $date_end,
          'count' => 1
        );
      }
      else
      {
        $archive_list[$date_start]['count']++;
      }
    }

    //krsort($archive_list);
    return $archive_list;
  }
   public function becomeAction()
  {
   //tat di layout
   $this->_helper->layout->disableLayout();
   //khong su dung view
   $this->_helper->viewRenderer->setNoRender(TRUE);
    // Check permission
    if( !$this->_helper->requireUser()->isValid() ) return;
    $viewer = Engine_Api::_()->user()->getViewer();
    $blog = Engine_Api::_()->getItem('blog', $this->_getParam('blog_id'));
    if( !$this->_helper->requireAuth()->setAuthParams($blog, $viewer, 'view')->isValid()) return;
     // Process
    $table =  Engine_Api::_()->getDbtable('becomes', 'blog');
    $db = $table->getAdapter();
    $db->beginTransaction();
    try
    {
      // Create become_member
      $become = $table->createRow();
      $become->blog_id = $blog->blog_id;
      $become->user_id = $viewer->getIdentity();
      $become->save();

      $blog->become_count = $blog->become_count + 1;
      $blog->save();
     // Commit
      $db->commit();
    }
    catch( Exception $e )
    {
      $db->rollBack();
      throw $e;
    }
  }
  ////

   public function rssAction()
  {
       //tat di layout
       $this->_helper->layout->disableLayout();
       $viewer = Engine_Api::_()->user()->getViewer();
        // Must be able to view blogs
        if( !Engine_Api::_()->authorization()->isAllowed('blog', $viewer, 'view') ) {
          return ;
        }
        $cat = $this->_getParam('category');
        $blog_id = $this->_getParam('rss_id');
        $owner_id = $this->_getParam('owner');//
         $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('blog_main');
        if($cat && $blog_id <= 0)
        {
            // Get navigation
            $params = array();
            if($cat > 0)
            {
                $params['category'] = $cat;
                if( $owner_id){
                    $params['user_id'] = $owner_id;//
                }
                $categories = Engine_Api::_()->blog()->getCategories();
                 foreach( $categories as $category )
                 {
                    if($category->category_id == $cat)
                    {
                         $pro_type_name = $category->category_name;
                    }
                 }
            }
            else
                $pro_type_name = "All Blogs";
        }
        else
        {
            $pro_type_name = 'Blog';
            $params['blogRss'] = $blog_id;
        }
        $table = Engine_Api::_()->getDbtable('blogs', 'blog');
        $blogs = $table->fetchAll(Blog_Api_Core::getBlogsSelect($params));
        $this->view->blogs = $blogs;
        $this->view->pro_type_name = str_replace('&','-',$pro_type_name);
  }
   public function uploadPhotoAction(){
    $viewer = Engine_Api::_()->user()->getViewer();

    $this->_helper->layout->disableLayout();

    if( !Engine_Api::_()->authorization()->isAllowed('album', $viewer, 'create') ) {
      return false;
    }

    if( !$this->_helper->requireAuth()->setAuthParams('album', null, 'create')->isValid() ) return;

    if( !$this->_helper->requireUser()->checkRequire() )
    {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Max file size limit exceeded (probably).');
      return;
    }

    if( !$this->getRequest()->isPost() )
    {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
      return;
    }
    if( !isset($_FILES['Filedata']) || !is_uploaded_file($_FILES['Filedata']['tmp_name']) )
    {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid Upload');
      return;
    }

    $db = Engine_Api::_()->getDbtable('photos', 'album')->getAdapter();
    $db->beginTransaction();

    try
    {
      $viewer = Engine_Api::_()->user()->getViewer();

      $photoTable = Engine_Api::_()->getDbtable('photos', 'album');
      $photo = $photoTable->createRow();
      $photo->setFromArray(array(
        'owner_type' => 'user',
        'owner_id' => $viewer->getIdentity()
      ));
      $photo->save();

      $photo->setPhoto($_FILES['Filedata']);

      $this->view->status = true;
      $this->view->name = $_FILES['Filedata']['name'];
      $this->view->photo_id = $photo->photo_id;
      $this->view->photo_url = $photo->getPhotoUrl();

      $table = Engine_Api::_()->getDbtable('albums', 'album');
      $album = $table->getSpecialAlbum($viewer, 'blog');

      $photo->collection_id = $album->album_id;
      $photo->save();

      if( !$album->photo_id )
      {
        $album->photo_id = $photo->getIdentity();
        $album->save();
      }

      $auth      = Engine_Api::_()->authorization()->context;
      $auth->setAllowed($photo, 'everyone', 'view',    true);
      $auth->setAllowed($photo, 'everyone', 'comment', true);
      $auth->setAllowed($album, 'everyone', 'view',    true);
      $auth->setAllowed($album, 'everyone', 'comment', true);


      $db->commit();

    } catch( Album_Model_Exception $e ) {
      $db->rollBack();
      $this->view->status = false;
      $this->view->error = $this->view->translate($e->getMessage());
      //throw $e;
      return;

    } catch( Exception $e ) {
      $db->rollBack();
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('An error occurred.');
      //throw $e;
      return;
    }
  }
}


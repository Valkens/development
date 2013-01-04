<?php
class Blog_Widget_ListingBlogsController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->getItem('blog_param', 1);
    $values = null;
    if($viewer->getIdentity() )
        $values['show']= $subject->show; 
    $values['category']= $subject->category; 
    $values['page']= $subject->page; 
    $values['tag']= $subject->tag;
    $values['orderby']= $subject->orderby; 
    $values['search']= $subject->search;
    $values['date']= $subject->date;
    if($values['category'] != '')
         $values['date'] = '';
     if($_POST)
      {
          $values['orderby']= $_POST['orderby'];
          $values['search']= $_POST['search'];
          $values['tag']= $_POST['tag'];
          $values['category']=  $_POST['category'];
          $values['date']= NULL;
          if($viewer->getIdentity() )
                $values['show'] =  $_POST['show'];
      } 
    // Do the show thingy
    if(@$values['show'] == 2 )
    {
      // Get an array of friend ids to pass to getBlogsPaginator
      $table = Engine_Api::_()->getItemTable('user');
      $select = $viewer->membership()->getMembersSelect('user_id');
      $friends = $table->fetchAll($select);
      // Get stuff
      $ids = array();
      foreach( $friends as $friend )
      {
        $ids[] = $friend->user_id;
      }
      //unset($values['show']);
      $values['users'] = $ids;
    }
    $values['draft'] = "0";
    $values['visible'] = "1";

    $this->view->assign($values);

    $paginator = Engine_Api::_()->blog()->getBlogsPaginator($values);
    $items_per_page = Engine_Api::_()->getApi('settings', 'core')->blog_page;
    $this->view->items_per_page = $items_per_page;
    $paginator->setItemCountPerPage($items_per_page);

    $this->view->paginator = $paginator->setCurrentPageNumber( $values['page'] );
    if($values['category'] == 0 || $values['category'] == "")
        $this->view->category_name = "All Categories";
    else
    {
        $categories = Engine_Api::_()->blog()->getCategories();
         foreach( $categories as $category )
         {
            if($category->category_id == $values['category'])
            {
                 $this->view->category_name = $category->category_name;
            }
         }
    }
    if( !empty($values['category']) ) $this->view->categoryObject = $aaa = Engine_Api::_()->blog()->getCategory($values['category']);
  }
}

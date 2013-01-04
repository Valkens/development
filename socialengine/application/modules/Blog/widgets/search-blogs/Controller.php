<?php
class Blog_Widget_SearchBlogsController extends Engine_Content_Widget_Abstract
{
	public function indexAction()
  { 
      
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->form = $form = new Blog_Form_Search();
   
    $form->removeElement('draft');
    if( !$viewer->getIdentity() )
    {
      $form->removeElement('show');
    }

    // Populate form
    $this->view->categories = $categories = Engine_Api::_()->blog()->getCategories();
    foreach( $categories as $category )
    {
      $form->category->addMultiOption($category->category_id, $category->category_name);
    }
    if($_POST) 
    { 
        $form->isValid($_POST);
        $subject = Engine_Api::_()->getItem('blog_param', 1); 
        $subject->tag = '';
         $subject->save();
    } 
    else
        {
           $subject = Engine_Api::_()->getItem('blog_param', 1);   
           $form->getElement('search')->setValue($subject->search);
           $form->getElement('orderby')->setValue($subject->orderby);
           if($viewer->getIdentity() )
           {
                $form->getElement('show')->setValue($subject->show);
           }
           if($form->getElement('category')) $form->getElement('category')->setValue($subject->category); 
        }
  }
}
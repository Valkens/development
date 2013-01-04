<?php
class Blog_AdminAddthisController extends Core_Controller_Action_Admin
{
  public function indexAction()
  {
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('blog_admin_main', array(), 'blog_admin_main_addthis');
    $this->view->form  = $form = new Blog_Form_Admin_Addthis();
    if( $this->getRequest()->isPost() && $form->isValid($this->_getAllParams()) )
    {
      $values = $form->getValues();
      foreach ($values as $key => $value){
          Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
      }
    
      $form->addNotice('Your changes have been saved.');
    }   
  }
}
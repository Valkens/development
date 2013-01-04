<?php

class Blog_Widget_MenuBlogsController extends Engine_Content_Widget_Abstract
{
   protected $_navigation;
  public function indexAction()
  {
      $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('blog_main');

    // Get quick navigation
    $this->view->quickNavigation = $quickNavigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('blog_quick');
  }
}
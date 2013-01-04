<?php

class Book_Widget_MenuBooksController extends Engine_Content_Widget_Abstract
{
    public function indexAction()
    {
        $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
                                                 ->getNavigation('book_main');

    }
}
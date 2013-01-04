<?php
class Book_Widget_AllBooksController extends Engine_Content_Widget_Abstract
{
    public function indexAction()
    {
        $subject = Engine_Api::_()->getItem('book_param', 1);
        $values = array();

        $values['page'] = $subject->page;
        $values['order_by'] = 'book_id DESC';

        // Get paginator
        $this->view->paginator = Engine_Api::_()->book()->getBooksPaginator($values);
    }
}
<?php

class Book_Widget_DetailBooksController extends Engine_Content_Widget_Abstract
{
    public function indexAction()
    {
        // Check permissions
        $viewer = Engine_Api::_()->user()->getViewer();

        $subject = Engine_Api::_()->getItem('book_param', 1);
        $book = Engine_Api::_()->getItem('book', $subject->book_id);

        if ($book) {
            Engine_Api::_()->core()->setSubject($book);
            $book->view_count++;
            $book->save();

            $this->view->owner = $book->getOwner();
        }

        $this->view->viewer = $viewer;
        $this->view->book = $book;
    }
}
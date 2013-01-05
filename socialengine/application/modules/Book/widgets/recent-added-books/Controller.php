<?php
class Book_Widget_RecentAddedBooksController extends Engine_Content_Widget_Abstract
{
    public function indexAction()
    {
        $table = Engine_Api::_()->getItemTable('book');
        if ($this->_getParam('max') != ''  && $this->_getParam('max') >= 0) {
            $limitMVbook = $this->_getParam('max');
        } else {
            $limitMVbook = 4;
        }

        $select = $table->select()->order('book_id DESC')->limit($limitMVbook);

        $this->view->books = $table->fetchAll($select);
        $this->view->limit = $limitMVbook;
    }
}
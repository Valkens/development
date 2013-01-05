<?php
class Book_Widget_BestSellBooksController extends Engine_Content_Widget_Abstract
{
    public function indexAction()
    {
        $table = Engine_Api::_()->getDbTable('orderdetails', 'book');
        if ($this->_getParam('max') != ''  && $this->_getParam('max') >= 0) {
            $limitBSbook = $this->_getParam('max');
        } else {
            $limitBSbook = 4;
        }

        $select = $table->select()
                        ->from($table, array('book_id'))
                        ->group('book_id')
                        ->order('SUM(quantity) DESC')
                        ->limit($limitBSbook);

        $ids = $table->fetchAll($select)->toArray();

        if ($ids) {
            $table = Engine_Api::_()->getItemTable('book');
            foreach ($ids as $id) {
                $arrId[] = $id['book_id'];
            }
            $strIds = implode(',', $arrId);

            $select = $table->select()
                            ->where("book_id IN (?)", $ids)
                            ->order('FIELD(book_id, '.$strIds.')');

            $this->view->books = $table->fetchAll($select);
            $this->view->limit = $limitBSbook;
        }
    }
}
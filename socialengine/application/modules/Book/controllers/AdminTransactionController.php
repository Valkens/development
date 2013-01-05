<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Book
 * @copyright  Copyright 2012 Younet Developments
 * @license    http://www.socialengine.net/license/
 * @version    $Id: AdminLevelController.php SE-1488 duclh $
 * @author     duclh
 */

/**
 * @category   Application_Extensions
 * @package    Book
 * @copyright  Copyright 2012 Younet Developments
 * @license    http://www.socialengine.net/license/
 */
class Book_AdminTransactionController extends Core_Controller_Action_Admin
{
    public function indexAction()
    {
        $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
                                                 ->getNavigation('book_admin_main', array(), 'book_admin_main_transaction');

        $page = $this->_getParam('page',1);

        $table = Engine_Api::_()->getDbtable('orders', 'book');

        $this->view->paginator = Zend_Paginator::factory($table->select());
        $this->view->paginator->setItemCountPerPage(10);
        $this->view->paginator->setCurrentPageNumber($page);
    }

    public function viewAction()
    {
        if( !$this->_helper->requireUser()->isValid() ) return;

        $table = Engine_Api::_()->getDbtable('orderdetails', 'book');
        $odName = $table->info('name');
        $bName = Engine_Api::_()->getDbtable('books', 'book')->info('name');

        $orderId = $this->_getParam('id');

        $select = $table->select()
            ->setIntegrityCheck(false)
            ->from($odName, array($odName . '.book_id', $odName . '.quantity', $bName . '.title', $bName . '.price'))
            ->joinLeft($bName, "$odName.book_id = $bName.book_id")
            ->where("$odName.order_id = ?", $orderId);

        $this->view->orders = $table->fetchAll($select);

        // Output
        $this->renderScript('admin-transaction/view.tpl');
    }

}
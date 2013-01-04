<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Book
 * @copyright  Copyright 2012 Younet Developments
 * @license    http://www.socialengine.net/license/
 * @version    $Id: IndexController.php SE-1488 duclh $
 * @author     duclh
 */

/**
 * @category   Application_Extensions
 * @package    Book
 * @copyright  Copyright 2012 Younet Developments
 * @license    http://www.socialengine.net/license/
 */
class Book_IndexController extends Core_Controller_Action_Standard
{
    /**
     * List books
     *
     */
    public function indexAction()
    {
        if ($this->_getParam('page') != '') {
            $subject = Engine_Api::_()->getItem('book_param', 1);
            $subject->page = $this->_getParam('page');
            $subject->save();
        }

        $this->_helper->content
             ->setNoRender()
             ->setEnabled();
    }

    /**
     * Add new book
     *
     */
    public function addAction()
    {
        // Check valid user & permission
        if (!$this->_helper->requireUser()->isValid()) return;
        if( !$this->_helper->requireAuth()->setAuthParams('book', null, 'create')->isValid()) return;

        // Get book main navigation
        $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
                                                 ->getNavigation('book_main');
        // Prepare form
        $this->view->form = $form = new Book_Form_Add();
        $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();

        $table = Engine_Api::_()->getItemTable('book');

        // If not post or form not valid, return
        if (!$this->getRequest()->isPost()) return;
        if (!$form->isValid($this->getRequest()->getPost())) return;

        // Process form
        $table = Engine_Api::_()->getItemTable('book');
        $db    = $table->getAdapter();
        $db->beginTransaction();

        try
        {
            $data   = array_merge($form->getValues(), array(
                'posted_by'  => $viewer->getIdentity(),
                'owner_type' => $viewer->getType(),
                'owner_id'   => $viewer->getIdentity(),
            ));


            $book = $table->createRow();
            $book->setFromArray($data);
            $book->posted_date = date('Y-m-d H:i:s');
            $book->save();

            if ($form->getValue('image')) {
                $book->setImage($form->image);
            }

            // Auth
            $auth = Engine_Api::_()->authorization()->context;
            $roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'everyone');

            if( empty($data['auth_comment']) ) {
                $data['auth_comment'] = 'everyone';
            }

            $commentMax = array_search($data['auth_comment'], $roles);

            foreach( $roles as $i => $role ) {
                $auth->setAllowed($book, $role, 'comment', ($i <= $commentMax));
            }

            // Add activity
            $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $book, 'book_new');
            // Make sure action exists before attaching the book to the activity
            if ($action) {
                Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $book);
            }


            // Db commit
            $db->commit();
        }
        catch (Exception $e)
        {
            $db->rollBack();
            throw $e;
        }

        return $this->_helper->redirector->gotoRoute(array('action' => 'manage'));
    }

    /**
     * List user own book
     *
     */
    public function manageAction()
    {
        if (!$this->_helper->requireUser()->isValid()) return;

        // Get book main navigation
        $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
                                                 ->getNavigation('book_main');

        // Prepare data
        $viewer = Engine_Api::_()->user()->getViewer();
        $values['user_id'] = $viewer->getIdentity();
        $values['page'] = (int) $this->_getParam('page', 1);

        // Get paginator
        $this->view->paginator = $paginator = Engine_Api::_()->book()->getBooksPaginator($values);
    }

    /**
     * View a book
     *
     */
    public function viewAction()
    {
        if ($this->_getParam('book_id') != '') {
            $subject = Engine_Api::_()->getItem('book_param', 1);
            $subject->book_id = $this->_getParam('book_id');
            $subject->save();
        }

        if ($this->_request->isPost()) {
            $bookId = (int) $this->_request->getParam('bookid');
            $quantity = (int) $this->_request->getParam('quantity');

            $cartSession = new Zend_Session_Namespace('BookCart');
            if (isset($cartSession->list[$bookId])) {
                $cartSession->list[$bookId]['quantity'] += $quantity;
            } else {
                $cartSession->list[$bookId]['quantity'] = $quantity;
            }

            return $this->_helper->redirector->gotoRoute(array('action' => 'cart'), 'book_general', true);
        }

        $this->_helper->content
             ->setNoRender()
             ->setEnabled();
    }

    /**
     * Edit a book
     *
     */
    public function editAction()
    {
        if( !$this->_helper->requireUser()->isValid() ) return;

        $viewer = Engine_Api::_()->user()->getViewer();
        $book = Engine_Api::_()->getItem('book', $this->_getParam('book_id'));

        if (!Engine_Api::_()->core()->hasSubject('book')) {
            Engine_Api::_()->core()->setSubject($book);
        }

        if( !$this->_helper->requireSubject()->isValid() ) return;
        if( !$this->_helper->requireAuth()->setAuthParams($book, $viewer, 'edit')->isValid() ) return;

        // Get navigation
        $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
                                                               ->getNavigation('book_main');

        // Prepare form
        $this->view->form = $form = new Book_Form_Edit();

        // Populate form
        $form->populate($book->toArray());

        $auth = Engine_Api::_()->authorization()->context;
        $roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'everyone');

        foreach( $roles as $role ) {
            if( $auth->isAllowed($book, $role, 'comment') ) {
                $form->auth_comment->setValue($role);
            }
        }

        // Check post/form
        if( !$this->getRequest()->isPost() ) {
            return;
        }
        if( !$form->isValid($this->getRequest()->getPost()) ) {
            return;
        }


        // Process
        $db = Engine_Db_Table::getDefaultAdapter();
        $db->beginTransaction();

        try
        {
            $values = $form->getValues();

            $book->setFromArray($values);
            $book->save();

            if ($form->getValue('image')) {
                $book->setImage($form->image);
            }

            // Auth
            if( empty($values['auth_comment']) ) {
                $values['auth_comment'] = 'everyone';
            }

            $commentMax = array_search($values['auth_comment'], $roles);

            foreach( $roles as $i => $role ) {
                $auth->setAllowed($book, $role, 'comment', ($i <= $commentMax));
            }

            // Commit
            $db->commit();
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }

        return $this->_helper->redirector->gotoRoute(array('action' => 'manage'), 'book_general', true);
    }

    /**
     * Delete a book
     *
     */
    public function deleteAction()
    {
        // Check permissions
        $viewer = Engine_Api::_()->user()->getViewer();
        $this->view->book = $book = Engine_Api::_()->getItem('book', $this->_getParam('book_id'));

        if( !$this->_helper->requireUser()->isValid() ) return;
        if( !$this->_helper->requireAuth()->setAuthParams($book, $viewer, 'edit')->isValid() ) return;

        // Get navigation
        $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
                                                               ->getNavigation('book_main');

        // Check post/form
        if( !$this->getRequest()->isPost() ) {
            return;
        }

        $table = $book->getTable();
        $db = Engine_Db_Table::getDefaultAdapter();
        $db->beginTransaction();

        try {
            $book->delete();
            $db->commit();
        } catch( Exception $e ) {
            $db->rollBack();
            throw $e;
        }

        return $this->_helper->redirector->gotoRoute(array('action' => 'manage'), 'book_general', true);
    }

    /**
     * View cart
     *
     */
    public function cartAction()
    {
        if( !$this->_helper->requireUser()->isValid() ) return;

        $this->view->headTitle('Your book cart');

        // Get book main navigation
        $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
                                                 ->getNavigation('book_main');

        $cartSession = new Zend_Session_Namespace('BookCart');


        // Check post/form
        if ($this->_request->isPost()) {
            if ($this->_getParam('submit')) {
                switch ($this->_getParam('submit'))
                {
                    case 'clear':
                        $cartSession->unsetAll();
                        $this->view->listBook = null;
                        $this->view->cartSession = null;
                        break;

                    case 'update':
                        foreach (array_keys($cartSession->list) as $id) {
                            $cartSession->list[$id] = $this->_getParam('quantity')[$id];
                        }
                        break;

                    default:
                        return $this->_helper->redirector->gotoRoute(array('action' => 'index'), 'book_general');
                        break;
                }
            } else if ($this->_getParam('delete')) {
                $id = (int) $this->_getParam('delete');
                unset($cartSession->list[$id]);
            }
        }

        if ($cartSession->list) {
            $listIds = array_keys($cartSession->list);
            $bookTable = Engine_Api::_()->getItemTable('book');
            $listBookSelect = $bookTable->select()
                ->where('book_id IN(?)', $listIds);

            $this->view->listBook = $bookTable->fetchAll($listBookSelect);
            $this->view->cartSession = $cartSession;
        }
    }

    /**
     * Checkout
     *
     */
    public function checkoutAction()
    {
        if( !$this->_helper->requireUser()->isValid() ) return;

        $this->view->headTitle('Cart review page');

        // Get book main navigation
        $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('book_main');

        $cartSession = new Zend_Session_Namespace('BookCart');

        if ($cartSession->list) {
            $listIds = array_keys($cartSession->list);
            $bookTable = Engine_Api::_()->getItemTable('book');
            $listBookSelect = $bookTable->select()
                ->where('book_id IN(?)', $listIds);

            $this->view->listBook = $bookTable->fetchAll($listBookSelect);
            $this->view->cartSession = $cartSession;

            // Paypal
            $gatewayTable = Engine_Api::_()->getDbtable('gateways', 'payment');
            $gatewaySelect = $gatewayTable->select()
                                          ->where('title = ?', 'Paypal');
            $gateway = $gatewayTable->fetchRow($gatewaySelect);
            if ($gateway->config) {
                $this->view->gateway = $gateway->config;
            } else {
                throw new Engine_Exception('Please config Paypal gateway');
            }
        }
    }
}

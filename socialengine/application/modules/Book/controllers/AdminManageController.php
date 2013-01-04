<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Book
 * @copyright  Copyright 2012 Younet Developments
 * @license    http://www.socialengine.net/license/
 * @version    $Id: AdminManageController.php SE-1488 duclh $
 * @author     duclh
 */

/**
 * @category   Application_Extensions
 * @package    Book
 * @copyright  Copyright 2012 Younet Developments
 * @license    http://www.socialengine.net/license/
 */
class Book_AdminManageController extends Core_Controller_Action_Admin
{
    /**
     * List all books
     *
     */
    public function indexAction()
    {
        $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
                                                 ->getNavigation('book_admin_main', array(), 'book_admin_main_manage');

        $page = $this->_getParam('page',1);
        $this->view->paginator = Engine_Api::_()->book()->getBooksPaginator();
        $this->view->paginator->setItemCountPerPage(4);
        $this->view->paginator->setCurrentPageNumber($page);
    }

    /**
     * Edit a book
     *
     */
    public function editAction()
    {
        if( !$this->_helper->requireUser()->isValid() ) return;

        $viewer = Engine_Api::_()->user()->getViewer();
        $book = Engine_Api::_()->getItem('book', $this->_getParam('id'));

        if (!Engine_Api::_()->core()->hasSubject('book')) {
            Engine_Api::_()->core()->setSubject($book);
        }

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
        if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
            $this->_forward('success', 'utility', 'core', array(
                'smoothboxClose' => 10,
                'parentRefresh'=> 10,
                'messages' => array('')
            ));

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
        }

        // Output
        $this->renderScript('admin-manage/edit.tpl');
    }

    /**
     * Delete a book
     *
     */
    public function deleteAction()
    {
        // In smoothbox
        $this->_helper->layout->setLayout('admin-simple');
        $id = $this->_getParam('id');
        $this->view->book_id = $id;

        // Check post
        if( $this->getRequest()->isPost() )
        {
            $db = Engine_Db_Table::getDefaultAdapter();
            $db->beginTransaction();

            try
            {
                $book = Engine_Api::_()->getItem('book', $id);
                $book->delete();
                $db->commit();
            }

            catch( Exception $e )
            {
                $db->rollBack();
                throw $e;
            }

            $this->_forward('success', 'utility', 'core', array(
                'smoothboxClose' => 10,
                'parentRefresh'=> 10,
                'messages' => array('')
            ));
        }

        // Output
        $this->renderScript('admin-manage/delete.tpl');
    }

    public function deleteselectedAction()
    {
        $this->view->ids = $ids = $this->_getParam('ids', null);
        $confirm = $this->_getParam('confirm', false);
        $this->view->count = count(explode(",", $ids));

        // Save values
        if( $this->getRequest()->isPost() && $confirm == true )
        {
            $ids_array = explode(",", $ids);
            foreach( $ids_array as $id ){
                $book = Engine_Api::_()->getItem('book', $id);
                if( $book ) $book->delete();
            }

            $this->_helper->redirector->gotoRoute(array('action' => 'index'));
        }

    }
}

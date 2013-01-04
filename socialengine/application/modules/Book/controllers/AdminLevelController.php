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
class Book_AdminLevelController extends Core_Controller_Action_Admin
{
    public function indexAction()
    {
        $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
                                                               ->getNavigation('book_admin_main', array(), 'book_admin_main_level');

        // Get level id
        if( null !== ($id = $this->_getParam('id')) ) {
          $level = Engine_Api::_()->getItem('authorization_level', $id);
        } else {
          $level = Engine_Api::_()->getItemTable('authorization_level')->getDefaultLevel();
        }

        if( !$level instanceof Authorization_Model_Level ) {
          throw new Engine_Exception('missing level');
        }

        $id = $level->level_id;

        // Make form
        $this->view->form = $form = new Book_Form_Admin_Settings_Level(array(
          'public' => ( in_array($level->type, array('public')) ),
          'moderator' => ( in_array($level->type, array('admin', 'moderator')) ),
        ));
        $form->level_id->setValue($id);

        // Populate values
        $permissionsTable = Engine_Api::_()->getDbtable('permissions', 'authorization');
        $form->populate($permissionsTable->getAllowed('book', $id, array_keys($form->getValues())));

        // get max allow
        $mtable  = Engine_Api::_()->getDbtable('permissions', 'authorization');
        $msselect = $mtable->select()
                    ->where("type = 'book'")
                    ->where("level_id = ?",$id)
                    ->where("name = 'max'");
        $mallow = $mtable->fetchRow($msselect);

        if (!empty($mallow)) {
            if (is_null($mallow['params'])) {
                $max = $mallow['value'];
            } else {
                $max = $mallow['params'];
            }
        }

        if($id < 5)
        {
            $max_get = $form->max->getValue();
            if ($max_get < 1)
            $form->max->setValue($max);
        }

        // Check post
        if( !$this->getRequest()->isPost() ) {
          return;
        }

        // Check validitiy
        if( !$form->isValid($this->getRequest()->getPost()) ) {
          return;
        }

        // Process

        $values = $form->getValues();

        $db = $permissionsTable->getAdapter();
        $db->beginTransaction();

        try
        {
          // Set permissions
          $permissionsTable->setAllowed('book', $id, $values);

          // Commit
          $db->commit();
        }

        catch( Exception $e )
        {
          $db->rollBack();
          throw $e;
        }
         $form->addNotice('Your changes have been saved.');
    }

}
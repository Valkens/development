<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Book
 * @copyright  Copyright 2012 Younet Developments
 * @license    http://www.socialengine.net/license/
 * @version    $Id: Core.php SE-1488 duclh $
 * @author     duclh
 */

/**
 * @category   Application_Extensions
 * @package    Book
 * @copyright  Copyright 2012 Younet Developments
 * @license    http://www.socialengine.net/license/
 */
class Book_Api_Core extends Core_Api_Abstract
{
    /**
     * Gets a paginator for books
     *
     * @param Core_Model_Item_Abstract $user The user to get the messages for
     * @return Zend_Paginator
     */
    public function getBooksPaginator($params = array())
    {
        $paginator = Zend_Paginator::factory($this->getBooksSelect($params));
        if( !empty($params['page']) )
        {
            $paginator->setCurrentPageNumber((int) $params['page']);
        }
        if( !empty($params['limit']) )
        {
            $paginator->setItemCountPerPage($params['limit']);
        }

        if( empty($params['limit']) )
        {
            $page = (int) Engine_Api::_()->getApi('settings', 'core')->getSetting('book.page', 3);
            $paginator->setItemCountPerPage($page);
        }

        return $paginator;
    }

    /**
     * Gets a select object for the user's book
     *
     * @param Core_Model_Item_Abstract $user The user to get the messages for
     * @return Zend_Db_Table_Select
     */
    public function getBooksSelect($params = array())
    {
        $table = Engine_Api::_()->getDbtable('books', 'book');
        $rName = $table->info('name');

        $select = $table->select()
                        ->order( !empty($params['orderby']) ? $rName . '.' . $params['orderby'].' DESC' : $rName.'.posted_date DESC' );

        if( !empty($params['user_id']) && is_numeric($params['user_id']) )
        {
            $select->where($rName.'.posted_by = ?', $params['user_id']);
        }

        if( !empty($params['user']) && $params['user'] instanceof User_Model_User )
        {
            $select->where($rName.'.posted_by = ?', $params['user_id']->getIdentity());
        }

        return $select;
    }
}
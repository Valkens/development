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
class Book_Plugin_Core
{
    public function onUserDeleteBefore($event)
    {
        $payload = $event->getPayload();
        if( $payload instanceof User_Model_User ) {
            // Delete books
            $bookTable = Engine_Api::_()->getDbtable('books', 'book');
            $bookSelect = $bookTable->select()->where('owner_id = ?', $payload->getIdentity());
            foreach( $bookTable->fetchAll($bookSelect) as $book ) {
                $book->delete();
            }
        }
    }
}
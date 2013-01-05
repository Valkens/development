<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Book
 * @copyright  Copyright 2012 Younet Developments
 * @license    http://www.socialengine.net/license/
 * @version    $Id: Edit.php SE-1488 duclh $
 * @author     duclh
 */

/**
 * @category   Application_Extensions
 * @package    Book
 * @copyright  Copyright 2012 Younet Developments
 * @license    http://www.socialengine.net/license/
 */

class Book_Form_Edit extends Book_Form_Add
{
    public function init()
    {
        parent::init();
        $this->setTitle('Edit Book')
             ->setDescription('Edit your book below, then click "Save book" to publish your changes.');
        $this->submit->setLabel('Save Changes');
    }
}
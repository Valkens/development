<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Book
 * @copyright  Copyright 2012 Younet Developments
 * @license    http://www.socialengine.net/license/
 * @version    $Id: Book.php SE-1488 duclh $
 * @author     duclh
 */

/**
 * @category   Application_Extensions
 * @package    Book
 * @copyright  Copyright 2012 Younet Developments
 * @license    http://www.socialengine.net/license/
 */
class Book_Model_Book extends Core_Model_Item_Abstract
{
    protected $_parent_type = 'user';
    protected $_parent_is_owner = true;

    /**
     * Set book image
     *
     */
    public function setImage($image)
    {
        if ($image instanceof Zend_Form_Element_File) {
            $file = $image->getFileName();
            $fileName = $file;
        } elseif ($image instanceof Storage_Model_File) {
            $file = $image->temporary();
            $fileName = $image->name;
        } elseif ($image instanceof Core_Model_Item_Abstract && !empty($image->file_id)) {
            $tmpRow = Engine_Api::_()->getItem('storage_file', $image->file_id);
        } elseif (is_array($image) && !empty($image['tmp_name'])) {
            $file = $image['tmp_name'];
            $fileName = $file['name'];
        } elseif (is_string($image) && file_exists($image)) {
            $file = $image;
            $fileName = $image;
        } else {
            throw new Engine_Exception('Invalid argument passed to setImage: ' . print_r($image, 1));
        }

        if (!$fileName) {
            $fileName = $file;
        }

        // Trailing name
        $name = basename($file);
        $extension = ltrim(strrchr(basename($fileName), '.'), '.');
        $base = rtrim(substr(basename($fileName), 0, strrpos(basename($fileName), '.')), '.');
        $path = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary';

        $params = array(
            'parent_type' => 'book',
            'parent_id'   => $this->getIdentity(),
            'name'        => $name
        );

        // Save image
        $filesTable = Engine_Api::_()->getDbTable('files', 'storage');

        // Resize image (main)
        $mainPath = $path . DIRECTORY_SEPARATOR . $base . '_m.' . $extension;
        $imageFile = Engine_Image::factory();
        $imageFile->open($file)
                  ->resize(720, 720)
                  ->write($mainPath)
                  ->destroy();

        // Resize image (profile)
        $profilePath = $path . DIRECTORY_SEPARATOR . $base . '_p.' . $extension;
        $imageFile = Engine_Image::factory();
        $imageFile->open($file)
                  ->resize(200, 400)
                  ->write($profilePath)
                  ->destroy();

        // Resize image (normal)
        $normalPath = $path . DIRECTORY_SEPARATOR . $base . '_in.' . $extension;
        $imageFile = Engine_Image::factory();
        $imageFile->open($file)
                  ->resize(140, 160)
                  ->write($normalPath)
                  ->destroy();

        // Resize image (icon)
        $squarePath = $path . DIRECTORY_SEPARATOR . $base . '_is.' . $extension;
        $imageFile = Engine_Image::factory();
        $imageFile->open($file);

        $size = min($imageFile->height, $imageFile->width);
        $x = ($imageFile->width - $size) / 2;
        $y = ($imageFile->height - $size) / 2;

        $imageFile->resample($x, $y, $size, $size, 48, 48)
                  ->write($squarePath)
                  ->destroy();

        // Store
        $iMain = $filesTable->createFile($mainPath, $params);
        $iProfile = $filesTable->createFile($profilePath, $params);
        $iIconNormal = $filesTable->createFile($normalPath, $params);
        $iSquare = $filesTable->createFile($squarePath, $params);

        $iMain->bridge($iProfile, 'thumb.profile');
        $iMain->bridge($iIconNormal, 'thumb.normal');
        $iMain->bridge($iSquare, 'thumb.icon');

        // Remove temp files
        @unlink($mainPath);
        @unlink($profilePath);
        @unlink($normalPath);
        @unlink($squarePath);

        // Update row
        $this->photo_id = $iMain->file_id;
        $this->save();

        return $this;
    }

    /**
     * Gets an absolute URL to the page to view this book
     *
     * @return string
     */
    public function getHref($params = array())
    {
        $params = array_merge(array(
            'route' => 'book_specific',
            'reset' => true,
            'book_id' => $this->book_id,
        ), $params);
        $route = $params['route'];
        $reset = $params['reset'];
        unset($params['route']);
        unset($params['reset']);
        return Zend_Controller_Front::getInstance()->getRouter()
                                                   ->assemble($params, $route, $reset);
    }

    /**
     * Gets a proxy object for the comment handler
     *
     * @return Engine_ProxyObject
     **/
    public function comments()
    {
        return new Engine_ProxyObject($this, Engine_Api::_()->getDbtable('comments', 'core'));
    }


    /**
     * Gets a proxy object for the like handler
     *
     * @return Engine_ProxyObject
     **/
    public function likes()
    {
        return new Engine_ProxyObject($this, Engine_Api::_()->getDbtable('likes', 'core'));
    }

    /**
     * Get count of books
     *
     * @param $user
     * @return int
     */
    public function getCountBook($user)
    {
        $b_table  = Engine_Api::_()->getDbTable('books', 'book');
        $b_name   = $b_table->info('name');

        $select   = $b_table->select()
            ->from($b_table)
            ->where('owner_id = ?', $user->getIdentity());
        return count($b_table->fetchAll($select));
    }
}
<?php
class Base_Controller_AdminController extends Core_Controller
{
    protected $_cache = null;
    protected $_session = null;

    public function init()
    {
        // Cache
        $frontEnd = array(
            'lifetime' => null,
            'automatic_serialization' => 'true'
        );
        $backEnd = array(
            'cache_dir' => CACHE_PATH . '/db'
        );

        $this->_cache['db'] = Zend_Cache::factory('Core', 'File', $frontEnd, $backEnd);

        // Set data
        $this->view->adminUrl = BASE_URL . '/admin';
        $this->view->baseUrl  = BASE_URL;

        $this->view->setTheme('admin');

        if (!User_Helper_Auth::hasIdentity()) {
            $this->setTemplate('module/user/admin/login');
        } else {
            // Set session
            $this->_session = Core_Session::getInstance();
            $this->view->username = $this->_session->get('username', 'auth');
        }
    }
}
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
        $this->_data['adminUrl'] = BASE_URL . '/admin';
        $this->_data['baseUrl']  = BASE_URL;

        $this->_view->setTheme('admin');

        if (!User_Helper_Auth::hasIdentity()) {
            $this->renderFile('module/user/admin/login');
        } else {
            // Set session
            $this->_session = Core_Session::getInstance();
            $this->_data['username'] = $this->_session->get('username', 'auth');
        }
    }
}
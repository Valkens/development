<?php
class Base_Controller_AdminController extends Core_Controller
{
    protected $_cache;

    public function __construct($options, $params = array())
    {
        parent::__construct($options, $params);

        // Cache
        $dbCache = array(
            'frontend' => array(
                'name' => 'Core',
                'options' => array(
                    'lifetime' => null,
                    'automatic_serialization' => 'true',
                )
            ),
            'backend' => array(
                'name' => 'File',
                'options' => array(
                    'cache_dir' => CACHE_PATH . '/db',
                ),
            )
        );

        $this->_cache['db'] = Zend_Cache::factory($dbCache['frontend']['name'], $dbCache['backend']['name'],
            $dbCache['frontend']['options'], $dbCache['backend']['options']);

        // Set session
        $this->_session = Core_Session::getInstance();

        // Set data
        $this->_data['adminUrl'] = BASE_URL . '/admin';
        $this->_data['baseUrl']  = BASE_URL;

        $this->_view->setTheme('admin');
    }

    public function init()
    {
        if (!$this->isPost() && !$this->isAjax() && !$this->_session->get('username')) {
            $this->_noRender = true;
            $this->forward(array('module' => 'User', 'controller' => 'Admin', 'action' => 'login'));
        }
    }
}
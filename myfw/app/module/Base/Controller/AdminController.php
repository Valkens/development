<?php
class Base_Controller_AdminController extends Core_Controller
{
    protected $_cache;

    public function init()
    {
        if (!file_exists(CACHE_PATH . '/db')) mkdir(CACHE_PATH . '/db', 777);
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

        // Set data
        $this->_data['adminUrl'] = BASE_URL . '/admin';
        $this->_data['baseUrl']  = BASE_URL;

        $this->_view->setTheme('admin');
    }
}
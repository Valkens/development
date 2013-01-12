<?php
class Base_Controller_AdminController extends Core_Controller
{
    protected $_cache;

    public function init()
    {
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
                    'cache_dir'=> CACHE_PATH . '/db',
                ),
            )
        );

        $this->_cache['db'] = Zend_Cache::factory($dbCache['frontend']['name'], $dbCache['backend']['name'],
                                                  $dbCache['frontend']['options'], $dbCache['backend']['options']);

        // Set data
        $this->_data['adminUrl'] = BASE_URL . '/admin';

        $this->_view->setTheme('admin');
    }
}
<?php
class Default_Controller_IndexController extends Core_Controller
{
    public function indexAction()
    {
        // Db
        $db = Core_Resource_Manager::getResource('db');

        $user = new Default_Model_User;
        $user->setDefaultAdapter('sqlite');
        $this->_data['users'] = $user->find(array('limit' => 100));
    }
}
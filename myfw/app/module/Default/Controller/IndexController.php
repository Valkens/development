<?php
class Default_Controller_IndexController extends Core_Controller
{
    public function indexAction()
    {
        $user = new Default_Model_User;
        $user->setDefaultAdapter('sqlite');

        $this->_data['pageTitle'] = '43543543543';
        $this->_data['users'] = $user->find(array('limit' => 100));
    }
}
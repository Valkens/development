<?php
class Default_Controller_IndexController extends Core_Controller
{
    public function indexAction()
    {
        $this->_data['pageTitle'] = 'Home page';
    }
}
<?php
class Default_Controller_IndexController extends Base_Controller_DefaultController
{
    public function indexAction()
    {
        $this->_data['pageTitle'] = 'Home page';
    }
}
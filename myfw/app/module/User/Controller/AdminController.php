<?php
class User_Controller_AdminController extends Base_Controller_AdminController
{
    public function indexAction()
    {
        $this->view->pageTitle = 'Dashboard';
    }

}
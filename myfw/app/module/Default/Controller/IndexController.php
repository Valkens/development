<?php
class Default_Controller_IndexController extends Base_Controller_DefaultController
{
    public function indexAction()
    {
        $this->view->pageTitle = 'Home page';
    }
}
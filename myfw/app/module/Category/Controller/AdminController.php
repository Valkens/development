<?php
class Category_Controller_AdminController extends Core_AdminController
{
    public function indexAction()
    {
        $this->_data['pageTitle'] = 'List Category';
    }

    public function addAction()
    {
        $this->_data['pageTitle'] = 'Add New Category';
    }
}
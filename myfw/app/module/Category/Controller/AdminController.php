<?php
class Category_Controller_AdminController extends Base_Controller_AdminController
{
    public function indexAction()
    {
        $this->_data['pageTitle'] = 'List Category';
    }

    public function addAction()
    {
        $this->_data['pageTitle'] = 'Add New Category';

        if ($this->isPost()) {
            if ($this->_params['parent'] < 1) {
                $this->_data['errors']['parent'] = 'Please choose category\'s parent';
            }
            if (!trim($this->_params['name'])) {
                $this->_data['errors']['name'] = 'Please enter category\'s name';
            }
            if (!trim($this->_params['slug'])) {
                $this->_data['errors']['slug'] = 'Please enter category\'s slug';
            }

            if (!isset($this->_data['errors'])) {
                $categoryModel = new Category_Model_Category();
                $categoryModel->id_parent = (int) $this->_params['parent'];
                $categoryModel->name = trim($this->_params['name']);
                $categoryModel->slug = trim($this->_params['slug']);
                if (trim($this->_params['description'])) {
                    $categoryModel->description = trim($this->_params['description']);
                }
                $categoryModel->insert();

                // Write cache
                $db = $categoryModel->db();
                $this->_cache['db']->save($categoryModel->find(), 'db_categories');
            }
        }
    }
}
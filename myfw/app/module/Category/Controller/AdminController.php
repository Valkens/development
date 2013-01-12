<?php
class Category_Controller_AdminController extends Base_Controller_AdminController
{
    public function indexAction()
    {
        $this->_data['pageTitle'] = 'List Category';

        $categories = array();
        if (!$categories = $this->_cache['db']->load('db_categories')) {
            $categoryModel = new Category_Model_Category();
            $categories = $categoryModel->find();
        }
        $this->_data['categories'] = $categories;
    }

    public function addAction()
    {
        $this->_data['pageTitle'] = 'Add New Category';

        if (!$categories = $this->_cache['db']->load('db_categories')) {
            $categoryModel = new Category_Model_Category();
            $categories = $categoryModel->find();
        }
        $this->_data['categories'] = $categories;

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

    public function editAction()
    {
        $this->_data['pageTitle'] = 'Edit Category';

        $categoryId = (int) $this->_params['id'];

        if (!$categories = $this->_cache['db']->load('db_categories')) {
            $categoryModel = new Category_Model_Category();
            $categories = $categoryModel->find();

            $this->_data['category'] = $categoryModel->find(array('id' => $categoryId, 'limit' => 1));
        }
        $this->_data['categories'] = $categories;


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
                $categoryModel->id = $categoryId;
                $categoryModel->id_parent = (int) $this->_params['parent'];
                $categoryModel->name = trim($this->_params['name']);
                $categoryModel->slug = trim($this->_params['slug']);
                if (trim($this->_params['description'])) {
                    $categoryModel->description = trim($this->_params['description']);
                }
                $categoryModel->update();

                // Write cache
                $db = $categoryModel->db();
                $this->_cache['db']->save($categoryModel->find(), 'db_categories');
            }
        }
    }
}
<?php
class Category_Controller_AdminController extends Base_Controller_AdminController
{
    public function init()
    {
        parent::init();

        // Write cache
        if (!$categories = $this->_cache['db']->load('db_categories')) {
            $categoryModel = new Category_Model_Category();
            $sql = "SELECT * FROM {$categoryModel->table} ORDER BY sort DESC";
            if ($categories = $categoryModel->fetch($sql)) {
                $this->_cache['db']->save($categories, 'db_categories');
            }
        }

        $this->_data['categories'] = $categories;
    }

    public function indexAction()
    {
        $this->_data['pageTitle'] = 'List Category';

        if ($this->_data['categories']) {
            $categories = array_filter($this->_data['categories'], create_function('$obj', 'return $obj->id_parent == 0;'));
            foreach ($categories as $category) {
                $category->childs = array_filter($this->_data['categories'],
                                                 create_function('$obj','return $obj->id_parent == '.$category->id.';'));
            }

            $this->_data['categories'] = $categories;
        }
    }

    public function addAction()
    {
        $this->_data['pageTitle'] = 'Add New Category';

        if ($this->_data['categories']) {
            $this->_data['categories'] = array_filter($this->_cache['db']->load('db_categories'),
                                                      create_function('$obj', 'return $obj->id_parent == 0;'));
        }

        if ($this->isPost()) {
            $categoryModel = new Category_Model_Category();
            $categoryModel->id_parent = (int) $this->_params['parent'];
            $categoryModel->name = trim($this->_params['name']);
            $categoryModel->slug = trim($this->_params['slug']);
            $categoryModel->sort = (int) $this->_params['sort'];
            if (trim($this->_params['meta_description'])) {
                $categoryModel->meta_description = trim($this->_params['meta_description']);
            }
            $categoryModel->save();

            // Write cache
            $sql = "SELECT * FROM {$categoryModel->table} ORDER BY sort DESC";
            $this->_cache['db']->save($categoryModel->fetch($sql), 'db_categories');

            $this->redirect(array('name' => 'route_admin_category'));
        }
    }

    public function editAction()
    {
        $this->_data['pageTitle'] = 'Edit Category';

        $categoryId = (int) $this->_params['id'];

        $categoryModel = new Category_Model_Category();
        $categoryModel->id = $categoryId;

        $sql = "SELECT * FROM {$categoryModel->table} ORDER BY sort DESC LIMIT 1";
        $this->_data['category'] = $categoryModel->fetch($sql, 'one');

        if ($this->_data['categories']) {
            $this->_data['categories'] = array_filter($this->_cache['db']->load('db_categories'),
                                                      create_function('$obj', 'return $obj->id_parent == 0;'));
        }

        if ($this->isPost()) {
            $categoryModel->id = $categoryId;
            $categoryModel->id_parent = (int) $this->_params['parent'];
            $categoryModel->name = trim($this->_params['name']);
            $categoryModel->slug = trim($this->_params['slug']);
            $categoryModel->sort = (int) $this->_params['sort'];
            if (trim($this->_params['meta_description'])) {
                $categoryModel->meta_description = trim($this->_params['meta_description']);
            }
            $categoryModel->update();

            // Write cache
            $sql = "SELECT * FROM {$categoryModel->table} ORDER BY sort DESC";
            $this->_cache['db']->save($categoryModel->fetch($sql), 'db_categories');

            $this->redirect(array('name' => 'route_admin_category'));
        }
    }

}
<?php
class Category_Controller_AdminController extends Base_Controller_AdminController
{
    public function init()
    {
        parent::init();

        // Write cache
        if (!$categories = $this->_cache['db']->load('db_categories')) {
            $categoryModel = new Category_Model_Category();
            if ($categories = $categoryModel->fetchAll('*', 'ORDER BY sort ASC')) {
                $this->_cache['db']->save($categories, 'db_categories');
            }
        }

        $this->_data['categories'] = $categories;
    }

    public function indexAction()
    {
        if ($this->_data['categories']) {
            $categories = array_filter($this->_data['categories'], create_function('$obj', 'return $obj->id_parent == 0;'));
            foreach ($categories as $category) {
                $category->childs = array_filter($this->_data['categories'],
                                                 create_function('$obj','return $obj->id_parent == '.$category->id.';'));
            }

            $this->_data['pageTitle'] = 'List Category';
            $this->_data['categories'] = $categories;
        }
    }

    public function addAction()
    {
        $params = $this->_request['params'];
        
        if ($this->_data['categories']) {
            $this->_data['categories'] = array_filter($this->_cache['db']->load('db_categories'),
                                                      create_function('$obj', 'return $obj->id_parent == 0;'));
        }

        if ($this->isPost()) {
            // Save category
            $categoryModel = new Category_Model_Category();
            $categoryModel->id_parent = (int) $params['parent'];
            $categoryModel->name = trim($params['name']);
            $categoryModel->slug = trim($params['slug']);
            $categoryModel->sort = (int) $params['sort'];
            if (trim($params['meta_description'])) {
                $categoryModel->meta_description = trim($params['meta_description']);
            }
            $categoryModel->beginTransaction();
            try {
                $categoryModel->save();
                $categoryModel->commit();
            } catch (Exception $e) {
                $categoryModel->rollBack();
                throw $e;
            }

            // Write cache
            $this->_cache['db']->save($categoryModel->fetchAll('*', ' ORDER BY sort ASC'), 'db_categories');

            $this->redirect(array('route' => 'route_admin_category'));
        }

        $this->_data['pageTitle'] = 'Add New Category';
    }

    public function editAction()
    {
        $params = $this->_request['params'];
        $categoryId = (int) $params['id'];

        $categoryModel = new Category_Model_Category();
        $this->_data['category'] = $categoryModel->fetch('*', 'WHERE id=:id LIMIT 1', array(':id'=>$categoryId));

        if ($this->_data['categories']) {
            $this->_data['categories'] = array_filter($this->_cache['db']->load('db_categories'),
                                                      create_function('$obj', 'return $obj->id_parent == 0;'));
        }

        if ($this->isPost()) {
            // Update category
            $categoryModel->id = $categoryId;
            $categoryModel->id_parent = (int) $params['parent'];
            $categoryModel->name = trim($params['name']);
            $categoryModel->slug = trim($params['slug']);
            $categoryModel->sort = (int) $params['sort'];
            $categoryModel->meta_description = trim($params['meta_description']);
            $categoryModel->beginTransaction();
            try {
                $categoryModel->update();
                $categoryModel->commit();
            } catch (Exception $e) {
                $categoryModel->rollBack();
                throw new Exception($e->getMessage(), $e->getCode());
            }

            // Write cache
            $this->_cache['db']->save($categoryModel->fetchAll('*', 'ORDER BY sort ASC'), 'db_categories');

            $this->redirect(array('route' => 'route_admin_category'));
        }

        $this->_data['pageTitle'] = 'Edit Category';
    }

}
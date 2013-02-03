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

        if ($categories) {
            $this->_data['categories'] = $categories;
            $this->_data['parentCategories'] = array_filter($categories, create_function('$obj', 'return $obj->id_parent == 0;'));
        }
    }

    public function indexAction()
    {
        if ($this->_data['categories']) {
            foreach ($this->_data['parentCategories'] as $category) {
                $category->childs = array_filter($this->_data['categories'],
                                                 create_function('$obj','return $obj->id_parent == '. $category->id . ';'));
            }
        }
    }

    public function addAction()
    {
        $params = $this->_request['params'];

        if ($this->isPost()) {
            $categoryModel = new Category_Model_Category();
            $categoryModel->initialize($params);
            $categoryModel->save();

            // Write cache
            $this->_cache['db']->save($categoryModel->fetchAll('*', ' ORDER BY sort ASC'), 'db_categories');

            $this->redirect(array('route' => 'route_admin_category'));
        }
    }

    public function editAction()
    {
        $params = $this->_request['params'];
        $this->_data['category'] = null;

        if ($this->_data['categories']) {
            $arr = array_filter($this->_data['categories'],
                                create_function('$obj', 'return $obj->id == ' . (int) $params['id'] . ';'));
            $this->_data['category'] = array_shift($arr);

            if ($this->isPost()) {
                $categoryModel = new Category_Model_Category();
                $categoryModel->initialize($params);
                $categoryModel->update();

                // Write cache
                $this->_cache['db']->save($categoryModel->fetchAll('*', 'ORDER BY sort ASC'), 'db_categories');

                $this->redirect(array('route' => 'route_admin_category'));
            }
        }
    }

}
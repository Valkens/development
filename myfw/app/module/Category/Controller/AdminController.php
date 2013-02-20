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
            $this->view->categories = $categories;
            $this->view->parentCategories = array_filter($categories, create_function('$obj', 'return $obj->id_parent == 0;'));
        }
    }

    public function indexAction()
    {
        if ($this->view->categories) {
            foreach ($this->view->parentCategories as $category) {
                $category->childs = array_filter($this->view->categories,
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
            $this->_writeCache($categoryModel);

            $this->redirect(array('route' => 'route_admin_category'));
        }
    }

    public function editAction()
    {
        $params = $this->_request['params'];

        if ($this->view->categories) {
            $arr = array_filter($this->view->categories,
                                create_function('$obj', 'return $obj->id == ' . (int) $params['id'] . ';'));
            $this->view->category = array_shift($arr);

            if ($this->isPost()) {
                $categoryModel = new Category_Model_Category();
                $categoryModel->initialize($params);
                $categoryModel->update();

                // Write cache
                $this->_writeCache($categoryModel);

                $this->redirect(array('route' => 'route_admin_category'));
            }
        }
    }

    public function deleteAction()
    {
        if ($this->isAjax() && $this->isPost()) {
            $this->_noRender = true;
            $params = $this->_request['params'];


            $postModel = new Post_Model_Post();
            $db = $postModel->db();

            if ($postModel->fetch('id', 'WHERE id_category = :id_category OR id_subcategory = :id_subcategory',
                                 array(':id_category' => $params['id'], ':id_subcategory' => $params['id']))
            ) {
                echo json_encode(array('success' => true, 'redirect' => false, 'msg' => 'This category is associated with some posts'));
            } else {
                $categoryModel = new Category_Model_Category();
                $subCategories = array_filter($this->view->categories,
                    create_function('$obj', 'return $obj->id_parent == ' . (int) $params['id'] . ';'));

                // Update parent of subcategories
                if ($subCategories) {
                    foreach ($subCategories as $category) {
                        $categoryModel->id = $category->id;
                        $categoryModel->id_parent = 0;
                        $categoryModel->update();
                    }
                }
                $categoryModel->delete('WHERE id = :id', array(':id' => $params['id']));

                echo json_encode(array('success' => true, 'redirect' => true, 'href' => $this->_router->generate('route_admin_category')));
            }
        }
    }

    protected function _writeCache($categoryModel)
    {
        $this->_cache['db']->save($categoryModel->fetchAll('*', 'ORDER BY sort ASC'), 'db_categories');
    }

}
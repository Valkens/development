<?php
class Category_Controller_AdminController extends Base_Controller_AdminController
{
    protected $categoryModel;

    public function init()
    {
        parent::init();

        // Get all categories
        $this->categoryModel = Core_Model::factory('Category_Model_Category');
        $this->view->categories = $categories = $this->categoryModel->find_many();
        $this->view->parentCategories = array_filter($categories, create_function('$obj', 'return $obj->id_parent == 0;'));
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
            $category = $this->categoryModel->create();
            $category->initialize($params);
            $category->save();

            // Write cache
            $this->_writeCache();

            $this->redirect(array('route' => 'route_admin_category'));
        }
    }

    public function editAction()
    {
        $params = $this->_request['params'];
        $this->view->category = $category = $this->categoryModel->find_one($params['id']);

        if ($this->isPost()) {
            $category->initialize($params);
            $category->save();

            // Write cache
            $this->_writeCache();

            $this->redirect(array('route' => 'route_admin_category'));
        }
    }

    public function deleteAction()
    {
        if ($this->isAjax() && $this->isPost()) {
            $this->_noRender = true;
            $params = $this->_request['params'];

            $postModel = Core_Model::factory('Post_Model_Post');

            if ($postModel->where_raw('(`id_category` = ? OR `id_subcategory` = ?)',
                                      array($params['id'], $params['id']))->find_one()
            ) {
                echo json_encode(array('success' => true, 'redirect' => false, 'msg' => 'This category is associated with some posts'));
            } else {
                $subCategories = array_filter($this->view->categories, create_function('$obj', 'return $obj->id_parent == ' . (int) $params['id'] . ';'));

                // Update parent of subcategories
                if ($subCategories) {
                    foreach ($subCategories as $category) {
                        $category->id_parent = 0;
                        $category->save();
                    }
                }

                $this->categoryModel->find_one($params['id'])->delete();

                echo json_encode(array('success' => true, 'redirect' => true, 'href' => $this->_router->generate('route_admin_category')));
            }
        }
    }

    protected function _writeCache()
    {
        $this->_cache['db']->save($this->categoryModel->find_many(), 'db_categories');
    }

}
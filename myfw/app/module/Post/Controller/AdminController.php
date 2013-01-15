<?php
class Post_Controller_AdminController extends Base_Controller_AdminController
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
        $this->_data['pageTitle'] = 'List Post';

        $posts = array();
        $cates = array();

        if ($this->_data['categories']) {
            foreach ($this->_data['categories'] as $category) {
                $cates[$category->id] = $category->name;
            }

            $postModel = new Post_Model_Post();
            $posts = $postModel->fetchAll('*', 'ORDER BY id DESC LIMIT 0,10');

            foreach ($posts as $post) {
                $post->categoryName = $cates[$post->id_category];
            }
        }

        $this->_data['posts'] = $posts;
    }

    public function addAction()
    {
        $this->_data['pageTitle'] = 'Add New Post';


    }
}
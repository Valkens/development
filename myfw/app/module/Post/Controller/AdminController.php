<?php
class Post_Controller_AdminController extends Base_Controller_AdminController
{
    public function indexAction()
    {
        $this->_data['pageTitle'] = 'List Post';

        $posts = array();
        $cates = array();

        if ($categories = $this->_cache['db']->load('db_categories')) {
            foreach ($categories as $category) {
                $cates[$category->id] = $category->name;
            }

            $postModel = new Post_Model_Post();
            $sql = "SELECT * FROM {$postModel->table} ORDER BY id DESC";
            $posts = $postModel->fetch($sql);

            foreach ($posts as $post) {
                $post->categoryName = $cates[$post->id_category];
            }
        }

        $this->_data['posts'] = $posts;
    }

    public function addAction()
    {

    }
}
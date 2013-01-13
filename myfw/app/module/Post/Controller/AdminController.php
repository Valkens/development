<?php
class Post_Controller_AdminController extends Base_Controller_AdminController
{
    public function indexAction()
    {
        $this->_data['pageTitle'] = 'List Post';

        $postModel = new Post_Model_Post();
        $categoryModel = new Category_Model_Category();

        $this->_data['posts'] = $postModel->relate('Category_Model_Category', array('all' => true, 'desc' => 'post.id', 'limit' => '0,10'));
    }

    public function addAction()
    {

    }
}
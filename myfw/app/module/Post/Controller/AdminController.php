<?php
class Post_Controller_AdminController extends Base_Controller_AdminController
{
    const PER_PAGE = 10;

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

        $this->_data['categories'] = array_filter($categories, create_function('$obj', 'return $obj->id_parent != 0;'));
    }

    public function indexAction()
    {
        $this->_data['pageTitle'] = 'List Post';

        $posts = array();
        $cates = array();

        if ($this->_data['categories']) {
            foreach ($this->_data['categories'] as $category) {
                if ($category->id_parent == 0) continue;
                $cates[$category->id] = $category->name;
            }

            $postModel = new Post_Model_Post();
            $result = $postModel->fetch('COUNT(id) AS count_all');

            // Pagination
            $page = (isset($this->_params['page'])) ? $this->_params['page'] : 1;
            $offset = ($page - 1) * self::PER_PAGE;

            $posts = $postModel->fetchAll('*', "ORDER BY id DESC LIMIT {$offset}," . self::PER_PAGE);

            if (count($posts)) {
                foreach ($posts as $post) {
                    $post->categoryName = $cates[$post->id_category];
                }

                // Paginator
                $paginator = new Base_Helper_Paginator();
                $paginator->items_total = $result->count_all;
                $paginator->items_per_page = self::PER_PAGE;
                $paginator->current_page = $page;
                $paginator->baseUrl = $this->_router->generate('route_admin_post');
                $paginator->paginate();

                $this->_data['paginator'] = $paginator;
            }
        }

        $this->_data['posts'] = $posts;
    }

    public function addAction()
    {
        $this->_data['pageTitle'] = 'Add New Post';
    }

}
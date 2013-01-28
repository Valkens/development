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

        $this->_data['categories'] = $categories;
        $this->_data['subcategories'] = array_filter($categories, create_function('$obj', 'return $obj->id_parent != 0;'));
    }

    public function indexAction()
    {
        $params = $this->_request['params'];
        $posts = array();
        $categories = array();

        if ($this->_data['subcategories']) {
            foreach ($this->_data['subcategories'] as $category) {
                if ($category->id_parent == 0) continue;
                $categories[$category->id] = $category->name;
            }

            $postModel = new Post_Model_Post();
            $result = $postModel->fetch('COUNT(id) AS count_all');

            // Pagination
            $page = (isset($params['page'])) ? $params['page'] : 1;
            $offset = ($page - 1) * self::PER_PAGE;

            $posts = $postModel->fetchAll('id,thumbnail,title,id_subcategory,description,featured_status,status,comment_count',
                                          "ORDER BY id DESC LIMIT {$offset}," . self::PER_PAGE);

            if (count($posts)) {
                foreach ($posts as $post) {
                    $post->categoryName = $categories[$post->id_subcategory];
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

        $this->_data['pageTitle'] = 'List Post';
        $this->_data['posts'] = $posts;
    }

    public function addAction()
    {
        $params = $this->_request['params'];

        if ($this->isPost()) {
            $categoryArr = array_filter($this->_data['categories'], create_function('$obj', 'return $obj->id == '.$params['subcategory'].';'));
            $category = array_shift($categoryArr);

            // Save post
            $postModel = new Post_Model_Post();
            $postModel->id_category = $category->id_parent;
            $postModel->id_subcategory = $category->id;
            $postModel->title = $params['title'];
            $postModel->slug = $params['slug'];
            $postModel->featured_status = $params['featured_status'];
            $postModel->description = $params['description'];
            if (trim($params['meta_description'])) {
                $postModel->meta_description = $params['meta_description'];
            }
            $postModel->status = $params['status'];
            $postModel->comment_allowed = $params['comment_allowed'];
            $postModel->content = $params['content'];
            $postModel->created_time = time();
            $postModel->beginTransaction();
            try {
                $postModel->save();
                $postModel->commit();
            } catch (Exception $e) {
                $postModel->rollBack();
                throw new Exception($e->getMessage(), $e->getCode());
            }

            // Input tags
            $tagModel = new Tag_Model_Tag();
            $postTagModel = new Tag_Model_PostTag();
            $tagInputs = explode(',', $params['tags']);

            foreach ($tagInputs as $tagInput) {
                $slug = Base_Helper_String::generateSlug($tagInput);
                // Check tag is exists
                $tag = $tagModel->fetch('id', 'WHERE slug = :slug', array(':slug' => $slug));
                if (isset($tag->id)) {
                    // Check post_tag is exists
                    if (!$postTagModel->fetch('*', 'WHERE id_post = :id_post AND id_tag = :id_tag',
                                             array(
                                                 ':id_post' => $postModel->lastInsertId,
                                                 ':id_tag' => $tag->id
                                             ))
                        ) {
                        // Save post_tag
                        $postTagModel->id_post = $postModel->lastInsertId;
                        $postTagModel->id_tag  = $tag->id;
                        $postTagModel->beginTransaction();
                        try {
                            $postTagModel->save();
                            $postTagModel->commit();
                        } catch(Exception $e) {
                            $postTagModel->rollBack();
                            throw new Exception($e->getMessage(), $e->getCode());
                        }
                    }
                } else {
                    // Save tag
                    $tagModel->name = $tagInput;
                    $tagModel->slug = Base_Helper_String::generateSlug($tagInput);
                    $tagModel->beginTransaction();
                    try {
                        $tagModel->save();
                        $tagModel->commit();
                    } catch(Exception $e) {
                        $tagModel->rollBack();
                        throw new Exception($e->getMessage(), $e->getCode());
                    }

                    // Save post_tag
                    $postTagModel->id_post = $postModel->lastInsertId;
                    $postTagModel->id_tag  = $tagModel->lastInsertId;
                    $postTagModel->beginTransaction();
                    try {
                        $postTagModel->save();
                        $postTagModel->commit();
                    } catch(Exception $e) {
                        $postTagModel->rollBack();
                        throw new Exception($e->getMessage(), $e->getCode());
                    }
                }
            }

            $this->redirect(array('name' => 'route_admin_post'));
        }

        $this->_data['pageTitle'] = 'Add New Post';
    }

    public function editAction()
    {
        $params = $this->_request['params'];
        $postId = (int) $params['id'];

        $postModel = new Post_Model_Post();
        $this->_data['post'] = $postModel->fetch('*', 'WHERE id=:id LIMIT 1', array(':id'=>$postId));

        if (!$this->_data['post']) {
            throw new Exception('This post is not exists.', 404);
        }

        if ($this->isPost()) {

        }

        $this->_data['pageTitle'] = 'Edit Post';
    }

}
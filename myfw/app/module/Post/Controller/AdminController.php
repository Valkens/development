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

        $this->view->categories = $categories;
        $this->view->subcategories = array_filter($categories, create_function('$obj', 'return $obj->id_parent != 0;'));
    }

    public function indexAction()
    {
        $posts = array();
        $categories = array();

        if ($this->view->subcategories) {
            foreach ($this->view->subcategories as $category) {
                $categories[$category->id] = $category->name;
            }

            $postModel = new Post_Model_Post();
            $result = $postModel->fetch('COUNT(id) AS count_all');

            // Pagination
            $page = $this->getParam('page', 1);
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

                $this->view->paginator = $paginator;
            }
        }

        $this->view->posts = $posts;
    }

    public function addAction()
    {
        $params = $this->_request['params'];
        $this->view->input = array();

        if ($this->isPost()) {
            // Save thumbnail
            $uploadFile = new Core_Helper_Upload();
            $configs['uploadPath'] = BASE_PATH . '/public/upload/images/';
            $configs['allowedTypes'] = 'gif|jpg|jpeg|png';
            $config['maxSize'] = '2';
            $configs['overwrite'] = false;
            $configs['removeSpaces'] = true;
            $uploadFile->initialize($configs);
            $uploadFile->doUpload('thumbnail');

            if ($err = $uploadFile->getErrors()) {
                $this->view->errors = array('thumbnail' => array_shift($err));
                $this->view->input = $this->_request['params'];
            } else {
                $categoryArr = array_filter($this->view->categories, create_function('$obj', 'return $obj->id == '.$params['subcategory'].';'));
                $params['category'] = array_shift($categoryArr);
                
                // Save post
                $postModel = new Post_Model_Post();
                $postModel->initialize($params);
                $postModel->save();

                // Save input tags
                $tagModel = new Tag_Model_Tag();
                $postTagModel = new Tag_Model_PostTag();
                $tagModel->insertTags($params['tags'], $postModel->lastInsertId, $postTagModel);

                $this->redirect(array('route' => 'route_admin_post'));
            }
        }
    }

    public function editAction()
    {
        $params = $this->_request['params'];
        $postId = (int) $params['id'];
        $postModel = new Post_Model_Post();
        
        $this->view->post = $postModel->fetch('*', 'WHERE id=:id LIMIT 1', array(':id' => $postId));

        if ($this->view->post) {
            $postTagModel = new Tag_Model_PostTag();
            $tagModel = new Tag_Model_Tag();
            $tagIds = array();
            $tags = array();

            // Get tags of the Post
            if ($postTags = $postTagModel->fetchAll('id_tag', 'WHERE id_post = :id_post', array(':id_post' => $postId))) {
                foreach ($postTags as $postTag) {
                    $tagIds[] = $postTag->id_tag;
                }

                foreach ($tagModel->fetchAll('name,slug', 'WHERE id IN(' . implode(',', $tagIds) . ')') as $tag) {
                    $tags[$tag->slug] = $tag->name;
                }

                $this->view->post->tags = implode(',', $tags);
            }

            if ($this->isPost()) {
                if ($_FILES['thumbnail']) {
                    // Save thumbnail
                    $uploadFile = new Core_Helper_Upload();
                    $configs['uploadPath'] = BASE_PATH . '/public/upload/images/';
                    $configs['allowedTypes'] = 'gif|jpg|jpeg|png';
                    $config['maxSize'] = '2';
                    $configs['overwrite'] = false;
                    $configs['removeSpaces'] = true;
                    $uploadFile->initialize($configs);
                    $uploadFile->doUpload('thumbnail');

                    if ($err = $uploadFile->getErrors()) {
                        $this->view->errors = array('thumbnail' => array_shift($err));
                        $this->view->post = $this->_request['params'];
                        return;
                    }
                }

                // Update the post
                $categoryArr = array_filter($this->view->subcategories, create_function('$obj', 'return $obj->id == ' . $params['subcategory'] . ';'));
                $params['category'] = array_shift($categoryArr);

                $postModel = new Post_Model_Post();
                $postModel->initialize($params);
                $postModel->update();


                if (!$params['tags']) { // Delete all tags of the post
                    if ($tagIds) {
                        $postTagModel->delete('WHERE id_post = :id_post AND id_tag IN (' . implode(',', $tagIds) . ')',
                                               array(':id_post' => $postId));
                    }
                } else {
                    foreach (explode(',', $params['tags']) as $tagInput) {
                        $slug = Base_Helper_String::generateSlug($tagInput);
                        $tagInputs[$slug] = $tagInput; 
                    }

                    // If deleted tags
                    if ($deletedTagSlugs = array_diff(array_keys($tags), array_keys($tagInputs))) {
                        $deletedTagSlugs = array_map(array($postTagModel->db(), 'quote'), $deletedTagSlugs);
                        
                        foreach ($tagModel->fetchAll('id', 'WHERE slug IN(' . implode(',', $deletedTagSlugs) . ')') as $tag) {
                            $deletedTagIds[] = $tag->id;
                        }

                        // Delete tags of the Post
                        $postTagModel->delete('WHERE id_post = :id_post AND id_tag IN (' . implode(',', $deletedTagIds) . ')',
                                               array(':id_post' => $postId));
                    }

                    // If inserted tags
                    if ($insertedTagSlugs = array_diff(array_keys($tagInputs), array_keys($tags))) {
                        foreach ($insertedTagSlugs as $insertedTagSlug) {
                            $insertedTagNames[] = $tagInputs[$insertedTagSlug];
                        }

                        $tagModel->insertTags(array_values($insertedTagNames), $postId, $postTagModel);
                    }
                }

                $this->redirect(array('route' => 'route_admin_post'));
            }
        }
    }

}
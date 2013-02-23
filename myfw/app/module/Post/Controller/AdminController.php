<?php
class Post_Controller_AdminController extends Base_Controller_AdminController
{
    const PER_PAGE = 10;
    protected $postModel;

    public function init()
    {
        parent::init();

        $this->postModel = Core_Model::factory('Post_Model_Post');

        // Get all categories
        $categoryModel = Core_Model::factory('Category_Model_Category');
        $this->view->subcategories = array_filter($categoryModel->find_many(), create_function('$obj', 'return $obj->id_parent != 0;'));
    }

    public function indexAction()
    {
        $posts = array();
        $postCategories = array();

        if ($this->view->subcategories) {
            foreach ($this->view->subcategories as $category) {
                $postCategories[$category->id] = $category->name;
            }
            $this->view->postCategories = $postCategories;

            // Pagination
            $page = $this->getParam('page', 1);
            $offset = ($page - 1) * self::PER_PAGE;
            $totalPosts = $this->postModel->count();

            $posts = $this->postModel->order_by_desc('id')->limit(self::PER_PAGE)->offset($offset)->find_many();

            if (count($posts)) {
                // Paginator
                $paginator = new Base_Helper_Paginator();
                $paginator->items_total = $totalPosts;
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

        $this->view->post = $post = $this->postModel->find_one($params['id']);

        if ($post) {
            $post->tags = $post->getTags();

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
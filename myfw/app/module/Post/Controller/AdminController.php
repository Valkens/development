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

        $this->_data['pageTitle'] = 'List of Posts';
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
            $postModel->title = trim($params['title']);
            $postModel->slug = trim($params['slug']);
            $postModel->featured_status = $params['featured_status'];
            $postModel->description = trim($params['description']);
            if (trim($params['meta_description'])) {
                $postModel->meta_description = trim($params['meta_description']);
            }
            $postModel->status = $params['status'];
            $postModel->comment_allowed = $params['comment_allowed'];
            $postModel->content = trim($params['content']);
            $postModel->creation_date = time();
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

            $this->redirect(array('route' => 'route_admin_post'));
        }

        $this->_data['pageTitle'] = 'Add New Post';
    }

    public function editAction()
    {
        $params = $this->_request['params'];
        $postId = (int) $params['id'];
        $postModel = new Post_Model_Post();
        
        // Set post to view
        $this->_data['post'] = $post = $postModel->fetch('*', 'WHERE id=:id LIMIT 1', array(':id'=>$postId));

        if ($this->_data['post']) {
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
            }

            if ($this->isPost()) {
                // Update post
                $categoryArr = array_filter($this->_data['categories'], create_function('$obj', 'return $obj->id == '.$params['subcategory'].';'));
                $category = array_shift($categoryArr);

                // Save post
                $postModel = new Post_Model_Post();
                $postModel->id = $postId;
                $postModel->id_category = $category->id_parent;
                $postModel->id_subcategory = $category->id;
                $postModel->title = trim($params['title']);
                $postModel->slug = trim($params['slug']);
                $postModel->featured_status = $params['featured_status'];
                $postModel->description = trim($params['description']);
                if (trim($params['meta_description'])) {
                    $postModel->meta_description = trim($params['meta_description']);
                }
                $postModel->status = $params['status'];
                $postModel->comment_allowed = $params['comment_allowed'];
                $postModel->content = trim($params['content']);
                $postModel->creation_date = time();
                $postModel->beginTransaction();
                try {
                    $postModel->update();
                    $postModel->commit();
                } catch (Exception $e) {
                    $postModel->rollBack();
                    throw new Exception($e->getMessage(), $e->getCode());
                }
                
                if (!$params['tags']) {
                    // Delete all tags of the post
                    if ($tagIds) {
                        $postTagModel->beginTransaction();
                        try {
                            $postTagModel->delete('WHERE id_post = :id_post AND id_tag IN (' . implode(',', $tagIds) . ')',
                                                   array(':id_post' => $postId));
                            $postTagModel->commit();    
                        } catch (Exception $e) {
                            $postTagModel->rollBack();
                            throw $e;
                        }
                    }
                } else {
                    foreach (explode(',', $params['tags']) as $tagInput) {
                        $slug = Base_Helper_String::generateSlug($tagInput);
                        $tagInputs[$slug] = $tagInput; 
                    }
                    unset($slug);

                    // If deleted tags
                    if ($deleteTagSlugs = array_diff(array_keys($tags), array_keys($tagInputs))) {
                        $deleteTagSlugs = array_map(array($postTagModel->db(), 'quote'), $deleteTagSlugs);
                        
                        foreach ($tagModel->fetchAll('id', 'WHERE slug IN(' . implode(',', $deleteTagSlugs) . ')') as $tag) {
                            $deleteTagIds[] = $tag->id;
                        }

                        // Delete tags of the Post
                        $postTagModel->beginTransaction();
                        try {
                            $postTagModel->delete('WHERE id_post = :id_post AND id_tag IN (' . implode(',', $deleteTagIds) . ')',
                                                   array(':id_post' => $postId));
                            $postTagModel->commit();    
                        } catch (Exception $e) {
                            $postTagModel->rollBack();
                            throw $e;
                        }
                    }

                    if ($insertTagSlugs = array_diff(array_keys($tagInputs), array_keys($tags))) {
                        foreach ($insertTagSlugs as $slug) {
                            // Check tag is exists
                            $tag = $tagModel->fetch('id', 'WHERE slug = :slug', array(':slug' => $slug));
                            if (isset($tag->id)) {
                                // Check post_tag is exists
                                if (!$postTagModel->fetch('*', 'WHERE id_post = :id_post AND id_tag = :id_tag',
                                                         array(
                                                             ':id_post' => $postId,
                                                             ':id_tag' => $tag->id
                                                         ))
                                    ) {
                                    // Save post_tag
                                    $postTagModel->id_post = $postId;
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
                                $tagModel->name = $tagInputs[$slug];
                                $tagModel->slug = $slug;
                                $tagModel->beginTransaction();
                                try {
                                    $tagModel->save();
                                    $tagModel->commit();
                                } catch(Exception $e) {
                                    $tagModel->rollBack();
                                    throw new Exception($e->getMessage(), $e->getCode());
                                }

                                // Save post_tag
                                $postTagModel->id_post = $postId;
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
                    }
                }

                $this->redirect(array('route' => 'route_admin_post'));
            } else {
                // Set tags to view
                $post->tags = ($tags) ? implode(',', array_values($tags)) : null;
            }
        }

        $this->_data['pageTitle'] = 'Edit Post';
    }

}
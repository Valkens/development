<?php
class Post_Model_Post extends Core_Model
{
    public $table = 'post';
    public $primaryKey = 'id';
    public $fields = array('id', 'id_user', 'id_category', 'id_subcategory', 'thumbnail', 'title', 'slug', 'meta_description',
                            'description', 'content', 'status', 'comment_allowed', 'comment_count', 'featured_status',
                            'creation_date', 'modified_date');

    public function initialize($params)
    {
    	if (isset($params['id'])) {
    		$this->id = (int) $params['id'];
    		$this->modified_date = time();
    	} else {
    		$this->creation_date = time();
    	}

		$this->id_category = $params['category']->id_parent;
		$this->id_subcategory = $params['category']->id;
		$this->title = trim($params['title']);
		$this->slug = trim($params['slug']);
		$this->featured_status = $params['featured_status'];
		$this->description = trim($params['description']);
		if (trim($params['meta_description'])) {
			$this->meta_description = trim($params['meta_description']);
		}
		$this->status = $params['status'];
		$this->comment_allowed = $params['comment_allowed'];
		$this->content = trim($params['content']);
    }

}
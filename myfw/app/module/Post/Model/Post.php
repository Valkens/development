<?php
class Post_Model_Post extends Core_Model
{
    public static $_table = 'post';

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

    public function tags()
    {
        return $this->has_many_through('Tag_Model_Tag', 'Tag_Model_PostTag', 'post_id', 'tag_id');
    }

    public function category()
    {
        return $this->belongs_to('Category_Model_Category', 'subcategory_id')->find_one();
    }

    public function getTags()
    {
        $tags = $this->tags()->find_many();
        $tagArr = array();

        if (count($tags)) {
            foreach ($tags as $tag) {
                $tagArr[] = $tag->name;
            }
        }

        return implode(',', $tagArr);
    }

}
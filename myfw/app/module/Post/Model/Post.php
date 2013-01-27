<?php
class Post_Model_Post extends Core_Model
{
    public $table = 'post';
    public $primaryKey = 'id';
    public $fields = array('id', 'id_user', 'id_category', 'id_subcategory', 'thumbnail', 'title', 'slug', 'meta_description',
                            'description', 'content', 'status', 'comment_allowed', 'comment_count', 'featured_status',
                            'created_time', 'modified_time');

}
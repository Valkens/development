<?php
class Post_Model_Post extends Core_Model
{
    public $id;
    public $thumbnail;
    public $title;
    public $id_category;
    public $description;
    public $featured_status;
    public $status;
    public $comment_count;

    public $table = 'post';
    public $primaryKey = 'id';
    public $fields = array('id', 'id_user', 'id_category', 'thumbnail', 'title', 'slug', 'meta_description',
                            'description', 'content', 'status', 'comment_status', 'comment_count', 'featured_status',
                            'created_time', 'modified_time');

}
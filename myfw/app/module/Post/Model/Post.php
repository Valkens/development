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

    public $_table = 'post';
    public $_primarykey = 'id';
    public $_fields = array('id', 'id_user', 'id_category', 'thumbnail', 'title', 'slug', 'meta_description',
                            'description', 'content', 'status', 'comment_status', 'comment_count', 'featured_status',
                            'created_time', 'modified_time');

    public function  __construct($data = null)
    {
        parent::__construct($data);
        parent::setupModel(__CLASS__);

        $dbMap['Post_Model_Post']['belongs_to']['Category_Model_Category'] = array('foreign_key' => 'id');
        $this->db()->appendMap($dbMap);
    }
}
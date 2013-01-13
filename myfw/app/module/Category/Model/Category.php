<?php
class Category_Model_Category extends Core_Model
{
    public $_table = 'category';
    public $_primarykey = 'id';
    public $_fields = array('id', 'id_parent', 'name', 'slug', 'meta_description', 'sort');

    public function  __construct($data = null)
    {
        parent::__construct($data);
        parent::setupModel(__CLASS__);

        $dbMap['Category_Model_Category']['has_many']['Post_Model_Post'] = array('foreign_key' => 'id_category');
        $this->db()->appendMap($dbMap);
    }

}
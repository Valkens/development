<?php
class Category_Model_Category extends Core_Db_Model
{
    public $_table = 'category';
    public $_primarykey = 'id';
    public $_fields = array('id', 'id_parent', 'name', 'slug', 'description');


    public function  __construct($data = null)
    {
        parent::__construct($data);
        parent::setupModel(__CLASS__);
    }

}
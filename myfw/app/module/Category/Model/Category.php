<?php
class Category_Model_Category extends Core_Model
{
    public $table = 'category';
    public $primaryKey = 'id';
    public $fields = array('id', 'id_parent', 'name', 'slug', 'meta_description', 'sort');

}
<?php
class Tag_Model_Tag extends Core_Model
{
    public $table = 'tag';
    public $primarykey = 'id';
    public $fields = array('id', 'name', 'slug');

}
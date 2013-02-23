<?php
class Category_Model_Category extends Core_Model
{
    public static $_table = 'category';

    public function initialize($params)
    {
        if (isset($params['id'])) {
            $this->id = (int) $params['id'];
        }
        $this->id_parent = (int) $params['parent'];
        $this->name = trim($params['name']);
        $this->slug = trim($params['slug']);
        $this->sort = (int) $params['sort'];
        if (trim($params['meta_description'])) {
            $this->meta_description = trim($params['meta_description']);
        }
    }

}
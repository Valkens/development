<?php
class User_Model_User extends Core_Model
{
    public $name;

    public $table = 'user';
    public $primaryKey = 'id';
    public $fields = array('id', 'email', 'name', 'username', 'password', 'salt',
                           'last_login', 'creation_ip', 'last_login_ip', 'modified_date',
                           'avatar', 'level');
}
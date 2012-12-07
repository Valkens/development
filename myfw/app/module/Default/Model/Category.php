<?php
class Default_Model_Category extends Core_Db_Model
{
    /**
     * @var int Max length is 11.  unsigned.
     */
    public $id;

    /**
     * @var varchar Max length is 145.
     */
    public $name;

    public $_table = 'category';
    public $_primarykey = 'id';
    public $_fields = array('id','name');


    public function  __construct($data=null) {
        parent::__construct( $data );
        parent::setupModel(__CLASS__);
    }

}
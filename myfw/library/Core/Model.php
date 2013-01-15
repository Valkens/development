<?php
class Core_Model
{
    public static $db = array();
    public static $defaultAdapter = 'mysql';
    public $table;
    public $primaryKey;
    public $fields = array();
    protected static $_options;

    public function setDefaultAdapter($adapter)
    {
        self::$defaultAdapter = $adapter;
    }

    public function db()
    {
        self::$db = Core_Resource_Manager::getResource('db');

        $adapter = self::$defaultAdapter;

        if ((!isset(self::$db->$adapter) && !isset(self::$db->$adapter->connected))
            || (!isset(self::$db->$adapter) && !self::$db->$adapter->connected)
        ) {
            self::$db->connect(Core_Resource_Manager::getOption('db'), self::$defaultAdapter);
        }

        return self::$db;
    }

    public function commit()
    {
       $this->db()->commit();
    }

    public function beginTransaction()
    {
       $this->db()->beginTransaction();
    }

    /**
     * Rolls back a transaction. Transactions can be nestable.
     */
    public function rollBack()
    {
       $this->db()->rollBack();
    }

    public function save()
    {
        return $this->db()->save($this);
    }

    public function update()
    {
        return $this->db()->update($this);
    }

    public function fetch($column = '*', $custom = null, $params = null)
    {
        return $this->db()->fetch($this, $column, $custom, $params);
    }

    public function fetchAll($column = '*', $custom = null, $params = null)
    {
        return $this->db()->fetchAll($this, $column, $custom, $params);
    }

}

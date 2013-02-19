<?php
class Core_Model
{
    public static $defaultAdapter = 'mysql';
    protected static $_options = array();
    protected static $_db = array();

    public $table = null;
    public $primaryKey = null;
    public $fields = array();
    public $lastInsertId = null;
    public $rowCount = 0;

    public function __construct()
    {
        self::$_db = Core_Resource_Manager::getResource('db');
        self::$_options = Core_Resource_Manager::getOptions('db');
        $this->init();
    }

    public function init()
    {
        $this->table = self::$_options[self::$defaultAdapter]['dbprefix'] . $this->table;
    }

    public function setDefaultAdapter($adapter)
    {
        self::$defaultAdapter = $adapter;
        $this->init();
    }

    public function db()
    {
        $adapter = self::$defaultAdapter;

        if (!isset(self::$_db->$adapter) && !isset(self::$_db->$adapter->connected)) {
            self::$_db->connect(self::$_options, self::$defaultAdapter);
        }

        return self::$_db;
    }

    public function commit()
    {
       $this->db()->commit();
    }

    public function beginTransaction()
    {
       $this->db()->beginTransaction();
    }

    public function rollBack()
    {
       $this->db()->rollBack();
    }

    public function save()
    {
        $this->beginTransaction();
        try {
            $this->lastInsertId = $this->db()->save($this);
            $this->commit();
        } catch (Exception $e) {
            $this->rollBack();
            throw $e;
        }
    }

    public function update()
    {
        $this->beginTransaction();
        try {
            $this->rowCount = $this->db()->update($this);
            $this->commit();
        } catch (Exception $e) {
            $this->rollBack();
            throw $e;
        }
    }

    public function fetch($columns = '*', $custom = null, $params = null)
    {
        return $this->db()->fetch($this, $columns, $custom, $params);
    }

    public function fetchAll($columns = '*', $custom = null, $params = null)
    {
        return $this->db()->fetchAll($this, $columns, $custom, $params);
    }

    public function delete($custom, $params = null)
    {
        $this->beginTransaction();
        try {
            $this->rowCount = $this->db()->delete($this, $custom, $params);
            $this->commit();
        } catch (Exception $e) {
            $this->rollBack();
            throw $e;
        }
    }

}

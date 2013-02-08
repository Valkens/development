<?php
class Core_Model
{
    protected static $_options = array();
    public static $defaultAdapter = 'mysql';
    public static $db = array();

    public $table = null;
    public $primaryKey = null;
    public $fields = array();
    public $lastInsertId = null;
    public $rowCount = 0;

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
            self::$db->connect(Core_Resource_Manager::getOptions('db'), self::$defaultAdapter);
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

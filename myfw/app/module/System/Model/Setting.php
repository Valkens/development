<?php
class System_Model_Setting extends Core_Model
{
	public $table = 'setting';
    public $primaryKey = 'id';
    public $fields = array('id', 'name', 'value');

    public function updateAll($keys, $data)
    {
    	$sql = array();
    	$params = array();

    	$sql[] = "UPDATE {$this->table} SET value = CASE";

    	foreach ($keys as $key) {
    		$sql[] = " WHEN name='{$key}' THEN :{$key}";
    		$params[":$key"] = trim($data[$key]);
    	}
    	$sql[] = ' END';
		
		$this->db()->beginTransaction();
		try {
			$this->db()->query(implode('', $sql), $params);
			$this->db()->commit();
		} catch (Exception $e) {
			$this->db()->rollback();
			throw $e;
		}		
    }

}
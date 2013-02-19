<?php
class Core_Resource_Db
{
    public $adapter;
    public $connected = false;
    protected $_pdo = array();
    protected $_transactionLevel = 0;
    protected $_options;

    public function connect($options, $adapter)
    {
        $this->adapter = $adapter;

        if (isset($this->$adapter) && $this->$adapter->connected) {
            return;
        }

        $this->_options = $dbOptions = $options[$adapter];

        try {
            if ($this->adapter == 'sqlite') {
                $this->_pdo[$adapter] = new PDO("sqlite:{$dbOptions['dbname']}");
            } else {
                $this->_pdo[$adapter] = new PDO("mysql:host={$dbOptions['host']};dbname={$dbOptions['dbname']}",
                                                $dbOptions['username'], $dbOptions['password'],
                                                array(
                                                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                                                ));
            }

            $this->$adapter = new stdClass();
            $this->$adapter->connected = true;
            $this->_pdo[$adapter]->exec("SET NAMES 'UTF8'");
        } catch(PDOException $e){
            throw $e;
        }
    }

    public function disconnect(){
        $this->_pdo[$this->adapter] = null;
        $adapter = $this->adapter;
        $this->$adapter->connected = false;
    }

    public function beginTransaction() {
        if ($this->_transactionLevel === 0) {
            $this->_pdo[$this->adapter]->beginTransaction();
        }
        else{
            $this->_pdo[$this->adapter]->exec("SAVEPOINT LEVEL{$this->_transactionLevel}");
        }
        $this->_transactionLevel++;
    }

    public function commit() {
        $this->_transactionLevel--;
        if ($this->_transactionLevel === 0) {
            $this->_pdo[$this->adapter]->commit();
        }
        else{
            $this->_pdo[$this->adapter]->exec("RELEASE SAVEPOINT LEVEL{$this->_transactionLevel}");
        }
    }

    public function rollBack() {
        $this->_transactionLevel--;
        if($this->_transactionLevel === 0) {
            $this->_pdo[$this->adapter]->rollBack();
        }
        else{
            $this->_pdo[$this->adapter]->exec("ROLLBACK TO SAVEPOINT LEVEL{$this->_transactionLevel}");
        }
    }

    public function quote($string, $type=null) {
        return $this->_pdo[$this->adapter]->quote($string, $type);
    }

	public function quoteArray($array, $type=null) {
		if (!is_array($array)) {
			return $this->quote($array, $type);
		}
		$numItems = count($array);
		for($i=0; $i<$numItems; $i++) {
			if (is_array($array[$i])) {
				$array[$i] = $this->quoteArray($array[$i], $type);
			} else {
				$array[$i] = $this->quote($array[$i]);
			}
		}
		return $array;
	}

    public function lastInsertId() {
        return $this->_pdo[$this->adapter]->lastInsertId();
    }

    public function save($model)
    {
        $properties = array_keys(get_object_vars($model));

        $insert = "INSERT INTO {$model->table}(";
        $sql['fields'] = array();
        $sql['values'] = array();
        $bindPrams = array();

        foreach ($properties as $property) {
            if (in_array($property, $model->fields)
                && isset($model->{$property})
            ) {
                $sql['fields'][] = "{$property}";
                $sql['values'][] = ":{$property}";
                $bindPrams[":{$property}"] = $model->{$property};
            }
        }

        $field = implode(',', $sql['fields']) . ') ';
        $value = 'VALUES(' . implode(',', $sql['values']) . ')';

        $stmt = $this->_pdo[$this->adapter]->prepare($insert . $field . $value);
        $stmt->execute($bindPrams);

        return $this->lastInsertId();
    }

    public function update($model)
    {
        $properties = array_keys(get_object_vars($model));
        $sql = array();
        $bindPrams = array();

        foreach ($properties as $property) {
            if (in_array($property, $model->fields)
                && isset($model->{$property})
            ) {
                $sql[] = "{$property}=:{$property}";
                $bindPrams[":{$property}"] = $model->{$property};
            }
        }

        $query = "UPDATE {$model->table} SET " . implode(',', $sql) . " WHERE {$model->primaryKey}=:{$model->primaryKey}";
        $bindPrams[":{$model->primaryKey}"] = $model->{$model->primaryKey};

        $stmt = $this->_pdo[$this->adapter]->prepare($query);
        $stmt->execute($bindPrams);

        return $stmt->rowCount();
    }

    public function fetch($model, $columns = '*', $custom = null, $params = null)
    {
        $sql = "SELECT {$columns} FROM {$model->table}";

        if ($custom) {
            $sql .= " {$custom}";
        }

        $stmt = $this->_pdo[$this->adapter]->prepare($sql);

        if ($params) {
            $stmt->execute($params);
        } else {
            $stmt->execute();
        }

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function fetchAll($model, $columns = '*', $custom = null, $params = null)
    {
        $sql = "SELECT {$columns} FROM {$model->table}";

        if ($custom) {
            $sql .= " {$custom}";
        }

        $stmt = $this->_pdo[$this->adapter]->prepare($sql);

        if ($params) {
            $stmt->execute($params);
        } else {
            $stmt->execute();
        }

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function delete($model, $custom, $params = null)
    {
        $sql = "DELETE FROM {$model->table} $custom";

        $stmt = $this->_pdo[$this->adapter]->prepare($sql);

        if ($params) {
            $stmt->execute($params);
        } else {
            $stmt->execute();
        }

        return $stmt->rowCount();
    }

    public function query($sql, $params, $all = true)
    {
        $type = substr($sql, 0, strpos($sql, '_'));

        $stmt = $this->_pdo[$this->adapter]->prepare($sql);

        if ($params) {
            $stmt->execute($params);
        } else {
            $stmt->execute();
        }

        if ($type == 'SELECT') {
            return ($all) ? $stmt->fetchAll(PDO::FETCH_OBJ) : $stmt->fetch(PDO::FETCH_OBJ);
        } else {
            return $stmt->rowCount();
        }
    }

}
<?php
class Core_Resource_Db
{
    public $adapter;
    public $connected = false;
    protected $_pdo = array();
    protected $_transactionLevel = 0;
    protected $_options;

    /**
     * Connects to the database with the default database connection configuration
     */
    public function connect($options, $adapter)
    {
        $this->adapter = $adapter;

        if (isset($this->$adapter) && $this->$adapter->connected) {
            return;
        }

        $this->_options = $dbOptions = $options[$adapter];

        try{
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
            throw new Exception('Failed to open the DB connection', 3);
        }
    }

    /**
     * Close a database connection
     */
    public function disconnect(){
        $this->_pdo[$this->adapter] = null;
        $adapter = $this->adapter;
        $this->$adapter->connected = false;
    }
    
    /**
     * Initiates a transaction. Transactions can be nestable.
     */
    public function beginTransaction() {
        if($this->transactionLevel === 0){
            $this->_pdo[$this->adapter]->beginTransaction();
        }
        else{
            $this->_pdo[$this->adapter]->exec("SAVEPOINT LEVEL{$this->transactionLevel}");
        }
        $this->transactionLevel++;
    }

    /**
     * Commits a transaction. Transactions can be nestable.
     */
    public function commit() {
        $this->transactionLevel--;
        if($this->transactionLevel === 0){
            $this->_pdo[$this->adapter]->commit();
        }
        else{
            $this->_pdo[$this->adapter]->exec("RELEASE SAVEPOINT LEVEL{$this->transactionLevel}");
        }
    }

    /**
     * Rolls back a transaction. Transactions can be nestable.
     */
    public function rollBack() {
        $this->transactionLevel--;
        if($this->transactionLevel === 0){
            $this->_pdo[$this->adapter]->rollBack();
        }
        else{
            $this->_pdo[$this->adapter]->exec("ROLLBACK TO SAVEPOINT LEVEL{$this->transactionLevel}");
        }
    }

    /**
     * Quotes a string for use in a query.
     *
     * Places quotes around the input string and escapes and single quotes within the input string, using a quoting style appropriate to the underlying driver.
     * @param string $string The string to be quoted.
     * @param int $type Provides a data type hint for drivers that have alternate quoting styles. The default value is PDO::PARAM_STR.
     * @return string Returns a quoted string that is theoretically safe to pass into an SQL statement. Returns FALSE if the driver does not support quoting in this way.
     */
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

    /**
     * Returns the last inserted record's id
     * @return int
     */
    public function lastInsertId() {
        return $this->_pdo[$this->adapter]->lastInsertId();
    }

    /**
     * Returns the underlying PDO object used in Core_Db_SqlMagic
     * @return PDO
     */
    public function getDbObject(){
        return $this->_pdo;
    }

    public function save($model)
    {
        $properties = array_keys(get_object_vars($model));

        $sql['insert'] = "INSERT INTO {$model->table}(";
        $sql['fields'] = '';
        $sql['values'] = 'VALUES(';
        $bindPrams = array();

        foreach ($properties as $property) {
            if (in_array($property, $model->fields)
                && isset($model->{$property})
            ){
                $sql['fields'] .= "{$property},";
                $sql['values'] .= ":{$property},";
                $bindPrams[":{$property}"] = $model->{$property};
            }
        }

        $sql['fields'] = rtrim($sql['fields'], ',') . ') ';
        $sql['values'] = rtrim($sql['values'], ',') . ')';

        $stmt = $this->_pdo[$this->adapter]->prepare(implode('', $sql));
        $stmt->execute($bindPrams);

        return $this->lastInsertId();
    }

    public function update($model)
    {
        $properties = array_keys(get_object_vars($model));

        $sql = "UPDATE {$model->table} SET ";
        $bindPrams = array();

        foreach ($properties as $property) {
            if (in_array($property, $model->fields)
                && isset($model->{$property})
            ){
                $sql .= "{$property}=:{$property},";
                $bindPrams[":{$property}"] = $model->{$property};
            }
        }

        $sql = rtrim($sql, ',') . " WHERE {$model->primaryKey}=:{$model->primaryKey}";
        $bindPrams[":{$model->primaryKey}"] = $model->{$model->primaryKey};

        $stmt = $this->_pdo[$this->adapter]->prepare($sql);
        $stmt->execute($bindPrams);

        return $this->lastInsertId();
    }

    public function fetch($sql, $fetchType, $params)
    {
        if ($params) {
            $stmt = $this->_pdo[$this->adapter]->prepare($sql, $params);
        } else {
            $stmt = $this->_pdo[$this->adapter]->prepare($sql);
        }
        $stmt->execute($params);

        if ($fetchType == 'all') {
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function query($sql, $params)
    {
        if ($params) {
            $stmt = $this->_pdo[$this->adapter]->prepare($sql, $params);
        } else {
            $stmt = $this->_pdo[$this->adapter]->prepare($sql);
        }
        $stmt->execute($params);

        return $stmt->rowCount();
    }
}
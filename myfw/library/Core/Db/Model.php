<?php
class Core_Db_Model
{
    public static $db = array();

    public static $defaultAdapter = 'mysql';

    protected static $_options;

    /**
     * Determine whether the DB field names should be case sensitive.
     * @var bool
     */
    protected static $caseSensitive = false;

    /**
     * The class name of the Model
     * @var string
     */
    protected static $className = __CLASS__;

    /**
     * Constructor of a Model. Sets the model class properties with a list of keys & values.
     * @param array $properties Array of data (keys and values) to set the model properties
     */
    public function __construct($properties=null){
        if ($properties!==null){
            foreach($properties as $k=>$v){
                if(in_array($k, $this->_fields))
                    $this->{$k} = $v;
            }
        }
    }

    public function setDefaultAdapter($adapter)
    {
        self::$defaultAdapter = $adapter;
    }

    /**
     * Setup the model. Use if needed with constructor.
     *
     * @param string $class Class name of the Model
     * @param bool $caseSensitive Determine whether the DB field names should be case sensitive.
     */
    protected function setupModel( $class=__CLASS__, $caseSensitive=false )
    {
        self::$className = $class;
        self::$caseSensitive = $caseSensitive;
    }

    /**
     * Validate the Model with the rules defined in getVRules()
     *
     * @param string $checkMode Validation mode. all, all_one, skip
	 * @param string $requireMode Require Check Mode. null, nullempty
     * @return array Return array of errors if exists. Return null if data passes the validation rules.
     */
    public function validate($checkMode='all', $requireMode='null')
    {
        //all, all_one, skip
        $v = new Core_Helper_Validator;
        $v->checkMode = $checkMode;
		$v->requireMode = $requireMode;
        return $v->validate(get_object_vars($this), $this->getVRules());
    }

    /**
     * Validate the Model with the rules defined in getVRules()
     *
     * @param object $model Model object to be validated.
     * @param string $checkMode Validation mode. all, all_one, skip
	 * @param string $requireMode Require Check Mode. null, nullempty
     * @return array Return array of errors if exists. Return null if data passes the validation rules.
     */
    public static function _validate($model, $checkMode='all', $requireMode='null')
    {
        //all, all_one, skip
        $v = new Core_Helper_Validator;
        $v->checkMode = $checkMode;
		$v->requiredMode = $requireMode;
        return $v->validate(get_object_vars($model), $model->getVRules());
    }

    //-------------- shorthands --------------------------
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

    /**
     * Commits a transaction. Transactions can be nestable.
     */
    public function commit(){
       $this->db()->commit();
    }

    /**
     * Initiates a transaction. Transactions can be nestable.
     */
    public function beginTransaction(){
       $this->db()->beginTransaction();
    }

    /**
     * Rolls back a transaction. Transactions can be nestable.
     */
    public function rollBack(){
       $this->db()->rollBack();
    }

    /**
     * Find a record. (Prepares and execute the SELECT statements)
     * @param array $opt Associative array of options to generate the SELECT statement. Supported: <i>where, limit, select, param, groupby, asc, desc, custom, asArray</i>
     * @return mixed A model object or associateve array of the queried result
     */
    public function find($opt=null){
        return $this->db()->find($this, $opt);
    }

    /**
     * Find a record and its associated model. Relational search. (Prepares and execute the SELECT statements)
     * @param string $rmodel The related model class name.
     * @param array $opt Associative array of options to generate the SELECT statement. Supported: <i>where, limit, select, param, joinType, groupby, match, asc, desc, custom, asArray, include, includeWhere, includeParam</i>
     * @return mixed A list of model object(s) or associateve array of the queried result
     */
    public function relate($rmodel, $opt=null){
        return$this->db()->relate($this, $rmodel, $opt);
    }

    /**
     * Combine relational search results (combine multiple relates).
     *
     * Example:
     * <code>
     * $food = new Food;
     * $food->relateMany(array('Recipe','Article','FoodType'))
     * </code>
     *
     * @param array $rmodel The related models class names.
     * @param array $opt Array of options for each related model to generate the SELECT statement. Supported: <i>where, limit, select, param, joinType, groupby, match, asc, desc, custom, asArray, include, includeWhere, includeParam</i>
     * @return mixed A list of model objects of the queried result
     */
	public function relateMany($rmodel, $opt=null){
        return$this->db()->relateMany($this, $rmodel, $opt);
    }

    /**
     * Expand related models (Tree Relationships).
     *
     * Example:
     * <code>
     * $recipe = new Recipe;
     * $recipe->relateExpand(array('Food','Article'))
     * </code>
     *
     * @param array $rmodel The related models class names.
     * @param array $opt Array of options for each related model to generate the SELECT statement. Supported: <i>where, limit, select, param, joinType, groupby, match, asc, desc, custom, asArray, include, includeWhere, includeParam</i>
     * @return mixed A list of model objects of the queried result
     */
	public function relateExpand($rmodel, $opt=null){
        return$this->db()->relateExpand($this, $rmodel, $opt);
    }

    /**
     * Adds a new record. (Prepares and execute the INSERT statements)
     * @return int The inserted record's Id
     */
    public function insert(){
        return$this->db()->insert($this);
    }

    /**
     * Adds a new record with a list of keys & values (assoc array) (Prepares and execute the INSERT statements)
     * @param array $data Array of data (keys and values) to be insert
     * @return int The inserted record's Id
     */
    public function insertAttributes($data){
        return$this->db()->insertAttributes($this, $data);
    }
    
    /**
     * Use insertAttributes() instead
     * @deprecated deprecated since version 1.3
     */
    public function insert_attributes($data){
        return $this->insertAttributes($data);
    }

    /**
     * Adds a new record with its associated models. Relational insert. (Prepares and execute the INSERT statements)
     * @param array $rmodels A list of associated model objects to be insert along with the main model.
     * @return int The inserted record's Id
     */
    public function relatedInsert($rmodels){
        return$this->db()->relatedInsert($this, $rmodels);
    }

    /**
     * Update an existing record. (Prepares and execute the UPDATE statements)
     * @param array $opt Associative array of options to generate the UPDATE statement. Supported: <i>where, limit, field, param</i>
     * @return int Number of rows affected
     */
    public function update($opt=NULL){
        return$this->db()->update($this, $opt);
    }

    /**
     * Update an existing record with a list of keys & values (assoc array). (Prepares and execute the UPDATE statements)
     * @param array $opt Associative array of options to generate the UPDATE statement. Supported: <i>where, limit, field, param</i>
     * @return int Number of rows affected
     */
    public function update_attributes($data, $opt=NULL){
        return$this->db()->update_attributes($this, $data, $opt);
    }

    /**
     * Update an existing record with its associated models. Relational update. (Prepares and execute the UPDATE statements)
     * @param array $rmodels A list of associated model objects to be updated or insert along with the main model.
     * @param array $opt Assoc array of options to update the main model. Supported: <i>where, limit, field, param</i>
     */
    public function relatedUpdate($rmodels, $opt=NULL){
        return$this->db()->relatedUpdate($this, $rmodels, $opt);
    }

    /**
     * Returns the last inserted record's id
     * @return int
     */
    public function lastInsertId(){
        return$this->db()->lastInsertId();
    }

	/**
	 * Delete ALL existing records. (Prepares and executes the DELETE statements)
	 */
	public function deleteAll() {
		return$this->db()->deleteAll($this);
	}

    /**
     * Delete an existing record. (Prepares and execute the DELETE statements)
     * @param array $opt Associative array of options to generate the UPDATE statement. Supported: <i>where, limit, param</i>
     */
    public function delete($opt=NULL){
        return$this->db()->delete($this, $opt);
    }

    //---------- Useful querying methods such as getOne, count, limit

    /**
     * Retrieve a list of paginated data. To be used with DooPager
     *
     * @param string $limit String for the limit query, eg. '6,10'
     * @param string $asc Fields to be sorted Ascendingly. Use comma to seperate multiple fields, eg. 'name,timecreated'
     * @param string $desc Fields to be sorted Descendingly. Use comma to seperate multiple fields, eg. 'name,timecreated'
     * @param array $options Options for the query. Available options see @see find()
     * @return mixed A model object or associateve array of the queried result
     */
    public function limit($limit=1, $asc='', $desc='', $options=null){
        if($asc!='' || $desc!='' || $options!==null){
            $options['limit'] = $limit;
            if($asc!=''){
                $options['asc'] = $asc;
            }
            if($desc!=''){
                $options['desc'] = $desc;
            }
            if($asc!='' && $desc!=''){
                $options['asc'] = $asc;
                $options['custom'] = ','. $desc .' DESC';
            }
            //print_r($options);
            return $this->db()->find($this, $options);
        }
        return $this->db()->find($this, array('limit'=>$limit));
    }

    /**
     * Retrieve model by one record.
     *
     * @param array $options Options for the query. Available options see @see find()
     * @return mixed A model object or associateve array of the queried result
     */
    public function getOne($options=null){
        if($options!==null){
            $options['limit'] = 1;
            return $this->db()->find($this, $options);
        }
        return $this->db()->find($this, array('limit'=>1));
    }

    /**
     * Retrieve the total records in a table. COUNT()
     *
     * @param array $options Options for the query. Available options see @see find() and additional 'distinct' option
     * @return int total of records
     */
    public function count($options=null){
		$options['select'] = isset($options['having']) ? $options['select'] . ', ' : '';
		if (isset($options['distinct']) && $options['distinct'] == true) {
			$options['select'] .= 'COUNT(DISTINCT '. $this->_table . '.' . $this->_fields[0] .') as _doototal';
		} else {
			$options['select'] .= 'COUNT('. $this->_table . '.' . $this->_fields[0] .') as _doototal';
		}
        $options['asArray'] = true;
        $options['limit'] = 1;
        $rs = $this->db()->find($this, $options);
        return $rs['_doototal'];
    }

    //--------------- dynamic querying --------------
    public function __call($name, $args){

        // $food->getById( $id );
        // $food->getById(14);
        // $food->getById(14, array('limit'=>1)) ;
        // $food->getById_location(14, 'Malaysia') ;
        // $food->getById_location(14, 'Malaysia', array('limit'=>1)) ;
        if(strpos($name, 'get')===0){
            if(self::$caseSensitive==false){
                $field = strtolower( substr($name,5));
            }else{
                $field = substr($name,5);
            }

            // if end with _first, add 'limit'=>'first' to Option array
            if( substr($name,-6,strlen($field)) == '_first' ){
                $field = str_replace('_first', '', $field);
                $first['limit'] = 1;
            }

            // underscore _ as AND in SQL
            if(strpos($field, '_')!==false){
                $field = explode('_', $field);
            }

            $clsname = get_class($this);
            $obj = new $clsname;

            if(is_string($field)){
                $obj->{$field} = $args[0];

                //if more than the field total, it must be an option array
                if(sizeof($args)>1){
                    if(isset($first))
                        $args[1]['limit'] = 1;
                    return $this->db()->find($obj, $args[1]);
                }

                if(isset($first)){
                    return $this->db()->find($obj, $first);
                }
                return $this->db()->find($obj);
            }
            else{
                $i=0;
                foreach($field as $f){
                    $obj->{$f} = $args[$i++];
                }

                //if more than the field total, it must be an option array
                if(sizeof($args)>$i){
                    if(isset($first))
                        $args[$i]['limit'] = 1;
                    return $this->db()->find($obj, $args[$i]);
                }

                if(isset($first)){
                    return $this->db()->find($obj, $first);
                }
                return $this->db()->find($obj);
            }
        }

        # relateTheRelatedModelClassName
        //$food->relateFoodType();
        //$food->relateFoodType( $optionsOrObject );  if 1 args, it will be option or object
        //$food->relateFoodType( $food, $options );  if more than 1
        # You can get only one by
        //$food->relateFoodType_first();    this adds the 'limit'=>'first' to the Options
        else if(strpos($name, 'relate')===0){
            $relatedClass = substr($name,6);

            // if end with _first, add 'limit'=>'first' to Option array
            if( substr($name,-6,strlen($relatedClass)) == '_first' ){
                $relatedClass = str_replace('_first', '', $relatedClass);
                $first['limit'] = 'first';
                if(sizeof($args)===0){
                    $args[0] = $first;
                }
                else{
                    if(is_array($args[0])){
                        $args[0]['limit'] = 'first';
                    }else{
                        $args[1]['limit'] = 'first';
                    }
                }
            }

            if(sizeof($args)===0){
                return $this->db()->relate( $this, $relatedClass);
            }
            else if(sizeof($args)===1){
                if(is_array($args[0])){
                    return $this->db()->relate( $this, $relatedClass, $args[0]);
                }else{
                    if(isset($first)){
                        return $this->db()->relate( $args[0], $relatedClass, $first);
                    }
                    return $this->db()->relate( $args[0], $relatedClass);
                }
            }else{
                return $this->db()->relate( $args[0], $relatedClass, $args[1]);
            }
        }
    }

    public static function __set_state($properties){
        $obj = new self::$className;
        foreach($properties as $k=>$v){
            $obj->{$k} = $v;
        }
        return $obj;
    }

}

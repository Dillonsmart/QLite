<?php 
/**
 * QLite is a simple class used to interact with a MySQL database - https://github.com/Dillonsmart/QLite
 * @author  Author: Dillon Smart. (https://twitter.com/dillon_smart)
 * @version 1.0.0
 */

namespace QLite;


use \PDO;
use \PDOException;

class QLite extends DB
{

    private $qc;
    private $type;
    private $query;
    private $where;
    private $pData;
    private $foreignKeys;
    private $charset = 'utf8';
    private $collate = 'utf8_general_ci';
    private $primaryKey = 'id';

    public function __construct($dbhost, $dbname, $dbuser, $dbpass)
    {

        parent::__construct($dbhost, $dbname, $dbuser, $dbpass);

        $this->qc = $this->connection;
        $this->qc->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    }


    public function dd($var)
    {
        echo '<pre>';
        die(var_dump($var));
        echo '</pre>';
    }

    /**
     * Create a table 
     * 
     * @param $tablename String 
     */
    public function create_table($tableName)
    {
        $this->type = 1;
        $this->query = "CREATE TABLE IF NOT EXISTS ". $tableName ." (";

        return $this;

    }

    /**
     * Create table column
     *
     * @param string $name
     * @return object
     */
    public function column($name)
    {
        $this->query .= $name . " ";

        return $this;

    }

    /**
     * Auto Increment field
     *
     * @return void
     */
    public function auto()
    {
        $this->query .= "AUTO_INCREMENT ";

        return $this;
    }

    /**
     * Column datatype int
     *
     * @param integer $length
     * @return void
     */
    public function integer($length)
    {
        $this->query .= "INT(" . $length . ") ";

        return $this;

    }

    /**
     * Column float datatype
     *
     * @param integer $length
     * @param float $decimal
     * @return void
     */
    public function float($length, $decimal)
    {
        $this->query .= "FLOAT(" . $length .", ". $decimal .") ";

        return $this;
    }

    /**
     * Column datatype string
     *
     * @param integer $length
     * @return void
     */
    public function string($length)
    {
        $this->query .= "VARCHAR(" . $length . ") ";

        return $this;

    }

    /**
     * Column datatype text
     *
     * @param integer $length
     * @return void
     */
    public function text($length)
    {
        $this->query .= "TEXT(" . $length . ") ";

        return $this;

    }

    /**
     * Column datatype boolean
     *
     * @return void
     */
    public function boolean()
    {
        $this->query .= "BOOLEAN ";

        return $this;

    }

    /**
     * Column datatype date
     *
     * @return void
     */
    public function date()
    {
        $this->query .= "DATE ";

        return $this;
    }

    /**
     * Column datatype datetime
     *
     * @return void
     */
    public function datetime()
    {
        $this->query .= "DATETIME ";

        return $this;
    }

    /**
     * Column datatype time
     *
     * @return void
     */
    public function time()
    {
        $this->query .= "TIME ";

        return $this;
    }

    /**
     * Column datatype year
     *
     * @return void
     */
    public function year()
    {
        $this->query .= "YEAR ";

        return $this;
    }

    /**
     * Column datatype blob
     *
     * @param integer $length
     * @return void
     */
    public function blob($length)
    {
        $this->query .= "BLOB(" . $length . ") ";

        return $this;
    }

    /**
     * Column nullable state 
     *
     * @param integer $state
     * @return void
     */
    public function null($state = 0)
    {

        if($state){
            $this->query .= " NULL, ";
        } else {
            $this->query .= " NOT NULL, ";
        }

        return $this;

    }

    /**
     * Set the column to be a primary key
     *
     * @param string $columnName
     * @return void
     */
    public function primary($columnName)
    {

        $this->query .= "PRIMARY KEY(". $columnName .") ";

        return $this;

    }

    /**
     * Make the column unique
     *
     * @param string $columnName
     * @return void
     */
    public function unique($columnName)
    {

        $this->query .= "UNIQUE(". $columnName ."), ";

        return $this;

    }

    /**
     * Adding a foreign key to a table
     *
     * @param string $columnName
     * @param string $refTable
     * @param string $refColumn
     * @return void
     */
    public function foreign($columnName, $refTable, $refColumn)
    {

        $this->foreignKeys .= "FOREIGN KEY (". $columnName .") REFERENCES ". $refTable ."(". $refColumn ."), ";

        $this->query .= $this->foreignKeys;

        return $this;

    }

    /**
     * Set the tables character set and collate 
     *
     * @param string $charset
     * @param string $collate
     * @return void
     */
    public function charcoll($charset = "utf8", $collate = "utf8_general_ci")
    {
        $this->query .= ") CHARACTER SET ". $charset ." COLLATE " . $collate;

        return $this;

    }

    /**
     * Add timestamp fields to table
     *
     * @return void
     */
    public function timestamps()
    {

        $this->column('created_at')->datetime()->null(1);
        $this->column('updated_at')->datetime()->null(1);

        return $this;

    }

    /**
     * Add softdelete deleted_at field to table
     *
     * @return void
     */
    public function softdeletes()
    {
        $this->column('deleted_at')->datetime()->null(1);
        $this->column('deleted_by')->integer(11)->null(1);
        $this->foreignKeys .= ", FOREIGN KEY (deleted_by) REFERENCES users(id) ";

        return $this;

    }

    /**
     * Execute the query before nulling the query string
     *
     * @param [type] $query
     * @return void
     */
    public function execute_query($query)
    {

        $q = $this->query;

        $this->query = null;

        return $this->qc->exec($q);

    }

    /**
     * The QLite execution method
     *
     * @return void
     */
    public function go()
    {

        // creating a database table so set the table primary key, charset and collate
        if($this->type === 1) {
            $this->primary($this->primaryKey);
            $this->charcoll($this->charset, $this->collate);
        }

        $this->type = null; // reset the query type

        return $this->execute_query($this->query);

    }

    /**
     * The general query method
     *
     * @param string $q - the sql query to be executed 
     * @return void
     */
    public function q($q){
        
        $this->query = $q;

        if (strpos($q, 'select') !== false || strpos($q, 'SELECT') !== false )
            return $this->qc->query($this->query)->fetchAll();
    
        $executeQuery = $this->qc->query($this->query);

        $this->query = "";

        return $executeQuery;

    }

    /**
     * Select method 
     *
     * @param string $field
     * @param string $table
     * @return void
     */
    public function select($field, $table, $includeSoftDeletes = null)
    {

        if($includeSoftDeletes){
            $this->query = "SELECT " . $field . " FROM " . $table;
        } else {
            $this->query = "SELECT " . $field . " FROM " . $table . " WHERE deleted_at IS NULL";
            $this->where - true;
        }

        return $this;

    }

    /**
     * Where method 
     *
     * @param string $field
     * @param string $operator
     * @param string $comparison
     * @return void
     */
    public function where($field, $operator, $comparison)
    {
        
        $stringStart = " WHERE ";

        if($this->where)
            $stringStart = " AND ";

        $this->query .= $stringStart . $field . " " . $operator . " '" . $comparison . "'"; 

        $this->where = true;

        return $this;

    }

    /**
     * Order results method
     *
     * @param string $field
     * @param string $direction
     * @return void
     */
    public function order($field, $direction)
    {

        $this->query .= " ORDER BY " . $field . " " . $direction;

        return $this;

    }

    /**
     * Limit method
     *
     * @param integer $limit
     * @param integer $offset
     * @return void
     */
    public function limit($limit, $offset = 0)
    {

        // -1 is no limit
        if($limit != -1) {

            $this->query .= " LIMIT " . $limit;

            if($offset != 0)
                $this->query .= " OFFSET " . $offset;
    
        }

        return $this;

    }

    /**
     * Get method 
     * Executes the query 
     * Chained to the end of a select method 
     *
     * @return void
     */
    public function get()
    {

        $results = $this->qc->query($this->query)->fetchAll(PDO::FETCH_COLUMN);

        $this->query = "";
        $this->where = null;

        return $results;

    }

    /**
     * Insert method
     *
     * @param string $tableName
     * @param array $data
     * @return void
     */
    public function insert($tableName, $data)
    {

        $columns = $this->get_columns($data);
        $keys = $this->get_keys($data);

        $query = "INSERT INTO ". $tableName ." (". $columns .") VALUES (". $keys .")";

        $stmt = $this->qc->prepare($query);

        print_r('<pre>' . print_r($query) . '</pre>');

        try{
            return $stmt->execute($data);
        }   catch (PDOException $e) {
            return $e->getMessage();
        }

    }

    /**
     * Update method
     *
     * @param string $tableName
     * @param array $data
     * @return void
     */
    public function update($tableName, $data)
    {

        $this->pData = $data;
        $arrKeys = array_keys($data);
        $set = "";

        foreach($arrKeys as $d){
            $set .= $d . "=?,";
        }

        $this->query = "UPDATE " . $tableName . " SET " . rtrim($set, ",");

        return $this;

    }

    /**
     * Delete method
     *
     * @param string $tableName
     * @param array $data
     * @return void
     */
    public function delete($tableName, $data)
    {

        $this->pData = $data;
        $arrKeys = array_keys($data);
        $set = "";

        foreach($arrKeys as $d){
            $set .= $d . "=?,";
        }

        $this->query = "DELETE FROM ". $tableName ." WHERE " . rtrim($set, ",");        
        
        return $this;
        
    }

    /**
     * Execution method
     *
     * @return void
     */
    public function exec()
    {

        return $this->qc->prepare($this->query)->execute(array_values($this->pData));
    }

    /**
     * Return the last insert ID
     *
     * @return void
     */
    public function last_insert()
    {
        return $this->qc->lastInsertId();
    }

    /**
     * Check the columns string used in queries for prepared statements
     */
    private function get_columns($data, $values = true){

        $arrKeys = array_keys($data);

        $columns = "";

        if($values){
    
            for($i = 0; $i < count($arrKeys); $i++){
    
                if($i < ( count($arrKeys) - 1)){
                    $columns .= $arrKeys[$i] . ",";
                } else {
                    $columns .= $arrKeys[$i];
                }
    
            }

        } else {
            
            for($i = 0; $i < count($data); $i++){
    
                if($i < ( count($data) - 1)){
                    $columns .= $data[$i] . ",";
                } else {
                    $columns .= $data[$i];
                }
    
            }

        }

        return $columns;

    }

    /**
     * Check the keys string used in queries for prepared statements
     */
    private function get_keys($data){

        $arrKeys = array_keys($data);

        $keys = "";

        for($i = 0; $i < count($arrKeys); $i++){

            if($i < ( count($arrKeys) - 1)){
                $keys .= ":" . $arrKeys[$i] . ",";
            } else {
                $keys .= ":" . $arrKeys[$i];
            }

        }

        return $keys;
    }

}
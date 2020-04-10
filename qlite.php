<?php 
/**
 * QLite is a simple class used to interact with the database
 * @version 0.1
 */


class QLite extends DB
{

    private $qc;

    public function __construct($dbhost, $dbname, $dbuser, $dbpass)
    {

        parent::__construct($dbhost, $dbname, $dbuser, $dbpass);

        $this->qc = $this->connection;
        $this->qc->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    }


    /**
     * Create a table 
     * @param $tablename String 
     * @param $columns Array
     */
    public function create_table($tableName, $columns = null)
    {

        $query = "CREATE TABLE IF NOT EXISTS ". $tableName ." (";
        $primary = "";

        foreach($columns as $col) {
            $query .= $col['name'] . " " . $col['datatype'] . " " . $col['att'] . ",";

            if($col['pk']){
                $primary = "PRIMARY KEY(".$col['name']."))";
            }

        }

        $query .= $primary;
        $query .= "CHARACTER SET utf8 COLLATE utf8_general_ci";

        try{
            return $this->qc->exec($query);
        }   catch (PDOException $e) {
            return $e->getMessage();
        }

    }


    /**
     * Selectng data from a table
     */
    public function select($tableName, $columns, $limit)
    {

        $cols = $this->get_columns($columns, false);

        $query = "SELECT ". $cols ." FROM ". $tableName ." LIMIT " . $limit;

        dd($query);

        try{
            return $this->qc->query($query)->fetch();
        }   catch (PDOException $e) {
            return $e->getMessage();
        }


    }


    /**
     * Inserting data into a table
     */
    public function insert($tableName, $data)
    {

        $columns = $this->get_columns($data);
        $keys = $this->get_keys($data);

        $query = "INSERT INTO ". $tableName ." (". $columns .") VALUES (". $keys .")";

        $stmt = $this->qc->prepare($query);

        try{
            return $stmt->execute($data);
        }   catch (PDOException $e) {
            return $e->getMessage();
        }

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
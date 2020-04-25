<?php 
/**
 * QLite is a simple class used to interact with the database - https://github.com/Dillonsmart/QLite
 * @author  Author: Dillon Smart. (https://twitter.com/dillon_smart)
 * @version 0.5
 */

namespace QLite;


use \PDO;
use \PDOException;

class DB {

    public $connection;
    private $name;
    private $user;
    private $pass;
    private $host;

    public function __construct($dbhost, $dbname, $dbuser, $dbpass)
    {
        
        $this->name = $dbname;
        $this->user = $dbuser;
        $this->pass = $dbpass;
        $this->host = $dbhost;

        return $this->establish_connection();

    }


    public function establish_connection(){

        try {
            $this->connection = new PDO('mysql:dbname='. $this->name .';host=' . $this->host, $this->user, $this->pass);
        } catch (PDOException $e) {
            echo '<h1>Error establishing connection to the database</h1>';
            echo $e->getMessage();
            return false;
        }

    }


}
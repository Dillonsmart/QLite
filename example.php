<?php

require('QLite/qlite.php');

use QLite\QLite;

$cfdb = new QLite('localhost', 'qlite', 'qlite', 'qlite');

$cfdb->create_table(
    'ql_example',
    array(
        array(
            'name'     => 'id',                      
            'datatype' => 'INT',                     
            'att'      => 'AUTO_INCREMENT NOT NULL', 
            'pk'       => true                       
        ),
        array(
            'name'     => 'name',
            'datatype' => 'VARCHAR(24)', 
            'att'      => 'NOT NULL',
            'pk'       => false
        ),
        array(
            'name'     => 'age',
            'datatype' => 'INT',
            'att'      => 'NOT NULL',
            'pk'       => false
        )
    )
);

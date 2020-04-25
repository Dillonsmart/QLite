<?php

require('qlite.php');

use QLite;

// Creating a new connection
$cfdb = new QLite('localhost', 'qlite', 'qlite', 'qlite');

// Creating a new database table
$cfdb->create_table('test_table')
    ->column('id')->integer(11)->null(0)
    ->column('name')->string(256)->null(0)
    ->column('company')->string(256)->null(1)
    ->primary('id')
    ->charcoll()
    ->go();
    
// Inserting test data
$cfdb->insert(
    'test_table', 
    array(
        'name'    => 'John Doe',
        'company' => 'Example Company'
    )
);

// Selecting the data 
$data = $cfdb->select('*', 'test_table')
             ->where('name', '=', 'John Doe')
             ->where('id', '=', 1)
             ->get();

print_r($data);            
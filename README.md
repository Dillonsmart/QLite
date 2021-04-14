# QLite v1.0.0 - PDO Class 

QLite is a PHP PDO database class designed to make connections with a MySQL database efficient and clean. 

## Getting Started 

```
require('QLite/qlite.php');

use QLite\QLite;

$ql = new QLite('db_host', 'db_name', 'db_user', 'db_password');
```

## Simply query the database
### Execute your own SQL query 
```
$ql->q("SELECT * FROM users");
```

## Creating Tables 
```
$ql->create_table(string $tableName);
```

```
$ql->create_table('users')
     ->go();
```

There are a number of functions which can be chained to the create_tables method. 

### Column
Below is an example of an id column which auto increments. 
```
$ql->create_table('users')
     ->column('id')->integer(11)->auto()->null(0)
     ->go();
```

### Column Datatypes

Each datatype method should be followed by the null method. Null value can be 0,1. This method is used to make the filed NULL or NOT NULL.

A full table creation example can be found below. 

#### Integer 
```
column('id')->integer( $length )->null(0) 
```

#### Float
```
column('amount')->float( $length , $decimal )->null(0) 
```

#### String
```
column('name')->string( $length )->null(0) 
```

#### Text
```
column('description')->text()->null(0) 
```

#### Boolean 
```
column('active')->boolean()->null(0)
```

#### Date 
```
column('brithday')->date()->null(0)
```

#### Datetime
```
column('created_at')->datetime()->null(0)
```

#### Time
```
column('meeting_time')->time()->null(0)
```

#### Year 
```
column('active_since')->year()->null(0)
```

#### Blob 
```
column('ablob')->blob( $length )->null(0)
```

### Additional Methods 
The below methods are used to complete the creation of a table.

### Timestamp fields 
The method timestamps will add a created_at and updated_at field to your table.
```
timestamps()
```

### Softdeletes
The softdeletes method will add deleted_at and deleted_by fields to your table. Softdeletes should only be used if your application also has a users table with a primary key of 'id'. 
```
softdeletes()
```


#### Null
The null() method is appended to the column datatype methods and can be 0 or 1. 

```
column('id')->integer(11)->null(0);
```

#### Foreign 
The foreign() method is used to specify a foriegn key within a table and should be included in the query after the primary key declaration. 
```
foreign('user_id', 'users', 'id')
```

### Creating a database table example 

```
// Creating the users table 
$ql->create_table('users')
    ->column('id')->integer(11)->auto()->null(0)
    ->column('name')->string(256)->null(0)
    ->column('company')->string(256)->null(1)
    ->go();


// Creating the addresses table
$ql->create_table('addresses')
    ->column('id')->integer(11)->auto()->null(0)
    ->column('user_id')->integer(11)->null(0)
    ->column('address_1')->string(256)->null(0)
    ->column('address_2')->string(256)->null(1)
    ->column('address_3')->string(256)->null(1)
    ->column('town')->string(256)->null(0)
    ->column('postcode')->string(256)->null(0)
    ->foreign('user_id', 'users', 'id')
    ->go();        
```


## SELECT 
```
$ql->select(string $fields, string $table, boolean $includeSoftDeletes = null)->get();
```
__If you application does not use softdeletes, you must set the $includeSoftDeletes param to true.__

__As of version 1.0 the select method will have $includeSoftDeletes default set to true, so if your application does not use soft deletes, you will no longer need to set this parameter.__
```
$ql->select('name, company', 'users', true)->get();
```
### Adding a WHERE Clause

```
where(string $field, string $operator, string $comparison)
```

```
$ql->select('*', 'users', true)
     ->where('name', '=', 'John Doe')
     ->get();
```
Multiple WHERE clauses can be used by chaining together: 
```
$ql->select('*', 'users', true)
     ->where('name', '=', 'John Doe')
     ->where('id', '!=', 1)
     ->get();
```

### Ordering results
```
order(string $field, string $direction)
```
```
$ql->select('*', 'users', true)
     ->order('id', 'DESC')
     ->get();
```

### Limiting Results
-1 can be used for the limit value to return every result
```
limit(int $limit, int $offset)
```
```
$ql->select('*', 'users', true)
     ->limit(10, 0)
     ->get();
```

## Inserting data into a table
```
$ql->insert(string $tableName, array $data);
```

```
$ql->insert(
    'users', 
    array(
        'name' => 'John Doe',
        'company'  => 'Microsoft'
    )
);
```

## Updating data in a table 
```
$ql->update(string $tableName, array $data)->where(string $field, string $operator, string $comparison)->exec();
```

```
$ql->update( 
       'users', 
       array('company' => 'Google')
    )->where('id', '=', 1)
     ->exec()
```

## Deleting from a table 
```
$ql->delete(string $tableName, array $data);
```
```
$ql->delete('users', array('id' => 1))
     ->exec()
```
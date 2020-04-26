# QLite v0.5 - PDO Class 

QLite is a PHP PDO database class designed to make connections with a MySQL database efficient and clean. 

## Getting Started 

```
require('QLite/qlite.php');

use QLite\QLite;

$cfdb = new QLite('db_host', 'db_name', 'db_user', 'db_password');
```

## Creating Tables 
```
$cfdb->create_table(string $tableName);
```

```
$cfdb->create_table('users')
     ->go();
```

There are a number of functions which can be chained to the create_tables method. 

### Column
Below is an example of an id column which auto increments. 
```
$cfdb->create_table('users')
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

#### Null
The null() method is appended to the column datatype methods and can be 0 or 1. 

```
column('id')->integer(11)->null(0);
```

#### Primary
The primary() method is used to specify the primary key for the table and should be included in the query after all the table columns have been specified. 

```
primary('id')
```

#### Foreign 
The foreign() method is used to specify a foriegn key within a table and should be included in the query after the primary key declaration. 
```
foreign('user_id', 'users', 'id')
```

#### Charcholl
The charcholl() method is used to specify the tables character set and collate. This method should be the last in the query. 
```
charcoll('utf8', 'utf8_general_ci')
```

### Creating a database table example 

```
// Creating the users table 
$cfdb->create_table('users')
    ->column('id')->integer(11)->auto()->null(0)
    ->column('name')->string(256)->null(0)
    ->column('company')->string(256)->null(1)
    ->primary('id')
    ->charcoll()
    ->go();


// Creating the addresses table
$cfdb->create_table('addresses')
    ->column('id')->integer(11)->auto()->null(0)
    ->column('user_id')->integer(11)->null(0)
    ->column('address_1')->string(256)->null(0)
    ->column('address_2')->string(256)->null(1)
    ->column('address_3')->string(256)->null(1)
    ->column('town')->string(256)->null(0)
    ->column('postcode')->string(256)->null(0)
    ->primary('id')
    ->foreign('user_id', 'users', 'id')
    ->charcoll()
    ->go();        
```


## SELECT 
```
$cfdb->select(string $fields, string $table)->get();
```
```
$cfdb->select('name, company', 'users')->get();
```
### Adding a WHERE Clause

```
where(string $field, string $operator, string $comparison)
```

```
$cfdb->select('*', 'users')
     ->where('name', '=', 'John Doe')
     ->get();
```
Multiple WHERE clauses can be used by chaining together: 
```
$cfdb->select('*', 'users')
     ->where('name', '=', 'John Doe')
     ->where('id', '!=', 1)
     ->get();
```

### Ordering results
```
order(string $field, string $direction)
```
```
$cfdb->select('*', 'users')
     ->order('id', 'DESC')
     ->get();
```

### Limiting Results
-1 can be used for the limit value to return every result
```
limit(int $limit, int $offset)
```
```
$cfdb->select('*', 'users')
     ->limit(10, 0)
     ->get();
```

## Inserting data into a table
```
$cfdb->insert(string $tableName, array $data);
```

```
$cfdb->insert(
    'users', 
    array(
        'name' => 'John Doe',
        'company'  => 'Microsoft'
    )
);
```

## Updating data in a table 
```
$cfdb->update(string $tableName, array $data)->where(string $field, string $operator, string $comparison)->exec();
```

```
$cfdb->update( 
       'users', 
       array('company' => 'Google')
    )->where('id', '=', 1)
     ->exec()
```

## Deleting from a table 
```
$cfdb->delete(string $tableName, array $data);
```
```
$cfdb->delete('users', array('id' => 1))
     ->exec()
```

## General query method
### Execute your own SQL query 
```
$cfdb->q(string $query);
```
```
$cfdb->q("SELECT * FROM users");
```
# QLite v0.4 - PDO Class 

QLite is a PHP PDO database class designed to make connections with a MySQL database efficient and clean. 

## Getting Started 

```
require('QLite/qlite.php');

use QLite\QLite;

$cfdb = new QLite('db_host', 'db_name', 'db_user', 'db_password');
```

## SELECT 
```
$cfdb->select(string $fields, string $table)->get();
```
```
$cfdb->select('name, age', 'person')->get();
```
### Adding a WHERE Clause

```
where(string $field, string $operator, string $comparison)
```

```
$cfdb->select('*', 'person')
     ->where('name', '=', 'John Doe')
     ->get();
```
Multiple WHERE clauses can be used by chaining together: 
```
$cfdb->select('*', 'person')
     ->where('name', '=', 'John Doe')
     ->where('age', '>', 30)
     ->where('id', '!=', 1)
     ->get();
```

### Ordering results
```
order(string $field, string $direction)
```
```
$cfdb->select('*', 'person')
     ->order('id', 'DESC')
     ->get();
```

### Limiting Results
-1 can be used for the limit value to return every result
```
limit(int $limit, int $offset)
```
```
$cfdb->select('*', 'person')
     ->limit(10, 0)
     ->get();
```

## Inserting data into a table
```
$cfdb->insert(string $tableName, array $data);
```

```
$cfdb->insert(
    'person', 
    array(
        'name' => 'John Doe',
        'age'  => 24
    )
);
```

## Updating data in a table 
```
$cfdb->update(string $tableName, array $data)->where(string $field, string $operator, string $comparison)->exec();
```

```
$cfdb->update( 
    'person', 
    array(
        'name' => 'Jonny Doe', 
        'age' => 33) 
    )->where('id', '=', 1)
     ->exec()
```

## Deleting from a table 
```
$cfdb->delete(string $tableName, array $data);
```
```
$cfdb->delete('person', array('id' => 1))
     ->exec()
```

## General query method
### Execute your own SQL query 
```
$cfdb->q(string $query);
```
```
$cfdb->q("SELECT * FROM person");
```

## Creating Tables 
```
$cfdb->create_table(string $tableName);
```

```
$cfdb->create_table('test_table')
     ->column('id')->integer(11)->null(0)
     ->column('name')->string(256)->null(0)
     ->column('company')->string(256)->null(1)
     ->primary('id')
     ->charcoll()
     ->go();
```

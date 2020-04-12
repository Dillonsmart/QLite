# QLite v0.2
## PDO class for MySQL

QLite is a basic class used to interact with a MySQL database. QLite extends the database class.  

```
$cfdb = new QLite(DB_HOST, DB_NAME, DB_USER, DB_PASS);
```

## General query method
### Execute your own SQL query 
```
$cfdb->q(string $query);
```
```
$cfdb->q("SELECT * FROM person");
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

## Creating Tables 
```
$cfdb->create_table(string $tableName, array $columns);
```

```
$cfdb->create_table(
    'person',
    array(
        array(
            'name'     => 'id',                      // name of the columns
            'datatype' => 'INT',                     // the column datatype
            'att'      => 'AUTO_INCREMENT NOT NULL', // additional
            'pk'       => true                       // is primary key
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
```

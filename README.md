# QLite 
## PDO class for MySQL

QLite is a basic class used to interact with a MySQL database. QLite extends the database class.  

```
$cfdb = new QLite(DB_HOST, DB_NAME, DB_USER, DB_PASS);
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

## Simple select statement 
```
$cfdb->select(string $tableName, array $columns, int $limit)
```

```
$cfdb->select(
    'person',
    array(
        '*'
    ),
    1
);
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
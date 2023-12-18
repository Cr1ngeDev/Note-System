<?php

function get_db_config() :string
{
    $config = [
        'dbname' => 'notes',
        'host' => 'localhost'
    ];
   return  "mysql:" . http_build_query($config, '', ';');
}

function connect() :PDO
{
    $dsn = get_db_config();
    $user = 'root';
    $password = '0375Ihor_';
    try {
        $pdo = new PDO($dsn, $user, $password);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    } catch(Exception $e)
    {
        die("Connection failed: " . $e->getMessage());
    }
}

function set_query(PDO $pdo, string $query, array $condition_values = []) :PDO|false|PDOStatement
{
    if(empty($condition_values)) {
        return $pdo->query($query);
    }
    try{
        $stmt = $pdo->prepare($query);
        foreach ($condition_values as $key => $value){
            // если ключи параметров указаны с двоеточием спереди
            if(preg_match('/^:/', $key)){
                $stmt->bindValue($key, $value);
                continue;
            }
            // на случай случайного продублирования двоеточия
            if(preg_match('/^:{2,}/', $key)){
                $key = preg_replace('/^:{2,}/', ':', $key);
                $stmt->bindValue($key, $value);
                continue;
            }
            $stmt->bindValue(":".$key, $value);
        }
    } catch (PDOException $e){
        echo "Error: ".$e->getMessage();
    }
    if($stmt->execute())
    {
        return $stmt;
    }
    return false;
}



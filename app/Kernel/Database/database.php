<?php

function get_db_config() :string
{
    $config = [
        'dbname' => 'notes',
        'host'   => 'mysql', //mysql-service
        //'port' => '3306' //3306
    ];
   return  "mysql:" . http_build_query($config, '', ';');
}

function connect() :PDO
{
    $dsn = get_db_config();
    $user = 'ihor';
    $password = 'Ihorbase75_';
    try {
        $pdo = new PDO($dsn, $user, $password);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    } catch(PDOException $e) {
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
    } finally {
        $pdo = null;
    }
    if($stmt->execute())
    {
        return $stmt;
    }
    return false;
}

function findOrFail($statement): array
{
    if(!$statement){
        abort();
    }
    return $statement;
}

function addToVerifyDB(int $user_id, string $hashCode): bool
{
    $pdo = connect();
    $is_okey = false;
    try {
        if (deleteFromVerifyDB($user_id)){
            $sql= "INSERT INTO verification(user_id, verify_code) VALUES(:user_id, :verify_code)";
            $stmt = set_query($pdo, $sql, [':user_id' => $user_id, ':verify_code' => $hashCode]);
            $pdo = null;
            $is_okey = true;
        }
    } catch (Exception $e){
        die($e->getMessage());
    } finally {
        $pdo = null;
    }
    return $is_okey;
}
function deleteFromVerifyDB(int $user_id)
{
    $pdo = connect();
    $is_okey = false;
    try {
        $sql_delete = "DELETE FROM verification WHERE user_id = :user_id";
        $stmt = set_query($pdo, $sql_delete, [':user_id' => $user_id]);
        $is_okey = true;
    } catch (Exception $e){
        die($e->getMessage());
    } finally {
        $pdo = null;
    }
    return $is_okey;
}
function getFromVerifyDB(string $user_id): array|false
{
    $pdo = connect();
    try {
        $sql = "SELECT user_id, verify_code, createdAt FROM verification WHERE user_id = :user_id";
        $stmt = set_query($pdo, $sql, ['user_id' => $user_id])->fetch(PDO::FETCH_ASSOC);
        $data = findOrFail($stmt);
        $pdo = null;
        if (empty($data)){
            return false;
        }
    } catch (Exception $e){
        die($e->getMessage());
    }
    return $data;
}
function getUserInfoBy(array $columns, array $preparedData,...$where): array|false
{
    if(count($where) >= 1){
        $columns = implode(', ', $columns);
        $fields  = implode(" AND ", array_map(fn($fields) => "$fields = :$fields", $where));
    }
    try {
        $pdo = connect();
        $sql = "SELECT $columns FROM user WHERE $fields LIMIT 1";;
        $user = set_query($pdo, $sql, $preparedData)->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e){
        return false;
    } finally {
        $pdo = null;
    }
    return $user;
}

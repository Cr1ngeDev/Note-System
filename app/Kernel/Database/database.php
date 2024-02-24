<?php

function get_db_config(): string
{
    $config = [
        'dbname' => 'notes',
        'host' => 'mysql', //mysql | localhost
        //'port' => '3306' //3306
    ];
    return "mysql:" . http_build_query($config, '', ';');
}

function connect(): PDO
{
    $dsn = get_db_config();
    $user = 'dev';
    $password = 'Devbase75_';
    try {
        $pdo = new PDO($dsn, $user, $password);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}


function set_query(PDO $pdo, string $query, array $condition_values = []): PDO|false|PDOStatement
{
    if (empty($condition_values)) {
        return $pdo->query($query);
    }
    try {
        $stmt = $pdo->prepare($query);
        foreach ($condition_values as $key => $value) {
            // если ключи параметров указаны с двоеточием спереди
            if (preg_match('/^:/', $key)) {
                $stmt->bindValue($key, $value);
                continue;
            }
            // на случай случайного продублирования двоеточия
            if (preg_match('/^:{2,}/', $key)) {
                $key = preg_replace('/^:{2,}/', ':', $key);
                $stmt->bindValue($key, $value);
                continue;
            }
            $stmt->bindValue(":" . $key, $value);
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        $pdo = null;
    }
    if ($stmt->execute()) {
        return $stmt;
    }
    return false;
}

function findOrFail($statement): array
{
    if (!$statement) {
        abort();
    }
    return $statement;
}

function addToVerifyDB(int $user_id, string $hashCode): bool
{
    $pdo = connect();
    $is_okey = false;
    try {
        if (deleteFromVerifyDB($user_id)) {
            $sql = "INSERT INTO verification(user_id, verify_code) VALUES(:user_id, :verify_code)";
            $stmt = set_query($pdo, $sql, [':user_id' => $user_id, ':verify_code' => $hashCode]);
            $pdo = null;
            $is_okey = true;
        }
    } catch (Exception $e) {
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
    } catch (Exception $e) {
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
        if (empty($data)) {
            return false;
        }
    } catch (Exception $e) {
        die($e->getMessage());
    }
    return $data;
}

function getUserInfoBy(array $columns, array $preparedData, ...$where): array|false
{
    if (count($where) >= 1) {
        $columns = implode(', ', $columns);
        $fields = implode(" AND ", array_map(fn($fields) => "$fields = :$fields", $where));
    }
    try {
        $pdo = connect();
        $sql = "SELECT $columns FROM user WHERE $fields LIMIT 1";;
        $user = set_query($pdo, $sql, $preparedData)->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        return false;
    } finally {
        $pdo = null;
    }
    return $user;
}

function saveNoteDB(int $user_id, string $createdAt, string $content, string $title = ''): bool
{
    $pdo = connect();
    $flag = false;
    try {
        $pdo->beginTransaction();
        set_query($pdo, "INSERT INTO note_preview(note_name, user_id, createdAt) VALUES (:note_name, :user_id, :createdAt)",
            [
                ':note_name' => $title,
                ':user_id' => $user_id,
                ':createdAt' => $createdAt
            ]
        );

        $lastConnectedId = $pdo->lastInsertId();

        set_query($pdo, "INSERT INTO note_content(text, preview_id) VALUES (:text, :preview_id)",
            ['text' => $content, 'preview_id' => $lastConnectedId]);

        $pdo->commit();
        $flag = true;
    } catch (PDOException $e) {
        $pdo->rollBack();
        exit("DB Error: " . $e->getMessage());
    } finally {
        $pdo = null;
    }
    return $flag;
}

function updateNoteDB(int $user_id, string $createdAt, string $noteId, string $content, string $title = ''): bool
{
    $pdo = connect();
    $flag = false;
    try {
        $pdo->beginTransaction();
        set_query($pdo, "UPDATE note_preview SET note_name = :note_name, user_id = :user_id, createdAt = :createdAt WHERE id = :id",
            [
                ':note_name' => $title,
                ':user_id' => $user_id,
                ':createdAt' => $createdAt,
                ":id" => $noteId
            ]
        );

        set_query($pdo, "UPDATE note_content SET text = :text WHERE preview_id = :preview_id",
            ['text' => $content, 'preview_id' => $noteId]);

        $pdo->commit();
        $flag = true;
    } catch (PDOException $e) {
        $pdo->rollBack();
        die("DB error: " . $e->getMessage());
    } finally {
        $pdo = null;
    }
    return $flag;
}

function updateUserInfo(array $difference, int $user_id): bool
{
    $flag = false;
    $pdo = connect();
    try {
        $diff_keys = array_keys($difference);
        $fields = implode(', ', array_map(fn($diff_keys) => "$diff_keys = :$diff_keys", $diff_keys));
        $sql = "UPDATE user SET $fields WHERE user_id = :user_id";

        $values = array_merge($difference, ['user_id' => $user_id]);

        $pdo->beginTransaction();
        $is_updated = set_query($pdo, $sql, $values);
        if ($is_updated !== false) {
            $pdo->commit();
            $flag = true;
        } else {
            $pdo->rollBack();
        }
    } catch (PDOException $e) {
        $pdo->rollBack();
        die($e->getMessage());
    } finally {
        $pdo = null;
    }
    return $flag;
}

function deleteUser(int $user_id): void
{
    $pdo = connect();
    try {
        $pdo->beginTransaction();
        $sql = "DELETE FROM user WHERE user_id = :user_id";
        set_query($pdo, $sql, [':user_id' => $user_id]);
        $pdo->commit();
        session_flash('user');
        session_flash('TOKEN');
    } catch (PDOException $e) {
        $pdo->rollBack();
        die($e->getMessage());
    } finally {
        $pdo = null;
    }
}

function updatePasswordDB(string $password, int $user_id): bool
{
    $pdo = connect();
    $flag = false;
    try {
        $pdo->beginTransaction();
        $sql = "UPDATE user SET password = :newPassword WHERE user_id = :user_id";
        $change = set_query($pdo, $sql, [':newPassword' => password_hash($password, PASSWORD_BCRYPT), ':user_id' => $user_id]);
        if ($change !== false) {
            $pdo->commit();
            $flag = true;
        }
    } catch (Exception $e) {
        $pdo->rollBack();
        echo $e->getMessage();
    } finally {
        $pdo = null;
    }
    return $flag;
}

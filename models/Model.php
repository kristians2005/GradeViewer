<?php
require_once 'dataBase.php';

abstract class Model
{
    protected static $db;

    public static function init()
    {
        if (!self::$db) {
            self::$db = new Database();
        }
    }
    abstract protected static function getTableName(): string;

    public static function all()
    {
        self::init();
        $sql = "SELECT * FROM " . static::getTableName();

        $records = self::$db->query($sql)->fetchAll();
        return $records ?: [];
    }

    public static function register($name, $email, $password)
    {
        self::init();


        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO " . static::getTableName() . " (name, email, password) VALUES (:name, :email, :password)";

        $records = self::$db->query($sql, [":name" => $name, ":email" => $email, ":password" => $hashedPassword]);
        return $records;

    }

    public static function login($email, $password)
    {
        self::init();
        $sql = "SELECT * FROM " . static::getTableName() . " WHERE email = :email";
        $records = self::$db->query($sql, [":email" => $email])->fetch();
        if (!$records) {
            return false;
        }
        if (password_verify($password, $records['password'])) {
            return true;
        }
        return false;
    }

    public static function getUser($email)
    {
        self::init();
        $sql = "SELECT * FROM " . static::getTableName() . " WHERE email = :email";
        $records = self::$db->query($sql, [":email" => $email])->fetch();
        return $records;
    }

    public static function find(int $id): ?array
    {
        self::init();
        $sql = "SELECT * FROM " . static::getTableName() . " WHERE id = :id LIMIT 1";

        $record = self::$db->query($sql, [":id" => $id])->fetch();
        return $record ?: null;
    }

    public static function emailExists($email)
    {
        self::init();
        $sql = "SELECT COUNT(*) FROM " . static::getTableName() . " WHERE email = :email";
        $count = self::$db->query($sql, [":email" => $email])->fetchColumn();
        return $count > 0;
    }

    public static function create(array $data): bool
    {
        self::init();
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));

        $sql = "INSERT INTO " . static::getTableName() . " ($columns) VALUES ($placeholders)";

        return self::$db->query($sql, $data) ? true : false;
    }

    public static function updateUser(int $id, array $data)
    {
        self::init();

        $sql = "UPDATE " . static::getTableName() . " SET name = :name, email = :email, roles = :roles WHERE id = :id";

        $records = self::$db->query($sql, [":name" => $data["name"], ":email" => $data["email"], ":roles" => $data["roles"], ":id" => $id]);
        return $records;
        ;
    }

    public static function destroy(int $id): bool
    {
        self::init();
        $sql = "DELETE FROM " . static::getTableName() . " WHERE id = :id";
        return self::$db->query($sql, [":id" => $id]) ? true : false;
    }

    public static function lowStockProducts()
    {
        self::init();
        $sql = "SELECT * FROM inventory WHERE quantity < 10";
        $records = self::$db->query($sql)->fetchAll();
        return $records ?: [];
    }

    public static function productCount()
    {
        self::init();
        $sql = "SELECT COUNT(*) FROM products ";
        $count = self::$db->query($sql)->fetchColumn();
        return $count;
    }

    public static function orderCount()
    {
        self::init();
        $sql = "SELECT COUNT(*) FROM orders ";
        $count = self::$db->query($sql)->fetchColumn();
        return $count;
    }

}
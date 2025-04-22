<?php
require_once "models/Model.php";

class Product extends Model
{
    protected static function getTableName(): string
    {
        return "products";
    }

    public static function all()
    {
        self::init();
        $sql = "SELECT * FROM " . self::getTableName();
        return self::$db->query($sql)->fetchAll() ?: [];
    }

    public static function find(int $id): ?array
    {
        self::init();
        $sql = "SELECT * FROM " . self::getTableName() . " WHERE id = :id LIMIT 1";
        return self::$db->query($sql, [":id" => $id])->fetch() ?: null;
    }
    public static function update(int $id, array $data): bool
    {
        self::init();

        $setPart = [];
        $params = [":id" => $id];

        foreach ($data as $key => $value) {
            $setPart[] = "$key = :$key";
            $params[":$key"] = $value;
        }

        $sql = "UPDATE " . self::getTableName() . " SET " . implode(", ", $setPart) . " WHERE id = :id";

        return self::$db->query($sql, $params)->rowCount() > 0;
    }
}

<?php

require_once "models/Model.php";

class Inventory extends Model
{
    protected static function getTableName(): string
    {
        return "inventory";
    }
    public static function all()
    {
        self::init();
        $sql = "SELECT * FROM " . self::getTableName();

        $records = self::$db->query($sql)->fetchAll();
        return $records ?: [];
    }
    public static function find(int $id): ?array
    {
        self::init();
        $sql = "SELECT * FROM " . self::getTableName() . " WHERE id = :id LIMIT 1";

        $record = self::$db->query($sql, [":id" => $id])->fetch();
        return $record ?: null;
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

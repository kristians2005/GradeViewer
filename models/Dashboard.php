<?php

require_once "models/Model.php";

class Dashboard extends Model
{
    protected static function getTableName(): string
    {
        return "products";
    }
}

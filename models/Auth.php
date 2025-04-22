<?php

require_once "models/Model.php";

class Auth extends Model
{
    protected static function getTableName(): string
    {
        return "users";
    }
}

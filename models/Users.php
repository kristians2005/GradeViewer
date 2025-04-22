<?php



require_once "models/Model.php";

class Users extends Model
{
    protected static function getTableName(): string
    {
        return "users";
    }



}
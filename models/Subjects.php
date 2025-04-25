<?php



require_once "models/Model.php";

class Subjects extends Model
{
    protected static function getTableName(): string
    {
        return "subjects";
    }



}
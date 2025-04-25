<?php



require_once "models/Model.php";

class Users extends Model
{
    protected static function getTableName(): string
    {
        return "users";
    }
// In Users.php
public static function getSubjectsWithGrades($user_id)
{
    self::init();
    
    $sql = "SELECT s.id, s.subject_name, 
                 AVG(g.grade) as average_grade,
                 COUNT(g.id) as grade_count
          FROM subjects s
          JOIN user_subjects us ON s.id = us.subject_id
          LEFT JOIN grades g ON s.id = g.subject_id AND g.student_id = :user_id
          WHERE us.user_id = :user_id
          GROUP BY s.id, s.subject_name";
    
    return self::$db->query($sql, [":user_id" => $user_id])->fetchAll();
}


}
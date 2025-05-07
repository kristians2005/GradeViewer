<?php

require_once "models/Model.php";

class Student extends Model
{
    protected static function getTableName(): string
    {
        return "students";
    }

    public static function getStudentInfo($user_id)
    {
        self::init();
        
        $sql = "SELECT s.*, u.first_name, u.last_name, u.nick_name, c.class_name,
                t.first_name as teacher_first_name, t.last_name as teacher_last_name
                FROM students s 
                JOIN users u ON s.user_id = u.id 
                LEFT JOIN classes c ON s.class_id = c.id 
                LEFT JOIN users t ON c.teacher_id = t.id
                WHERE s.user_id = :user_id";
                
        return self::$db->query($sql, [":user_id" => $user_id])->fetch();
    }

    public static function getStudentGrades($student_id)
    {
        self::init();
        
        $sql = "SELECT g.*, s.subject_name 
                FROM grades g 
                JOIN subjects s ON g.subject_id = s.id 
                WHERE g.student_id = :student_id 
                ORDER BY g.grade_date DESC";
                
        return self::$db->query($sql, [":student_id" => $student_id])->fetchAll();
    }

    public static function getStudentSubjects($student_id)
    {
        self::init();
        
        $sql = "SELECT s.*, 
                (SELECT AVG(grade) FROM grades WHERE subject_id = s.id AND student_id = :student_id) as average_grade
                FROM subjects s 
                JOIN students st ON s.class_id = st.class_id 
                WHERE st.id = :student_id";
                
        return self::$db->query($sql, [":student_id" => $student_id])->fetchAll();
    }
} 
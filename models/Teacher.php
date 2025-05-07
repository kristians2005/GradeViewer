<?php

require_once "models/Model.php";

class Teacher extends Model
{
    protected static function getTableName(): string
    {
        return "users";
    }

    public static function getTeacherInfo($user_id)
    {
        self::init();
        
        $sql = "SELECT u.*, 
                (SELECT COUNT(*) FROM classes WHERE teacher_id = u.id) as total_classes,
                (SELECT COUNT(*) FROM students s 
                 JOIN classes c ON s.class_id = c.id 
                 WHERE c.teacher_id = u.id) as total_students
                FROM users u 
                WHERE u.id = :user_id AND u.role = 'teacher'";
                
        return self::$db->query($sql, [":user_id" => $user_id])->fetch();
    }

    public static function getTeacherClasses($teacher_id)
    {
        self::init();
        
        $sql = "SELECT c.*, 
                (SELECT COUNT(*) FROM students WHERE class_id = c.id) as student_count
                FROM classes c 
                WHERE c.teacher_id = :teacher_id";
                
        return self::$db->query($sql, [":teacher_id" => $teacher_id])->fetchAll();
    }

    public static function getClassStudents($class_id)
    {
        self::init();
        
        $sql = "SELECT s.*, u.first_name, u.last_name, u.nick_name,
                (SELECT AVG(grade) FROM grades g 
                 JOIN subjects sub ON g.subject_id = sub.id 
                 WHERE g.student_id = s.id AND sub.class_id = :class_id) as class_average
                FROM students s 
                JOIN users u ON s.user_id = u.id 
                WHERE s.class_id = :class_id";
                
        return self::$db->query($sql, [":class_id" => $class_id])->fetchAll();
    }

    public static function getAvailableStudents($class_id)
    {
        self::init();
        
        $sql = "SELECT u.id, u.first_name, u.last_name, u.nick_name
                FROM users u 
                LEFT JOIN students s ON u.id = s.user_id
                WHERE u.role = 'student' 
                AND (s.class_id IS NULL OR s.class_id != :class_id)";
                
        return self::$db->query($sql, [":class_id" => $class_id])->fetchAll();
    }

    public static function addStudentToClass($student_id, $class_id)
    {
        self::init();
        
        // First check if student already exists
        $sql = "SELECT id FROM students WHERE user_id = :user_id";
        $student = self::$db->query($sql, [":user_id" => $student_id])->fetch();
        
        if ($student) {
            // Update existing student
            $sql = "UPDATE students SET class_id = :class_id WHERE user_id = :user_id";
        } else {
            // Create new student record
            $sql = "INSERT INTO students (user_id, class_id) VALUES (:user_id, :class_id)";
        }
        
        return self::$db->query($sql, [
            ":user_id" => $student_id,
            ":class_id" => $class_id
        ]);
    }

    public static function removeStudentFromClass($student_id, $class_id)
    {
        self::init();
        
        // First verify that the student is in this class
        $sql = "SELECT id FROM students WHERE user_id = :user_id AND class_id = :class_id";
        $student = self::$db->query($sql, [
            ":user_id" => $student_id,
            ":class_id" => $class_id
        ])->fetch();
        
        if ($student) {
            // Remove the student from the class
            $sql = "UPDATE students SET class_id = NULL WHERE user_id = :user_id AND class_id = :class_id";
            return self::$db->query($sql, [
                ":user_id" => $student_id,
                ":class_id" => $class_id
            ]);
        }
        
        return false;
    }

    public static function getClassSubjects($class_id)
    {
        self::init();
        
        $sql = "SELECT s.*, 
                (SELECT COUNT(*) FROM grades g WHERE g.subject_id = s.id) as total_grades,
                (SELECT AVG(grade) FROM grades g WHERE g.subject_id = s.id) as subject_average
                FROM subjects s 
                WHERE s.class_id = :class_id";
                
        return self::$db->query($sql, [":class_id" => $class_id])->fetchAll();
    }

    public static function getStudentGrades($student_id, $class_id = null)
    {
        self::init();
        
        $sql = "SELECT g.*, s.subject_name, s.id as subject_id
                FROM grades g 
                JOIN subjects s ON g.subject_id = s.id 
                WHERE g.student_id = :student_id";
        
        $params = [":student_id" => $student_id];
        
        if ($class_id) {
            $sql .= " AND s.class_id = :class_id";
            $params[":class_id"] = $class_id;
        }
        
        $sql .= " ORDER BY g.grade_date DESC";
                
        return self::$db->query($sql, $params)->fetchAll();
    }

    public static function addGrade($student_id, $subject_id, $grade, $grade_date)
    {
        self::init();
        
        $sql = "INSERT INTO grades (student_id, subject_id, grade, grade_date) 
                VALUES (:student_id, :subject_id, :grade, :grade_date)";
                
        return self::$db->query($sql, [
            ":student_id" => $student_id,
            ":subject_id" => $subject_id,
            ":grade" => $grade,
            ":grade_date" => $grade_date
        ]);
    }

    public static function updateGrade($grade_id, $grade, $grade_date)
    {
        self::init();
        
        $sql = "UPDATE grades 
                SET grade = :grade, grade_date = :grade_date 
                WHERE id = :grade_id";
                
        return self::$db->query($sql, [
            ":grade_id" => $grade_id,
            ":grade" => $grade,
            ":grade_date" => $grade_date
        ]);
    }

    public static function deleteGrade($grade_id)
    {
        self::init();
        
        $sql = "DELETE FROM grades WHERE id = :grade_id";
        return self::$db->query($sql, [":grade_id" => $grade_id]);
    }
} 
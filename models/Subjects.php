<?php



require_once "models/Model.php";

class Subjects extends Model
{
    protected static function getTableName(): string
    {
        return "subjects";
    }
    public static function getAllAvailableSubjects()
    {
        self::init();
        $sql = "SELECT id, subject_name FROM Subjects ORDER BY subject_name";
        return self::$db->query($sql)->fetchAll();
    }
    public static function assignSubject($subjectId, $userId)
    {
        self::init();

        try {
            // Check if the subject is already assigned
            $checkSql = "SELECT id FROM User_Subjects 
                        WHERE user_id = ? AND subject_id = ?";
            $exists = self::$db->query($checkSql, [$userId, $subjectId])->fetch();

            if (!$exists) {
                // If not assigned, insert new record
                $sql = "INSERT INTO User_Subjects (user_id, subject_id) 
                       VALUES (?, ?)";
                return self::$db->query($sql, [$userId, $subjectId]);
            }

            return false; // Subject already assigned

        } catch (PDOException $e) {
            // Log error or handle it appropriately
            error_log("Error assigning subject: " . $e->getMessage());
            return false;
        }
    }

}
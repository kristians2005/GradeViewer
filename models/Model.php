<?php
require_once 'dataBase.php';

abstract class Model
{
    protected static $db;

    public static function init()
    {
        if (!self::$db) {
            self::$db = new Database();
        }
    }
    abstract protected static function getTableName(): string;

    public static function all()
    {
        self::init();
        $sql = "SELECT * FROM " . static::getTableName();

        $records = self::$db->query($sql)->fetchAll();
        return $records ?: [];
    }

    public static function allStudents()
    {
        self::init();
        $sql = "SELECT 
                u.id,
                u.first_name,
                u.last_name,
                COALESCE(AVG(g.grade), 0) as average_grade
            FROM Users u
            INNER JOIN Teachers_students ts ON u.id = ts.student_id
            LEFT JOIN Grades g ON u.id = g.student_id
            WHERE ts.teacher_id = :teacher_id
            GROUP BY u.id, u.first_name, u.last_name";

        $records = self::$db->query($sql, [
            ':teacher_id' => $_SESSION['user_id']
        ])->fetchAll();

        return $records ?: [];
    }

    public static function getAllSubjects()
    {
        self::init();
        $sql = "SELECT 
            s.id,
            s.subject_name as name,
            COUNT(DISTINCT ts.student_id) as student_count,
            COALESCE(AVG(g.grade), 0) as average_grade
        FROM Subjects s
        INNER JOIN User_Subjects us ON s.id = us.subject_id
        INNER JOIN Users u ON us.user_id = u.id
        INNER JOIN Teachers_students ts ON u.id = ts.student_id
        LEFT JOIN Grades g ON s.id = g.subject_id AND ts.student_id = g.student_id
        WHERE ts.teacher_id = :teacher_id
        GROUP BY s.id, s.subject_name";

        $records = self::$db->query($sql, [
            ':teacher_id' => $_SESSION['user_id']
        ])->fetchAll();

        return $records ?: [];
    }

    // public static function register($name, $nick_name, $password)
    // {
    //     self::init();


    //     $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    //     $sql = "INSERT INTO " . static::getTableName() . " (first_name, last_name, nick_name, password) VALUES (:first_name,:last_name, :nick_name, :password)";

    //     $records = self::$db->query($sql, [":first_name" => $name, ":last_name" => $name, ":nick_name" => $nick_name, ":password" => $hashedPassword]);
    //     return $records;

    // }

    public static function getSubjectsWithGradesForUser($user_id)
    {
        self::init();

        $sql = "SELECT s.id, s.subject_name, AVG(g.grade) as average_grade
                FROM subjects s
                JOIN user_subjects us ON s.id = us.subject_id
                LEFT JOIN grades g ON s.id = g.subject_id AND g.student_id = :user_id
                WHERE us.user_id = :user_id
                GROUP BY s.id, s.subject_name";

        $subjects = self::$db->query($sql, [":user_id" => $user_id])->fetchAll();
        return $subjects ?: [];
    }

    // public static function login($nick_name, $password)
    // {
    //     self::init();
    //     $sql = "SELECT * FROM " . static::getTableName() . " WHERE nick_name = :nick_name";
    //     $records = self::$db->query($sql, [":nick_name" => $nick_name])->fetch();
    //     if (!$records) {
    //         return false;
    //     }
    //     if (password_verify($password, $records['password'])) {
    //         return true;
    //     }
    //     return false;
    // }

    public static function getUser($nick_name)
    {
        self::init();
        $sql = "SELECT * FROM " . static::getTableName() . " WHERE nick_name = :nick_name";
        $records = self::$db->query($sql, [":nick_name" => $nick_name])->fetch();
        return $records;
    }

    public static function find(int $id): ?array
    {
        self::init();
        $sql = "SELECT * FROM " . static::getTableName() . " WHERE id = :id LIMIT 1";

        $record = self::$db->query($sql, [":id" => $id])->fetch();
        return $record ?: null;
    }

    public static function emailExists($nick_name)
    {
        self::init();
        $sql = "SELECT COUNT(*) FROM " . static::getTableName() . " WHERE nick_name = :nick_name";
        $count = self::$db->query($sql, [":nick_name" => $nick_name])->fetchColumn();
        return $count > 0;
    }

    public static function create(array $data): bool
    {
        self::init();
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));

        $sql = "INSERT INTO " . static::getTableName() . " ($columns) VALUES ($placeholders)";

        return self::$db->query($sql, $data) ? true : false;
    }

    public static function updateUser(int $id, array $data)
    {
        self::init();

        $sql = "UPDATE " . static::getTableName() . " SET name = :name, nick_name = :nick_name, roles = :roles WHERE id = :id";

        $records = self::$db->query($sql, [":name" => $data["name"], ":nick_name" => $data["nick_name"], ":roles" => $data["roles"], ":id" => $id]);
        return $records;
        ;
    }

    public static function destroy(int $id): bool
    {
        self::init();
        $sql = "DELETE FROM " . static::getTableName() . " WHERE id = :id";
        return self::$db->query($sql, [":id" => $id]) ? true : false;
    }


}
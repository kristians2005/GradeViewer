<?php

require_once "models/Model.php";

class Auth extends Model
{
    protected static function getTableName(): string
    {
        return "users";
    }

    public static function login($nick_name, $password)
    {
        self::init();
        
        $sql = "SELECT * FROM users WHERE nick_name = :nick_name";
        $user = self::$db->query($sql, [":nick_name" => $nick_name])->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            return true;
        }
        
        return false;
    }

    public static function getUser($nick_name)
    {
        self::init();
        
        $sql = "SELECT * FROM users WHERE nick_name = :nick_name";
        return self::$db->query($sql, [":nick_name" => $nick_name])->fetch();
    }

    public static function register($first_name, $last_name, $nick_name, $password, $role = 'student')
    {
        self::init();
        
        try {
            // Start transaction
            self::$db->beginTransaction();
            
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            
            // Insert user
            $sql = "INSERT INTO users (first_name, last_name, nick_name, password, role) 
                    VALUES (:first_name, :last_name, :nick_name, :password, :role)";
                    
            $result = self::$db->query($sql, [
                ":first_name" => $first_name,
                ":last_name" => $last_name,
                ":nick_name" => $nick_name,
                ":password" => $hashed_password,
                ":role" => $role
            ]);

            if ($result && $role === 'student') {
                $user_id = self::$db->lastInsertId();
                $sql = "INSERT INTO students (user_id) VALUES (:user_id)";
                $result = self::$db->query($sql, [":user_id" => $user_id]);
            }

            // Commit transaction
            self::$db->commit();
            return true;
            
        } catch (Exception $e) {
            // Rollback transaction on error
            self::$db->rollBack();
            error_log("Registration error: " . $e->getMessage());
            return false;
        }
    }

    public static function nickNameExists($nick_name)
    {
        self::init();
        
        $sql = "SELECT COUNT(*) as count FROM users WHERE nick_name = :nick_name";
        $result = self::$db->query($sql, [":nick_name" => $nick_name])->fetch();
        
        return $result['count'] > 0;
    }
}

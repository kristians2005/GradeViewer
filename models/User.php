<?php

class User
{
    public static function updateUserInfo($user_id, $data)
    {
        self::init();
        
        try {
            $sql = "UPDATE users SET 
                    first_name = :first_name,
                    last_name = :last_name,
                    nick_name = :nick_name
                    WHERE id = :user_id";
                    
            return self::$db->query($sql, [
                ":user_id" => $user_id,
                ":first_name" => $data['first_name'],
                ":last_name" => $data['last_name'],
                ":nick_name" => $data['nick_name']
            ]);
        } catch (Exception $e) {
            error_log("Error updating user info: " . $e->getMessage());
            return false;
        }
    }

    public static function updatePassword($user_id, $hashed_password)
    {
        self::init();
        
        try {
            $sql = "UPDATE users SET password = :password WHERE id = :user_id";
            return self::$db->query($sql, [
                ":user_id" => $user_id,
                ":password" => $hashed_password
            ]);
        } catch (Exception $e) {
            error_log("Error updating password: " . $e->getMessage());
            return false;
        }
    }

    public static function updateProfilePicture($user_id, $picture_path)
    {
        self::init();
        
        try {
            $sql = "UPDATE users SET profile_picture = :picture_path WHERE id = :user_id";
            return self::$db->query($sql, [
                ":user_id" => $user_id,
                ":picture_path" => $picture_path
            ]);
        } catch (Exception $e) {
            error_log("Error updating profile picture: " . $e->getMessage());
            return false;
        }
    }
} 
<?php


class Validator
{

    public static function Role(string $role = "")
    {
        if (!isset($_SESSION['user_role'])) {
            return false;
        }

        if ($role == '' && isset($_SESSION['user_role'])) {
            return true;
        }

        if ($_SESSION['user_role'] !== $role) {
            return false;
        }

        return true;
    }

    public static function email($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }


    }

    public static function required($string)
    {
        if (empty($string)) {
            return true;
        } else {
            return false;
        }
    }

    public static function strLengt($string, $min, $max)
    {
        if (strlen($string) > $min && strlen($string) < $max) {
            return true;
        } else {
            return false;
        }
    }

    public static function doseContainNum($string)
    {
        for ($i = 0; $i <= strlen($string) - 1; $i++) {
            if (is_numeric($string[$i])) {
                return false;
            }
        }
        return true;
    }

    public static function passwordMatch($password, $confirmPassword)
    {
        return $password === $confirmPassword;
    }

    public static function passwordContains($password)
    {
        $hasUpper = preg_match('/[A-Z]/', $password);
        $hasLower = preg_match('/[a-z]/', $password);
        $hasNumber = preg_match('/[0-9]/', $password);
        $hasSpecial = preg_match('/[^A-Za-z0-9]/', $password);

        return $hasUpper && $hasLower && $hasNumber && $hasSpecial;
    }

    public static function passwordLength($password)
    {
        return strlen($password) >= 8;
    }
}
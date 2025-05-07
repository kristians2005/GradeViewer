<?php

class Middleware {
    public static function checkRole($allowedRoles) {
        if (!isset($_SESSION['user_role'])) {
            header('Location: /welcome');
            exit();
        }

        if (!in_array($_SESSION['user_role'], $allowedRoles)) {
            header('Location: /');
            exit();
        }
    }

    public static function isLoggedIn() {
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
            header('Location: /welcome');
            exit();
        }
    }
} 
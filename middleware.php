<?php

class Middleware {
    public static function isLoggedIn() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /welcome");
            exit;
        }
    }

    public static function checkRole($allowed_roles) {
        self::isLoggedIn();

        // Convert single role to array if it's a string
        if (!is_array($allowed_roles)) {
            $allowed_roles = [$allowed_roles];
        }

        if (!isset($_SESSION['user_role']) || !in_array($_SESSION['user_role'], $allowed_roles)) {
            header("Location: /welcome");
            exit;
        }
    }
}
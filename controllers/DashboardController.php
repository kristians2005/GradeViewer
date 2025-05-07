<?php

require_once "middleware.php";

class DashboardController
{
    public function index()
    {
        //Middleware::isLoggedIn();
        if (isset($_SESSION['user_role'])) {
            // Redirect based on role
            switch ($_SESSION['user_role']) {
                case 'student':
                header('Location: /student/dashboard');
                break;
            case 'teacher':
                header('Location: /teacher/dashboard');
                break;
            default:
                require "views/Dashboard.view.php";
                break;
        }
        } else {
            require "views/Dashboard.view.php";
        }
    }
}
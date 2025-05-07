<?php

require "models/Auth.php";
// require "validator.php";

class AuthController
{



    public function login()
    {
        if (isset($_SESSION['logged_in'])) {
            header('Location: /');
            return;
        }

        $nick_name = $_POST['nick_name'];
        $password = $_POST['password'];

        $error = [];

        if (Validator::required($password)) {
            $error["password"] = "Password is required.";
        }

        if (Auth::login($nick_name, $password)) {
            $user = Auth::getUser($nick_name);
            if ($_SESSION == null) {
                session_start();
            }

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['nick_name'] = $user['nick_name'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['logged_in'] = true;

            header('Location: /');
            return;
        }

        $error["password"] = "Invalid nick_name or password.";
        require "views/Dashboard.view.php";

    }

    public function register()
    {
        if (isset($_SESSION['logged_in'])) {
            header('Location: /');
            return;
        }

        require "views/auth/Register.view.php";

    }

    public function logout()
    {

        // session_start();
        session_destroy();
        header('Location: /');
    }

    public function authenticate()
    {
        if (isset($_SESSION['logged_in'])) {
            header('Location: /');
            return;
        }

        $nick_name = $_POST['nick_name'];
        $password = $_POST['password'];

        $error = [];

        if (Validator::required($nick_name)) {
            $error["nick_name"] = "Nick name is required.";
        }

        if (Validator::required($password)) {
            $error["password"] = "Password is required.";
        }

        if (!empty($error)) {
            require "views/auth/Login.view.php";
            return;
        }

        if (Auth::login($nick_name, $password)) {
            $user = Auth::getUser($nick_name);
            if ($_SESSION == null) {
                session_start();
            }

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['nick_name'] = $user['nick_name'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['logged_in'] = true;

            header('Location: /');
            return;
        }

        $error["password"] = "Invalid nick_name or password.";
        require "views/auth/Login.view.php";
    }

    public function registerUser()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /register');
            exit;
        }

        $first_name = $_POST['first_name'] ?? '';
        $last_name = $_POST['last_name'] ?? '';
        $nick_name = $_POST['nick_name'] ?? '';
        $password = $_POST['password'] ?? '';
        $password_confirmation = $_POST['password_confirmation'] ?? '';

        $error = [];

        if (Validator::required($first_name)) {
            $error["first_name"] = "First name is required.";
        }

        if (Validator::required($last_name)) {
            $error["last_name"] = "Last name is required.";
        }

        if (Validator::required($nick_name)) {
            $error["nick_name"] = "Nick name is required.";
        }

        if (Validator::required($password)) {
            $error["password"] = "Password is required.";
        }

        if (!Validator::passwordMatch($password, $password_confirmation)) {
            $error["password"] = "Passwords do not match.";
        }

        if (!Validator::passwordContains($password)) {
            $error["password"] = "Password must contain at least one number, one uppercase letter, and one symbol.";
        }

        if (!Validator::passwordLength($password)) {
            $error["password"] = "Password must be at least 8 characters long.";
        }

        if (Auth::nickNameExists($nick_name)) {
            $error["nick_name"] = "This nick name is already registered. Please use a different one.";
        }

        if (empty($error)) {
            $result = Auth::register($first_name, $last_name, $nick_name, $password);
            if ($result) {
                // Auto login after successful registration
                $user = Auth::getUser($nick_name);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['first_name'] = $user['first_name'];
                $_SESSION['last_name'] = $user['last_name'];
                $_SESSION['nick_name'] = $user['nick_name'];
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['logged_in'] = true;
                
                header('Location: /');
                exit;
            } else {
                $error["general"] = "Registration failed. Please try again.";
            }
        }

        // If we get here, there were errors
        require "views/auth/Register.view.php";
    }



}
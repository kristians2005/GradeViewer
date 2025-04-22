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

        require "views/auth/Login.view.php";
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

        $email = $_POST['email'];
        $password = $_POST['password'];

        $error = [];

        if (!Validator::email($email)) {
            $error["email"] = "Please enter a valid email address.";
        }

        if (Validator::required($password)) {
            $error["password"] = "Password is required.";
        }

        if (!empty($error)) {
            require "views/auth/Login.view.php";
            return;
        }

        if (Auth::login($email, $password)) {
            $user = Auth::getUser($email);
            if ($_SESSION == null) {
                session_start();
            }

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['roles'];
            $_SESSION['logged_in'] = true;

            header('Location: /');
            return;
        }

        $error["password"] = "Invalid email or password.";
        require "views/auth/Login.view.php";
    }

    public function registerUser()
    {
        if (isset($_SESSION['logged_in'])) {
            header('Location: /');
            return;
        }

        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password_confirmation = $_POST['password_confirmation'];

        $error = [];

        if (Validator::required($name)) {
            $error["name"] = "Name is required.";
        }

        if (!Validator::strLengt($name, 3, 50)) {
            $error["name"] = "Name must be between 3 and 50 characters long.";
        }

        if (!Validator::passwordMatch($password, $password_confirmation)) {
            $error["password"] = "Passwords do not match.";
        }

        if (!Validator::passwordContains($password)) {
            $error["password"] = "Password must contain at least one number and one uppercase letter and one simbol.";
        }

        if (!Validator::passwordLength($password)) {
            $error["password"] = "Password must be at least 8 characters long.";
        }

        if (!Validator::email($email)) {
            $error["email"] = "Email is not valid.";
        }

        if (Auth::emailExists($email)) {
            $error["email"] = "This email is already registered. Please use a different email.";
        }



        //var_dump($error);

        if (empty($error)) {
            Auth::register($name, $email, $password);
            header('Location: /login');
        } else {
            require "views/auth/Register.view.php";
        }

    }



}
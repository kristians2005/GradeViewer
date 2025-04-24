<?php

require "models/Auth.php";
// require "validator.php";

class AuthController
{



    public function login()
    {
        var_dump($_POST);
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
            $_SESSION['user_role'] = $user['roles'];
            $_SESSION['logged_in'] = true;

            header('Location: /');
            return;
        }

        $error["password"] = "Invalid nick_name or password.";
        require "views/dashboard.view.php";

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

        if (!Validator::nick_name($nick_name)) {
            $error["nick_name"] = "Please enter a valid nick_name address.";
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
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['nick_name'] = $user['nick_name'];
            $_SESSION['user_role'] = $user['roles'];
            $_SESSION['logged_in'] = true;

            header('Location: /');
            return;
        }

        $error["password"] = "Invalid nick_name or password.";
        require "views/auth/Login.view.php";
    }

    public function registerUser()
    {
        // if (isset($_SESSION['logged_in'])) {
        //     header('Location: /');
        //     return;
        // }

        var_dump($_POST);
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $nick_name = $_POST['nick_name'];
        $password = $_POST['password'];
        $password_confirmation = $_POST['password_confirmation'];

        $error = [];

            // if (Validator::required($nick_name)) {
            //     $error["nick_name"] = "Name is required.";
            // }

            // if (!Validator::strLengt($nick_name, 3, 50)) {
            //     $error["nick_name"] = "Name must be between 3 and 50 characters long.";
            // }

            if (!Validator::passwordMatch($password, $password_confirmation)) {
                $error["password"] = "Passwords do not match.";
            }

            if (!Validator::passwordContains($password)) {
                $error["password"] = "Password must contain at least one number and one uppercase letter and one simbol.";
            }

            if (!Validator::passwordLength($password)) {
                $error["password"] = "Password must be at least 8 characters long.";
            }

            // if (!Validator::email($nick_name)) {
            //     $error["nick_name"] = "Email is not valid.";
            // }

            // if (Auth::emailExists($nick_name)) {
            //     $error["nick_name"] = "This email is already registered. Please use a different email.";
            // }



        // var_dump($error);

        if (empty($error)) {
            Auth::register($first_name, $nick_name, $password);
            header('Location: /');
        } else {
            require "views/auth/Register.view.php";
        }

    }



}
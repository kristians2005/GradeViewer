<?php

require_once "models/Users.php";

class UsersController
{

    public function index()
    {
        if (!Validator::Role('Admin')) {
            header("Location: /");
            exit();
        }
        $users = Users::all();
        require "views/users/index.view.php";
    }

    public function show()
    {
        if (!Validator::Role('Admin')) {
            header("Location: /");
            exit();
        }
        // require "views/users/show.view.php";
    }

    public function create()
    {
        if (!Validator::Role('Admin')) {
            header("Location: /");
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $roles = $_POST['roles'];

            Users::create([
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'roles' => $roles
            ]);

            header("Location: /users");
        }
        require "views/users/Create.view.php";
    }

    public function store()
    {
        if (!Validator::Role('Admin')) {
            header("Location: /");
            exit();
        }
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password_confirmation = $_POST['password_confirmation'];
        $roles = $_POST['roles'];

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
            header('Location: /users');
        } else {
            require "views/users/Create.view.php";
        }
    }

    public function edit()
    {
        if (!Validator::Role('Admin')) {
            header("Location: /");
            exit();
        }

        $id = $_GET['id'];
        $user = Users::find($id);
        require "views/users/Edit.view.php";
    }

    public function update()
    {
        if (!Validator::Role('Admin')) {
            header("Location: /");
            exit();
        }

        $id = $_GET['id'];
        $data = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'roles' => $_POST['roles']
        ];

        Users::updateUser($id, $data);

        // Update session if the updated user is the logged-in user
        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $id) {
            $_SESSION['user_name'] = $data['name'];
            $_SESSION['user_email'] = $data['email'];
            $_SESSION['user_role'] = $data['roles'];
        }

        header("Location: /users");
    }

    public function destroy()
    {
        if (!Validator::Role('Admin')) {
            header("Location: /");
            exit();
        }

        $id = $_GET['id'];
        Users::destroy($id);
        header("Location: /users");
    }
}
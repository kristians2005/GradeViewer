<?php

class SubjectsController
{
    public function index()
    {
<<<<<<< Updated upstream
        // if (isset($_SESSION)) {
        //     header('Location: /');
        //     return;
        // }

        require "views/subjects/index.view.php";
=======
        if (!isset($_SESSION['logged_in'])) {
            header('Location: /');
            return;
        }

        if ($_SESSION['user_role'] == 'teacher') {
            require "views/subjects/teacher/index.view.php";
            return;
        }

        if ($_SESSION['user_role'] == 'student') {
            $user_id = $_SESSION['user_id'];
            
            require_once "models/Users.php";
            
            $subjects = Users::getSubjectsWithGrades($user_id);            
            require "views/subjects/student/index.view.php";
            return;
        }
>>>>>>> Stashed changes
    }

}
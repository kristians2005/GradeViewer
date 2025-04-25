<?php


class SubjectsController
{


    public function index()
    {
        if (!isset($_SESSION['logged_in'])) {
            header('Location: /');
            return;
        }

        if ($_SESSION['user_role'] == 'teacher') {
            require "views/subjects/teacher/index.view.php";
            return;
        }

        if ($_SESSION['user_role'] == 'student') {
            require "views/subjects/student/index.view.php";
            return;
        }
        // require "views/subjects/student/index.view.php";




    }



}
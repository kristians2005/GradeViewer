<?php

require_once "models/subjects.php";

class SubjectsController
{


    public function index()
    {
        if (!isset($_SESSION['logged_in'])) {
            header('Location: /');
            return;
        }

        if ($_SESSION['user_role'] == 'teacher') {
            $students = Subjects::allStudents();
            $subjects = Subjects::getAllSubjects();
            $allSubjects = Subjects::getAllAvailableSubjects(); // Add this line

            require "views/home/teacher/index.view.php";
            return;
        }

        if ($_SESSION['user_role'] == 'student') {
            $user_id = $_SESSION['user_id'];

            require_once "models/Users.php";

            $subjects = Users::getSubjectsWithGrades($user_id);
            require "views/home/student/index.view.php";
            return;
        }

    }

    public function assign()
    {
        if (!isset($_SESSION['logged_in'])) {
            header('Location: /');
            return;
        }

        if (isset($_POST['subjects']) && is_array($_POST['subjects'])) {
            $successCount = 0;
            foreach ($_POST['subjects'] as $subjectId) {
                if (is_numeric($subjectId)) {  // Basic validation
                    if (Subjects::assignSubject($subjectId, $_SESSION['user_id'])) {
                        $successCount++;
                    }
                }
            }
            $_SESSION['message'] = "$successCount subjects assigned successfully";
        }

        header('Location: /home');
    }



}
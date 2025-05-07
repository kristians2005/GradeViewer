<?php

require_once "models/Student.php";

class StudentController
{
    public function dashboard()
    {
        if (!Validator::Role('student')) {
            header("Location: /");
            exit();
        }

        $user_id = $_SESSION['user_id'];
        $student_info = Student::getStudentInfo($user_id);
        
        if ($student_info) {
            $grades = Student::getStudentGrades($student_info['id']);
            $subjects = Student::getStudentSubjects($student_info['id']);
        }

        require "views/student/grades.view.php";
    }

    public function grades()
    {
        if (!Validator::Role('student')) {
            header("Location: /");
            exit();
        }

        $user_id = $_SESSION['user_id'];
        $student_info = Student::getStudentInfo($user_id);
        
        if ($student_info) {
            $grades = Student::getStudentGrades($student_info['id']);
        }

        require "views/student/grades.view.php";
    }

    public function subjects()
    {
        if (!Validator::Role('student')) {
            header("Location: /");
            exit();
        }

        $user_id = $_SESSION['user_id'];
        $student_info = Student::getStudentInfo($user_id);
        
        if ($student_info) {
            $subjects = Student::getStudentSubjects($student_info['id']);
        }

        require "views/student/subjects.view.php";
    }
} 
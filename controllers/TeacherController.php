<?php

require_once "models/Teacher.php";
require_once "middleware.php";

class TeacherController
{
    public function dashboard()
    {
        Middleware::isLoggedIn();
        Middleware::checkRole('teacher');

        $teacher_info = Teacher::getTeacherInfo($_SESSION['user_id']);
        $classes = Teacher::getTeacherClasses($_SESSION['user_id']);

        require_once "views/teacher/dashboard.view.php";
    }

    public function classes()
    {
        Middleware::isLoggedIn();
        Middleware::checkRole('teacher');

        $classes = Teacher::getTeacherClasses($_SESSION['user_id']);

        require_once "views/teacher/classes.view.php";
    }

    public function students($class_id = null)
    {
        Middleware::isLoggedIn();
        Middleware::checkRole('teacher');

        if (!$class_id) {
            header("Location: /teacher/classes");
            exit;
        }

        $students = Teacher::getClassStudents($class_id);
        $subjects = Teacher::getClassSubjects($class_id);

        require_once "views/teacher/students.view.php";
    }

    public function showAddStudent($class_id)
    {
        Middleware::isLoggedIn();
        Middleware::checkRole('teacher');

        $available_students = Teacher::getAvailableStudents($class_id);
        require_once "views/teacher/add-student.view.php";
    }

    public function addStudentToClass($class_id)
    {
        Middleware::isLoggedIn();
        Middleware::checkRole('teacher');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $student_id = $_POST['student_id'] ?? null;

            if ($student_id) {
                $result = Teacher::addStudentToClass($student_id, $class_id);
                if (!$result) {
                    $_SESSION['error'] = "This student already has a teacher assigned.";
                }
            }
        }

        header("Location: /teacher/students/{$class_id}");
        exit;
    }

    public function removeStudentFromClass($class_id, $student_id)
    {
        Middleware::isLoggedIn();
        Middleware::checkRole('teacher');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /teacher/students/{$class_id}");
            exit;
        }

        // Verify that the class belongs to this teacher
        $classes = Teacher::getTeacherClasses($_SESSION['user_id']);
        $class_exists = false;
        foreach ($classes as $class) {
            if ($class['id'] == $class_id) {
                $class_exists = true;
                break;
            }
        }

        if ($class_exists) {
            $result = Teacher::removeStudentFromClass($student_id, $class_id);
            if (!$result) {
                $_SESSION['error'] = "Failed to remove student from class.";
            }
        } else {
            $_SESSION['error'] = "You don't have permission to modify this class.";
        }

        header("Location: /teacher/students/{$class_id}");
        exit;
    }

    public function grades($student_id = null, $class_id = null)
    {
        Middleware::isLoggedIn();
        Middleware::checkRole('teacher');

        if (!$student_id || !$class_id) {
            header("Location: /teacher/classes");
            exit;
        }

        // Get student info
        $student = Teacher::getStudentInfo($student_id);
        if (!$student) {
            $_SESSION['error'] = "Student not found.";
            header("Location: /teacher/classes");
            exit;
        }

        // Get class info
        $class = Teacher::getClassInfo($class_id);
        if (!$class) {
            $_SESSION['error'] = "Class not found.";
            header("Location: /teacher/classes");
            exit;
        }

        // Verify that the class belongs to this teacher
        $classes = Teacher::getTeacherClasses($_SESSION['user_id']);
        $class_exists = false;
        foreach ($classes as $c) {
            if ($c['id'] == $class_id) {
                $class_exists = true;
                break;
            }
        }

        if (!$class_exists) {
            $_SESSION['error'] = "You don't have permission to view this class.";
            header("Location: /teacher/classes");
            exit;
        }

        $grades = Teacher::getStudentGrades($student_id, $class_id);
        $subjects = Teacher::getClassSubjects($class_id);
        
        // Calculate average grade
        $average_grade = 0;
        if (!empty($grades)) {
            $sum = array_sum(array_column($grades, 'grade'));
            $average_grade = $sum / count($grades);
        }

        // Set variables for the view
        $student_name = $student['first_name'] . ' ' . $student['last_name'];
        $class_name = $class['class_name'];

        require_once "views/teacher/grades.view.php";
    }

    public function addGrade()
    {
        Middleware::isLoggedIn();
        Middleware::checkRole('teacher');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $student_id = $_POST['student_id'] ?? null;
            $class_id = $_POST['class_id'] ?? null;
            $subject_id = $_POST['subject_id'] ?? null;
            $grade = $_POST['grade'] ?? null;
            $grade_date = $_POST['grade_date'] ?? date('Y-m-d');

            if ($student_id && $class_id && $subject_id && $grade) {
                $result = Teacher::addGrade($student_id, $subject_id, $grade, $grade_date);
                if ($result) {
                    $_SESSION['success'] = "Grade added successfully.";
                } else {
                    $_SESSION['error'] = "Failed to add grade.";
                }
                header("Location: /teacher/grades/{$student_id}/{$class_id}");
                exit;
            } else {
                $_SESSION['error'] = "All fields are required.";
            }
        }

        header("Location: /teacher/classes");
        exit;
    }

    public function updateGrade()
    {
        Middleware::isLoggedIn();
        Middleware::checkRole('teacher');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $grade_id = $_POST['grade_id'] ?? null;
            $grade = $_POST['grade'] ?? null;
            $grade_date = $_POST['grade_date'] ?? date('Y-m-d');

            if ($grade_id && $grade) {
                Teacher::updateGrade($grade_id, $grade, $grade_date);
            }
        }

        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }

    public function deleteGrade($grade_id)
    {
        Middleware::isLoggedIn();
        Middleware::checkRole('teacher');

        if ($grade_id) {
            Teacher::deleteGrade($grade_id);
        }

        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }

    public function subjects()
    {
        Middleware::isLoggedIn();
        Middleware::checkRole('teacher');

        $subjects = Teacher::getClassSubjects($_SESSION['user_id']);
        require_once "views/teacher/subjects.view.php";
    }

    public function addSubject()
    {
        Middleware::isLoggedIn();
        Middleware::checkRole('teacher');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $subject_name = $_POST['subject_name'] ?? '';
            $class_id = $_POST['class_id'] ?? null;

            if (empty($subject_name)) {
                $_SESSION['error'] = "Subject name is required.";
            } else {
                $result = Teacher::addSubject($subject_name, $class_id);
                if ($result) {
                    $_SESSION['success'] = "Subject added successfully.";
                } else {
                    $_SESSION['error'] = "Failed to add subject.";
                }
            }
        }

        header("Location: /teacher/subjects");
        exit;
    }

    public function updateSubject()
    {
        Middleware::isLoggedIn();
        Middleware::checkRole('teacher');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $subject_id = $_POST['subject_id'] ?? null;
            $subject_name = $_POST['subject_name'] ?? '';

            if (empty($subject_name)) {
                $_SESSION['error'] = "Subject name is required.";
            } else {
                $result = Teacher::updateSubject($subject_id, $subject_name);
                if ($result) {
                    $_SESSION['success'] = "Subject updated successfully.";
                } else {
                    $_SESSION['error'] = "Failed to update subject.";
                }
            }
        }

        header("Location: /teacher/subjects");
        exit;
    }

    public function deleteSubject($subject_id)
    {
        Middleware::isLoggedIn();
        Middleware::checkRole('teacher');

        if ($subject_id) {
            $result = Teacher::deleteSubject($subject_id);
            if ($result) {
                $_SESSION['success'] = "Subject deleted successfully.";
            } else {
                $_SESSION['error'] = "Failed to delete subject.";
            }
        }

        header("Location: /teacher/subjects");
        exit;
    }
} 
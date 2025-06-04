<?php

require_once "libs/fpdf.php";
require_once "middleware.php";

class StudentsPDF extends FPDF {
    function Header() {
        // Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        
        // Title
        $this->Cell(0, 10, 'Class Students Report', 0, 1, 'C');
        
        // Line break
        $this->Ln(10);

        // Table header
        $this->SetFont('Arial', 'B', 12);
        $this->SetFillColor(200, 220, 255);
        $this->Cell(100, 8, 'Student Name', 1, 0, 'L', true);
        $this->Cell(90, 8, 'Class Average', 1, 1, 'C', true);
    }

    function Footer() {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

class StudentGradesPDF extends FPDF {
    function Header() {
        // Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        
        // Title
        $this->Cell(0, 10, 'Student Grades Report', 0, 1, 'C');
        
        // Line break
        $this->Ln(10);

        // Table header
        $this->SetFont('Arial', 'B', 12);
        $this->SetFillColor(200, 220, 255);
        $this->Cell(80, 8, 'Subject', 1, 0, 'L', true);
        $this->Cell(40, 8, 'Grade', 1, 0, 'C', true);
        $this->Cell(70, 8, 'Date', 1, 1, 'C', true);
    }

    function Footer() {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

class ExportPDFController {
    public function exportStudentsList($class_id) {
        Middleware::isLoggedIn();
        Middleware::checkRole('teacher');

        require_once "models/Teacher.php";
        
        // Get students using Teacher model's static method
        $students = Teacher::getClassStudents($class_id);
        
        // Get class info for the report title
        $class = Teacher::getClassInfo($class_id);
        
        $pdf = new StudentsPDF();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        
        // Add class name to the report
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 8, 'Class: ' . $class['class_name'], 0, 1, 'L');
        $pdf->Ln(4);
        
        $pdf->SetFont('Arial', '', 12);

        foreach ($students as $student) {
            $fullName = $student['first_name'] . ' ' . $student['last_name'];
            if ($student['nick_name']) {
                $fullName .= ' (' . $student['nick_name'] . ')';
            }
            
            $average = number_format($student['class_average'] ?? 0, 2);
            
            // Add row
            $pdf->Cell(100, 8, $fullName, 1);
            $pdf->Cell(90, 8, $average, 1, 1, 'C');
        }

        // Output the PDF
        $pdf->Output('D', 'students_report.pdf');
    }

    public function exportStudentGrades() {
        Middleware::isLoggedIn();
        Middleware::checkRole('student');

        require_once "models/Student.php";
        
        // Get student info and grades
        $student_info = Student::getStudentInfo($_SESSION['user_id']);
        $grades = Student::getStudentGrades($student_info['id']);
        
        $pdf = new StudentGradesPDF();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        
        // Add student info to the report
        $pdf->SetFont('Arial', 'B', 12);
        $fullName = $student_info['first_name'] . ' ' . $student_info['last_name'];
        if ($student_info['nick_name']) {
            $fullName .= ' (' . $student_info['nick_name'] . ')';
        }
        $pdf->Cell(0, 8, 'Student: ' . $fullName, 0, 1, 'L');
        
        if ($student_info['class_name']) {
            $pdf->Cell(0, 8, 'Class: ' . $student_info['class_name'], 0, 1, 'L');
        }
        
        if ($student_info['teacher_first_name']) {
            $teacher_name = $student_info['teacher_first_name'] . ' ' . $student_info['teacher_last_name'];
            $pdf->Cell(0, 8, 'Teacher: ' . $teacher_name, 0, 1, 'L');
        }
        
        $pdf->Ln(4);
        
        $pdf->SetFont('Arial', '', 12);
        
        // Calculate overall average
        $total = 0;
        $count = count($grades);
        
        foreach ($grades as $grade) {
            $total += $grade['grade'];
            
            $pdf->Cell(80, 8, $grade['subject_name'], 1);
            $pdf->Cell(40, 8, number_format($grade['grade'], 2), 1, 0, 'C');
            $pdf->Cell(70, 8, date('F j, Y', strtotime($grade['grade_date'])), 1, 1, 'C');
        }
        
        // Add overall average if there are grades
        if ($count > 0) {
            $pdf->Ln(4);
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(0, 8, 'Overall Average: ' . number_format($total / $count, 2), 0, 1, 'L');
        }

        // Output the PDF
        $pdf->Output('D', 'my_grades_report.pdf');
    }
} 
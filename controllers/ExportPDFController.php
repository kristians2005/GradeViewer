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
} 
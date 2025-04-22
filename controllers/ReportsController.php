<?php

require_once __DIR__ . '/../models/Orders.php';
require_once __DIR__ . '/../libs/fpdf.php';

class ReportsController
{
    private $orderModel;

    public function __construct()
    {
        $this->orderModel = new Order();
    }

    public function generateOrdersReport()
    {
        $orders = $this->orderModel->getAllOrders();

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);

        $pdf->Cell(190, 10, 'Orders Report', 1, 1, 'C');
        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(30, 10, 'Order ID', 1);
        $pdf->Cell(50, 10, 'User', 1);
        $pdf->Cell(50, 10, 'Product', 1);
        $pdf->Cell(20, 10, 'Qty', 1);
        $pdf->Cell(30, 10, 'Status', 1);
        $pdf->Ln();

        $pdf->SetFont('Arial', '', 12);
        foreach ($orders as $order) {
            $pdf->Cell(30, 10, $order['id'], 1);
            $pdf->Cell(50, 10, $order['user_name'] ?? 'Guest', 1);
            $pdf->Cell(50, 10, $order['product_name'], 1);
            $pdf->Cell(20, 10, $order['quantity'], 1);
            $pdf->Cell(30, 10, ucfirst($order['status']), 1);
            $pdf->Ln();
        }

        $pdf->Output('D', 'orders_report.pdf');
    }
}

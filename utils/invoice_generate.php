<?php
session_start();
require('../fpdf/fpdf.php');
include 'db_connection.php';

class PDF extends FPDF
{
    // Page header
    function Header()
    {
        $this->Image('../images/logo.jpeg', 10, 6, 30);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Cell(30, 10, 'Invoice', 0, 0, 'C');
        // Line break
        $this->Ln(20);

        // Add the date
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 10, 'Invoice Date: ' . date('Y-m-d'), 0, 1, 'R');
    }

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

// Create a new PDF instance
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

// Check if the order ID is set in the session
if (!isset($_SESSION['order_id'])) {
    // If not set, check if the order ID is present in the query parameters
    if (isset($_GET['order_id'])) {
        // Retrieve the order ID from the query parameter
        $order_id = $_GET['order_id'];
        // Set the order ID in the session
        $_SESSION['order_id'] = $order_id;
    } else {
        // Handle the case where neither session nor query parameter has the order ID
        // You can redirect the user or show an error message
        echo "Order ID is not set.";
        exit(); // Stop further execution
    }
} else {
    // If the order ID is already set in the session, retrieve it from there
    $order_id = $_SESSION['order_id'];
}

// Prepare and execute the query
$stmt = $conn->prepare("CALL GetOrderDetailsByOrderGroupId(:order_id)");
$stmt->bindParam(':order_id', $order_id, PDO::PARAM_STR);
$stmt->execute();
$orderDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Output order details in a table format
$pdf->SetFont('Arial', 'B', 10);
$pdf->Ln(10);
$pdf->Cell(50, 10, 'Customer Name:', 0, 0, 'L');
$pdf->Cell(0, 10, $orderDetails[0]['customer_name'], 0, 1, 'L');
$pdf->Cell(50, 10, 'Email:', 0, 0, 'L');
$pdf->Cell(0, 10, $orderDetails[0]['customer_email'], 0, 1, 'L');
$pdf->Ln(10);

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(125, 10, 'Item Name', 1, 0, 'C');
$pdf->Cell(20, 10, 'Unit Price', 1, 0, 'C');
$pdf->Cell(10, 10, 'Qty', 1, 0, 'C');
$pdf->Cell(25, 10, 'Total Price', 1, 1, 'C');

$grandTotal = 0;
foreach ($orderDetails as $row) {
    $totalPrice = $row['product_price'] * $row['quantity'];
    $grandTotal += $totalPrice;
    $pdf->Cell(125, 10, $row['product_name'], 1, 0, 'L');
    $pdf->Cell(20, 10, '$' . number_format($row['product_price'], 2), 1, 0, 'C');
    $pdf->Cell(10, 10, $row['quantity'], 1, 0, 'C');
    $pdf->Cell(25, 10, '$' . number_format($totalPrice, 2), 1, 1, 'C');
}



$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(90, 10, 'Grand Total:', 1, 0, 'C');
$pdf->Cell(90, 10, '$' . number_format($grandTotal, 2), 1, 1, 'R');
$pdf->Ln(10);
$pdf->Cell(180, 10, 'For Oven Store', 0, 0, 'R');
$pdf->Ln(10);
$pdf->Cell(180, 10, 'Sd/-     ', 0, 0, 'R');
$pdf->Output();
$_SESSION['cart'] = [];

<?php
include 'config.php';
require('fpdf/fpdf.php');

$id = $_GET['id'] ?? '';

if(!$id){
    die("Invalid ID");
}

$q = $conn->query("SELECT * FROM bookings WHERE id='$id'");

if(!$q || $q->num_rows == 0){
    die("No data found");
}

$data = $q->fetch_assoc();
$from_time = isset($data['from_time']) ? $data['from_time'] : 'N/A';
$to_time   = isset($data['to_time']) ? $data['to_time'] : 'N/A';
$pdf = new FPDF();
$pdf->AddPage();

// 🔥 OUTER BOX
$pdf->SetDrawColor(0,0,0);
$pdf->Rect(10,20,190,120); // x, y, width, height

// 🔥 TITLE
$pdf->SetY(25);
$pdf->SetFont('Arial','B',18);
$pdf->Cell(0,10,'Parking Receipt',0,1,'C');

$pdf->Ln(5);

// 🔥 LINE
$pdf->Line(10,35,200,35);

$pdf->Ln(5);

// 🔥 CONTENT
$pdf->SetFont('Arial','',12);

$pdf->Cell(60,10,'Booking ID:',0,0);
$pdf->Cell(100,10,$data['id'],0,1);

$pdf->Cell(60,10,'Slot Number:',0,0);
$pdf->Cell(100,10,$data['slot_number'],0,1);

$pdf->Cell(60,10,'Location:',0,0);
$pdf->Cell(100,10,$data['location'],0,1);

$pdf->Cell(60,10,'From Date:',0,0);
$pdf->Cell(100,10,$data['from_date'],0,1);

$pdf->Cell(60,10,'To Date:',0,0);
$pdf->Cell(100,10,$data['to_date'],0,1);

$pdf->Cell(60,10,'From Time:',0,0);
$pdf->Cell(100,10,$from_time,0,1);

$pdf->Cell(60,10,'To Time:',0,0);
$pdf->Cell(100,10,$to_time,0,1);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(60,10,'Amount:',0,0);
$pdf->Cell(100,10,'Rs '.$data['amount'],0,1);

$pdf->Ln(10);


$pdf->SetY(145); 

$pdf->Line(10,145,200,145);

$pdf->Ln(2);

$pdf->SetFont('Arial','I',10);
$pdf->Cell(0,10,'Thank you for booking!',0,1,'C');


$pdf->Output('D', 'receipt_'.$id.'.pdf');
?>
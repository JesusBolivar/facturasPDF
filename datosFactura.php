<?php
require('fpdf.php');
include 'dbConfig.php';
include 'Cart.php';
$cart = new Cart;
$_SESSION['sessCustomerID'] = 1;
$query = $db->query("SELECT * FROM usuarios WHERE idusuario = ".$_SESSION['sessCustomerID']);
$custRow = $query->fetchColumn();
if($cart->total_items() > 0){
    $cartItems = $cart->contents();
}
ob_start();
class PDF extends FPDF{
function Header()
{
    $this->SetFont('Arial','B',15);
    $this->Cell(80);
    $this->Cell(54,10,'Factura',1,0,'C');
    $this->Ln(20);
}
function Footer(){
    $this->SetY(-15);
    $this->SetFont('Arial','I',8);
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
foreach($cartItems as $item){
$nombre = $item["name"];
$precio = $item["price"];
$cantidad = $item["qty"];
$total = $item["subtotal"];
$contador=10;
$pdf->cell(0,$contador,"Nombre producto:  " . $nombre,0,'L');
    $pdf->setXY(5,30);
    $contador=$contador+10;
$pdf->cell(0,$contador,"Precio producto:  " . $precio,0,'L');
    $pdf->setXY(5,30);
    $contador=$contador+10;
$pdf->cell(0,$contador,"Cantidad productos:  " . $cantidad,0,'L');
    $pdf->setXY(5,30);
    $contador=$contador+10;
$pdf->cell(0,$contador,"Precio final:  " . $total,0,'L');
    $pdf->setXY(5,30);
    $contador=$contador+10;   
}
$pdf->Output();                                   
?>
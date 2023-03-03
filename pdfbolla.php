<?php

require 'lib/fpdf.php';
include 'parts/pages/fun.php';

$bolla = $_GET['bolla'];
$dettagli = tellMeDettagliBolla($bolla);
$id_macchine = json_decode($dettagli[0][4]);
$veicoli = tellMeMacchineBolla($id_macchine);

//data
$data_bolla = $dettagli[0][2];
$data_cut = explode('-', substr($data_bolla, 0, 10));
$ora_cut = explode(':', substr($data_bolla, -8));

//destinatario

$dati_destinatario = json_decode($dettagli[0][5]);
$luogo_destinazione = json_decode($dettagli[0][6]);

//sede
$sede = tellMeDettagliSede($dettagli[0][3]);


class PDF extends FPDF{
  protected $FontSpacingPt;      
  protected $FontSpacing;      

  function SetFontSpacing($size)
  {
    if($this->FontSpacingPt==$size)
      return;
    $this->FontSpacingPt = $size;
    $this->FontSpacing = $size/$this->k;
    if ($this->page>0)
      $this->_out(sprintf('BT %.3f Tc ET', $size));
  }
  // public function Header()
  // {

  // }

  public function Footer()
  {
    $this->SetY(-15);
    $this->SetFont('HelI', 'I', 8);
    $this->Cell(0, 10, 'Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
  }
}
$pdf = new PDF('P', 'mm', 'A4');
$coloretesto = [0,0,0];

//nome pagina
$pdf->SetTitle("BOLLA ".$dettagli[0][1]." ".$dati_destinatario[0]." ".$data_cut[2]."/".$data_cut[1]."");



//Helvetica mancanti
$pdf->AddFont('HelThin','','HelveticaNeue-Thin.php');

$pdf->AddFont('HelI','I','HelveticaNeue-CondensedObl.php');
$pdf->AddFont('HelB','B','HelveticaNeue-HeavyCond.php');
$pdf->AddFont('HelGiusto','','HelveticaNeue-Condensed.php');

$pdf->AddPage();
$pdf->SetDisplayMode('real');

$pdf->Image('img/bolla.png', 0, 0, 210,297);
$pdf->AliasNbPages();

//CORPO
$pdf->SetTextColor($coloretesto[0], $coloretesto[1], $coloretesto[2]);

$x = $pdf->GetX();
$y = $pdf->GetY();


//NUMERO

$pdf->SetXY($x + 105, $y + 14);
$pdf->SetFont('HelB', 'B', 15);
$pdf->MultiCell(72,8,$dettagli[0][1], 0, 'L');

//DATA
//GIORNO
$pdf->SetXY($x + 151.5, $y + 14);
$pdf->SetFont('HelB', 'B', 15);
$pdf->MultiCell(72,8,$data_cut[2], 0, 'L');
//MESE
$pdf->SetXY($x + 162, $y + 14);
$pdf->SetFont('HelB', 'B', 15);
$pdf->MultiCell(72,8,$data_cut[1], 0, 'L');
//ANNO
$pdf->SetXY($x + 172, $y + 14);
$pdf->SetFont('HelB', 'B', 15);
$pdf->SetFontSpacing(3);
$pdf->MultiCell(72,8,$data_cut[0], 0, 'L');
$pdf->SetFontSpacing(0);

//NOME DESTINATARIO

$pdf->SetXY( 6.5, $y + 30);
$pdf->SetFont('HelGiusto', '', 10);
$pdf->MultiCell(72,8,strtoupper($dati_destinatario[0]), 0, 'L');

// LUOGO DI DESTINAZIONE VIA

$pdf->SetXY($x + 97, $y + 30);
$pdf->SetFont('HelGiusto', '', 10);
$pdf->MultiCell(100,8,strtoupper("Via ".$luogo_destinazione[0].", ".$luogo_destinazione[1]." ( ".$luogo_destinazione[2]." ) ".$luogo_destinazione[3]), 0, 'L');

//Indirizzo

$pdf->SetXY( 6.5, $y + 40);
$pdf->SetFont('HelGiusto', '', 10);
$pdf->MultiCell(100,8,strtoupper("Via ".$dati_destinatario[1].", ".$dati_destinatario[2]." ( ".$dati_destinatario[3]." ) ".$dati_destinatario[4]), 0, 'L');

//Piva
$pdf->SetXY( 6.5, $y + 50);
$pdf->SetFont('HelGiusto', '', 10);
$pdf->MultiCell(72,8,$dati_destinatario[5], 0, 'L');

//CAUSALE
$pdf->SetXY( 6.5, $y + 65);
$pdf->SetFont('HelGiusto', '', 10);
$pdf->MultiCell(200,8,strtoupper($dettagli[0][7]), 0, 'L');

//VETTORI
$pdf->SetXY($x + 1,  247);
$pdf->SetFont('HelGiusto', '', 9);
$pdf->MultiCell(200,8,$dettagli[0][8], 0, 'L');

//DATA E ORA FOOTER
//GIORNO
$pdf->SetXY(92, 252);
$pdf->SetFont('HelGiusto', '', 15);
$pdf->MultiCell(72,8,$data_cut[2], 0, 'L');
//MESE
$pdf->SetXY(101.5, 252);
$pdf->MultiCell(72,8,$data_cut[1], 0, 'L');
//ANNO
$pdf->SetXY(111, 252);
$pdf->MultiCell(72,8,substr($data_cut[0], -2), 0, 'L');
//ORE
$pdf->SetXY(122, 252);
$pdf->MultiCell(72,8,$ora_cut[0], 0, 'L');
//MINUTI
$pdf->SetXY(131.8, 252);
$pdf->MultiCell(72,8,$ora_cut[1], 0, 'L');


//ANNOTAZIONI
$pdf->SetXY($x + 1,  263);
$pdf->SetFont('HelGiusto', '', 9);
$pdf->MultiCell(200,8,strtoupper($dettagli[0][9]), 0, 'L');


$y_veicoli = 90;

foreach($veicoli as $v){
  
  $pdf->SetXY( 6.5,  $y_veicoli);
  $pdf->SetFont('HelGiusto', '', 9);
  
  
  $acc = '';
  if($v[12] == 1){
    $acc = $acc." Doppia chiave |";
  }  
  if($v[13] == 1){
    $acc = $acc." Libretto |";
  }  
  if($v[14] == 1){
    $acc = $acc." Sd Card |";
  }  
  if($v[15] == 1){
    $acc = $acc." Tappetini |";
  }  
  if($v[16] == 1){
    $acc = $acc." Ruota di Scorta/Kit Gonfiaggio |";
  }  
  if($v[17] == 1){
    $acc = $acc." Antenna |";
  }  
  if($v[18] == 1){
    $acc = $acc." Libretto uso e manutenzione |";
  }  
  if($v[3] == 'DISSEQUESTRO'){
    $stato = 'USATO';
  }else{
    $stato = $v[3]; 
  }
  $testo = htmlspecialchars_decode('&gt;')." ".$stato." ".$v[6]." ".$v[7]." ".$v[4]." ".$v[5]." |  $acc ".$v[21];
  $times = round(strlen($testo)/100, 0, PHP_ROUND_HALF_UP);
  if($times == 1){
    $times++;
  }
  if($times == 0){
    $times++;
  }
  
  $y_veicoli = $y_veicoli + 8.5 * $times;
  
  $pdf->MultiCell(198,8,strtoupper($testo), 0, 'L');
  
}

//SEDE
$pdf->SetXY(6.5 ,  29);
$pdf->SetFontSpacing(0.4);
$pdf->SetFont('HelGiusto', '', 7.5);
$pdf->SetTextColor(255, 255, 255);
$pdf->MultiCell(200,8,$sede[0][6]." ".$sede[0][9].", ".$sede[0][10]." ".$sede[0][7]." ".$sede[0][8]." Telefono: ".$sede[0][11]." ".$sede[0][12], 0, 'L');

$datapdf = "fesfse";

// $file = $_SERVER['DOCUMENT_ROOT']."/bgest/bolle/$datapdf.pdf";
$file = $_SERVER['DOCUMENT_ROOT']."/bolle/$datapdf.pdf";

$pdf->Output($file, "F");
$pdf->Output("BOLLA-".$dettagli[0][1]."-".$dati_destinatario[0]."-".$data_cut[2]."_".$data_cut[1].".pdf", "I");

?>
